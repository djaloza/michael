<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$host = "localhost";
$db   = "michael_iep";
$user = "hubuser";
$pass = "@2R0land0f3ld";

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

    if (!in_array($scope, ['test', 'all']) || !in_array($dataset, ['story', 'math', 'all'])) {
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
        $pdo->exec("DELETE FROM clock_responses" . ($scope === 'test' ? " WHERE 1=0" : ""));
    }
    if ($dataset === 'shapes' || $dataset === 'all') {
        $pdo->exec("DELETE FROM shapes_responses" . ($scope === 'test' ? " WHERE 1=0" : ""));
    }
    if ($dataset === 'vocabulary' || $dataset === 'all') {
        $pdo->exec("DELETE FROM vocabulary_responses" . ($scope === 'test' ? " WHERE 1=0" : ""));
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
} else {
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
}

echo json_encode(["status" => "ok"]);
?>
