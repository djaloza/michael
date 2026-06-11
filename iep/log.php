<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '/home/djaloza/config.php';
$host = DB_HOST;
$db   = "michael_iep";
$user = DB_USER;
$pass = DB_PASS;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "DB connection failed"]);
    exit();
}

$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

if (!$data) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON"]);
    exit();
}

// ── CLEAR ACTION ──────────────────────────────────────────────
if (isset($data['action']) && $data['action'] === 'clear') {
    $scope   = $data['scope']   ?? '';   // 'test' or 'all'
    $dataset = $data['dataset'] ?? 'all'; // 'story', 'math', or 'all'

    if (!in_array($scope, ['test', 'all']) || !in_array($dataset, ['story', 'math', 'clock', 'shapes', 'vocabulary', 'all'])) {
        echo json_encode(["status" => "error", "message" => "Invalid scope or dataset"]);
        exit();
    }

    $where = $scope === 'test' ? 'WHERE is_test = 1' : '';

    if ($dataset === 'story' || $dataset === 'all') {
        $pdo->exec("DELETE FROM story_responses $where");
    }
    if ($dataset === 'math' || $dataset === 'all') {
        $pdo->exec("DELETE FROM math_responses $where");
    }
    if ($dataset === 'clock' || $dataset === 'all') {
        $pdo->exec("DELETE FROM clock_responses" . ($scope === 'test' ? " WHERE is_test = 1" : ""));
    }
    if ($dataset === 'shapes' || $dataset === 'all') {
        $pdo->exec("DELETE FROM shapes_responses" . ($scope === 'test' ? " WHERE is_test = 1" : ""));
    }
    if ($dataset === 'vocabulary' || $dataset === 'all') {
        $pdo->exec("DELETE FROM vocabulary_responses" . ($scope === 'test' ? " WHERE is_test = 1" : ""));
    }

    echo json_encode(["status" => "ok"]);
    exit();
}

// ── LOG ANSWER ────────────────────────────────────────────────
$source  = isset($data['appSource']) ? $data['appSource'] : 'story';
$is_test = !empty($data['isTest']) ? 1 : 0;

