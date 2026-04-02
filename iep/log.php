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

$source = isset($data['appSource']) ? $data['appSource'] : 'story';

if ($source === 'math') {
    $sql = "INSERT INTO math_responses 
            (date, time, category, question, correct_answer, answer_given, correct, response_time_sec, tokens_earned, session_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
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
        $data['sessionId']
    ]);
} else {
    $sql = "INSERT INTO story_responses 
            (date, time, story, question_num, question_type, question, answer_given, correct, response_time_sec, tokens_earned, session_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
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
        $data['sessionId']
    ]);
}

echo json_encode(["status" => "ok"]);
?>
