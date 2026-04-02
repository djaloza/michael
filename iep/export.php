<?php
$host = "localhost";
$db   = "michael_iep";
$user = "hubuser";
$pass = "@2R0land0f3ld";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB connection failed");
}

$type = isset($_GET['type']) ? $_GET['type'] : 'story';
$from = isset($_GET['from']) ? $_GET['from'] : '';
$to   = isset($_GET['to'])   ? $_GET['to']   : '';

$filename = "michael_iep_" . $type . "_" . date("Y-m-d") . ".csv";
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=\"$filename\"");

$out = fopen("php://output", "w");

if ($type === 'math') {
    fputcsv($out, ["ID", "Date", "Time", "Category", "Question", "Correct Answer", "Answer Given", "Correct", "Response Time (sec)", "Tokens Earned", "Session ID"]);
    $sql = "SELECT id, date, time, category, question, correct_answer, answer_given, correct, response_time_sec, tokens_earned, session_id FROM math_responses WHERE 1=1";
    if ($from) $sql .= " AND date >= '$from'";
    if ($to)   $sql .= " AND date <= '$to'";
    $sql .= " ORDER BY created_at ASC";
    $rows = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
        $row['correct'] = $row['correct'] ? 'YES' : 'NO';
        fputcsv($out, array_values($row));
    }
} else {
    fputcsv($out, ["ID", "Date", "Time", "Story", "Question #", "Question Type", "Question", "Answer Given", "Correct", "Response Time (sec)", "Tokens Earned", "Session ID"]);
    $sql = "SELECT id, date, time, story, question_num, question_type, question, answer_given, correct, response_time_sec, tokens_earned, session_id FROM story_responses WHERE 1=1";
    if ($from) $sql .= " AND date >= '$from'";
    if ($to)   $sql .= " AND date <= '$to'";
    $sql .= " ORDER BY created_at ASC";
    $rows = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
        $row['correct'] = $row['correct'] ? 'YES' : 'NO';
        fputcsv($out, array_values($row));
    }
}

fclose($out);
?>