if ($source === 'clock') {
    $sql = "INSERT INTO clock_responses
            (date, time, question_type, time_shown, answer_given, correct, response_time_sec, tokens_earned, session_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $data['date'],
        $data['time'],
        $data['questionType'],
        $data['timeShown'],
        $data['answerGiven'],
        $data['correct'] ? 1 : 0,
        $data['responseTimeSec'],
        $data['tokensEarned'],
        $data['sessionId']
    ]);
} elseif ($source === 'shapes') {
    $sql = "INSERT INTO shapes_responses
            (date, time, mode, question, answer_given, correct, response_time_sec, tokens_earned, session_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $data['date'],
        $data['time'],
        $data['mode'],
        $data['question'],
        $data['answerGiven'],
        $data['correct'] ? 1 : 0,
        $data['responseTimeSec'],
        $data['tokensEarned'],
        $data['sessionId']
    ]);
} elseif ($source === 'vocabulary') {
    $sql = "INSERT INTO vocabulary_responses
            (date, time, word, sentence_shown, answer_given, correct, response_time_sec, tokens_earned, session_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $data['date'],
        $data['time'],
        $data['word'],
        $data['sentenceShown'],
        $data['answerGiven'],
        $data['correct'] ? 1 : 0,
        $data['responseTimeSec'],
        $data['tokensEarned'],
        $data['sessionId']
    ]);
} elseif ($source === 'math') {
    // Primary insert into legacy math_responses
    $sql = "INSERT INTO math_responses
            (date, time, category, question, correct_answer, answer_given, correct, response_time_sec, tokens_earned, session_id, is_test)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $data['date'],
        $data['time'],
        $data['category'],
        $data['question'],
        $data['correctAnswer'],
        $data['answerGiven'],
        $data['correct'] ? 1 : 0,
        $data['responseTimeSec'],
        $data['tokensEarned'],
        $data['sessionId'],
        $is_test
    ]);

    // Also log to 2027 table by sub_type/category
    $mathGoalMap = ['addition' => 'SAI3', 'capacity' => 'SAI4', 'subtraction' => 'SAI5',
                    'ADDITION' => 'SAI3', 'CAPACITY' => 'SAI4', 'SUBTRACTION' => 'SAI5',
                    'LENGTH' => 'SAI4', 'WIDTH' => 'SAI4'];
    $subType = strtolower($data['category'] ?? '');
    $goalCode27 = $mathGoalMap[$data['category'] ?? ''] ?? null;
    if ($goalCode27 && !$is_test) {
        try {
            $stmt27 = $pdo->prepare("INSERT INTO iep_2027_responses
                (date, time, goal_code, sub_type, question, answer_given, correct, response_time_sec, session_id)
                VALUES (?,?,?,?,?,?,?,?,?)");
            $stmt27->execute([
                $data['date'],
                $data['time'],
                $goalCode27,
                $subType,
                $data['question'],
                $data['answerGiven'],
                $data['correct'] ? 1 : 0,
                $data['responseTimeSec'],
                $data['sessionId']
            ]);
        } catch (Exception $e) { /* silent fail */ }
    }
} elseif ($source === 'language') {
    // Language Time app — SLP goals
    $goalMap = [
        'pronouns'       => 'SLP1',
        'prepositions'   => 'SLP2',
        'functional_comm'=> 'SLP3',
        'turn_taking'    => 'SLP4'
    ];
    $mode     = $data['mode'] ?? '';
    $goalCode = $goalMap[$mode] ?? 'SLP1';
    try {
        $stmt = $pdo->prepare("INSERT INTO iep_2027_responses
            (date, time, goal_code, sub_type, question, answer_given, correct, response_time_sec, session_id)
            VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->execute([
            $data['date'] ?? date('n/j/Y'),
            $data['time'] ?? date('g:i A'),
            $goalCode,
            $mode,
            $data['question'] ?? '',
            $data['answerGiven'] ?? '',
            !empty($data['correct']) ? 1 : 0,
            $data['responseTimeSec'] ?? 0,
            $data['sessionId'] ?? ''
        ]);
    } catch (Exception $e) { /* silent fail */ }
} elseif ($source === 'firstthen') {
    try {
        $stmt = $pdo->prepare("INSERT INTO firstthen_sessions
            (date, time, first_activity, then_activity, completed)
            VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['date']          ?? date('n/j/Y'),
            $data['time']          ?? date('g:i A'),
            $data['firstActivity'] ?? '',
            $data['thenActivity']  ?? '',
            !empty($data['completed']) ? 1 : 0,
        ]);
    } catch (Exception $e) { /* silent fail — schema may differ */ }
} elseif ($source === 'story_sequence') {
    // Story sequencing — SAI2
    try {
        $stmt = $pdo->prepare("INSERT INTO iep_2027_responses
            (date, time, goal_code, sub_type, question, answer_given, correct, response_time_sec, session_id)
            VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->execute([
            $data['date'] ?? date('n/j/Y'),
            $data['time'] ?? date('g:i A'),
            'SAI2',
            'sequence',
            $data['question'] ?? '',
            $data['answerGiven'] ?? '',
            !empty($data['correct']) ? 1 : 0,
            $data['responseTimeSec'] ?? 0,
            $data['sessionId'] ?? ''
        ]);
    } catch (Exception $e) { /* silent fail */ }
} else {
    // Default: story app
    $sql = "INSERT INTO story_responses
            (date, time, story, question_num, question_type, question, answer_given, correct, response_time_sec, tokens_earned, session_id, is_test)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $data['date'],
        $data['time'],
        $data['story'],
        $data['questionNum'],
        $data['questionType'],
        $data['question'],
        $data['answerGiven'],
        $data['correct'] ? 1 : 0,
        $data['responseTimeSec'],
        $data['tokensEarned'],
        $data['sessionId'],
        $is_test
    ]);

    // Also log HOW/WHY to 2027 table for SAI1
    $qType = $data['questionType'] ?? '';
    if (in_array($qType, ['HOW', 'WHY']) && !$is_test) {
        try {
            $stmt27 = $pdo->prepare("INSERT INTO iep_2027_responses
                (date, time, goal_code, sub_type, question, answer_given, correct, response_time_sec, session_id)
                VALUES (?,?,?,?,?,?,?,?,?)");
            $stmt27->execute([
                $data['date'],
                $data['time'],
                'SAI1',
                $qType,
                $data['question'],
                $data['answerGiven'],
                $data['correct'] ? 1 : 0,
                $data['responseTimeSec'],
                $data['sessionId']
            ]);
        } catch (Exception $e) { /* silent fail */ }
    }
}

echo json_encode(["status" => "ok"]);
?>
