<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Michael's IEP Dashboard 2026-2027</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800;900&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: 'Nunito', sans-serif; background: #1a1a2e; color: #E8EEF8; }
  .header { background: #16213e; color: white; padding: 20px 32px; display: flex; align-items: center; justify-content: space-between; border-bottom: 3px solid #0f3460; flex-wrap: wrap; gap: 12px; }
  .header h1 { font-size: 24px; font-weight: 900; color: #5B8DEF; }
  .header p { font-size: 14px; opacity: 0.75; margin-top: 4px; }
  .export-bar { background: #16213e; padding: 14px 32px; border-bottom: 2px solid #0f3460; display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
  .export-bar label { font-size: 13px; font-weight: 700; color: #9CA3AF; }
  .btn { font-family: 'Nunito', sans-serif; font-size: 13px; font-weight: 800; padding: 7px 16px; border-radius: 16px; border: none; cursor: pointer; color: white; text-decoration: none; display: inline-block; }
  .btn-blue { background: #5B8DEF; }
  .btn-green { background: #06D6A0; color: #065F46; }
  .btn-orange { background: #FF9F1C; }
  .btn-red { background: #EF476F; }
  .btn-gray { background: #4b5563; }
  .content { max-width: 1200px; margin: 0 auto; padding: 28px 20px; }
  .section { background: #16213e; border-radius: 18px; padding: 24px; border: 2px solid #0f3460; margin-bottom: 20px; }
  .section h2 { font-size: 18px; font-weight: 900; color: #E8EEF8; margin-bottom: 16px; }
  table { width: 100%; border-collapse: collapse; font-size: 13px; }
  th { background: #0f3460; font-weight: 800; padding: 10px 12px; text-align: left; color: #9CA3AF; border-bottom: 2px solid #1a1a2e; }
  td { padding: 9px 12px; border-bottom: 1px solid #0f3460; color: #D1D5DB; }
  tr:last-child td { border-bottom: none; }
  .badge { display: inline-block; padding: 3px 10px; border-radius: 10px; font-size: 11px; font-weight: 800; }
  .badge-yes { background: #064E3B; color: #6EE7B7; }
  .badge-no  { background: #7F1D1D; color: #FCA5A5; }
  .badge-WHO    { background: #1e1b4b; color: #A5B4FC; }
  .badge-WHAT   { background: #451a03; color: #FDE68A; }
  .badge-WHEN   { background: #064E3B; color: #6EE7B7; }
  .badge-WHERE  { background: #7F1D1D; color: #FCA5A5; }
  .badge-HOW    { background: #2e1065; color: #D8B4FE; }
  .badge-WHY    { background: #064E3B; color: #6EE7B7; }
  .badge-CAUSE  { background: #7F1D1D; color: #FCA5A5; }
  .badge-LENGTH   { background: #1e1b4b; color: #A5B4FC; }
  .badge-WIDTH    { background: #451a03; color: #FDE68A; }
  .badge-CAPACITY { background: #064E3B; color: #6EE7B7; }
  .progress-row { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; }
  .progress-label { width: 90px; font-size: 13px; font-weight: 800; color: #9CA3AF; }
  .progress-bg { flex: 1; height: 20px; background: #0f3460; border-radius: 10px; overflow: hidden; position: relative; }
  .progress-fill { height: 100%; border-radius: 10px; transition: width 1s; }
  .progress-pct { width: 48px; text-align: right; font-size: 14px; font-weight: 900; }
  /* COLLAPSIBLE */
  .collapse-btn { background: none; border: 2px solid #0f3460; color: #9CA3AF; font-family: 'Nunito', sans-serif; font-size: 15px; font-weight: 800; padding: 12px 20px; border-radius: 12px; cursor: pointer; width: 100%; text-align: left; display: flex; justify-content: space-between; align-items: center; }
  .collapse-btn:hover { border-color: #5B8DEF; color: #E8EEF8; }
  .collapse-content { display: none; margin-top: 16px; }
  .collapse-content.open { display: block; }
  /* GOAL CARD */
  .goal-card { background: #0f3460; border-radius: 14px; padding: 18px 20px; margin-bottom: 14px; border: 2px solid #1a1a5e; }
  .goal-card-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 10px; gap: 10px; }
  .goal-badge { display: inline-block; padding: 4px 12px; border-radius: 10px; font-size: 13px; font-weight: 900; background: #5B8DEF; color: white; margin-right: 8px; }
  .goal-area { font-size: 16px; font-weight: 800; color: #E8EEF8; }
  .goal-last { font-size: 12px; color: #6B7280; white-space: nowrap; }
  .goal-progress-track { position: relative; height: 28px; background: #1a1a2e; border-radius: 14px; overflow: visible; margin: 8px 0 4px; }
  .goal-fill { height: 28px; border-radius: 14px; transition: width 1s; display: flex; align-items: center; justify-content: flex-end; padding-right: 8px; font-size: 12px; font-weight: 900; color: white; min-width: 30px; }
  .goal-baseline-marker { position: absolute; top: 0; bottom: 0; width: 3px; background: #9CA3AF; border-radius: 2px; }
  .goal-target-marker { position: absolute; top: 0; bottom: 0; width: 3px; background: #FFD166; border-radius: 2px; }
  .goal-label-row { display: flex; justify-content: space-between; font-size: 11px; color: #6B7280; margin-top: 2px; }
  .milestones { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 10px; }
  .milestone { background: #1a1a2e; border-radius: 8px; padding: 5px 10px; font-size: 11px; font-weight: 800; color: #9CA3AF; border: 1px solid #0f3460; }
  .milestone.achieved { background: #064E3B; color: #6EE7B7; border-color: #06D6A0; }
  .milestone.overdue { background: #7F1D1D; color: #FCA5A5; border-color: #EF476F; }
  .expand-btn { background: none; border: 1px solid #0f3460; color: #6B7280; font-family: 'Nunito', sans-serif; font-size: 12px; font-weight: 800; padding: 5px 12px; border-radius: 8px; cursor: pointer; margin-top: 8px; }
  .expand-btn:hover { border-color: #5B8DEF; color: #5B8DEF; }
  .goal-expand { display: none; margin-top: 14px; padding-top: 14px; border-top: 1px solid #1a1a5e; }
  .goal-expand.open { display: block; }
  /* WEEKLY CHART */
  .weekly-chart { display: flex; align-items: flex-end; gap: 8px; height: 80px; margin-bottom: 12px; }
  .week-bar-wrap { display: flex; flex-direction: column; align-items: center; flex: 1; }
  .week-bar { width: 100%; border-radius: 4px 4px 0 0; transition: height 0.8s; }
  .week-label { font-size: 10px; color: #6B7280; margin-top: 4px; text-align: center; }
  .goal-line-80 { position: absolute; left: 0; right: 0; border-top: 2px dashed #FFD166; }
</style>
</head>
<body>
<?php
require_once '/home/djaloza/config.php';
$host = DB_HOST;
$db   = "michael_iep";
$user = DB_USER;
$pass = DB_PASS;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("<p style='padding:40px;color:#EF476F;font-family:sans-serif;'>DB connection failed: " . $e->getMessage() . "</p>");
}

// ---- Legacy (2025-2026) stats ----
$totalStory   = $pdo->query("SELECT COUNT(*) FROM story_responses")->fetchColumn();
$correctStory = $pdo->query("SELECT COUNT(*) FROM story_responses WHERE correct=1")->fetchColumn();
$storyPct     = $totalStory > 0 ? round(($correctStory / $totalStory) * 100) : 0;
$sessions     = $pdo->query("SELECT COUNT(DISTINCT session_id) FROM story_responses")->fetchColumn();
$byType       = $pdo->query("SELECT question_type, COUNT(*) as total, SUM(correct) as correct FROM story_responses GROUP BY question_type ORDER BY question_type")->fetchAll(PDO::FETCH_ASSOC);
$totalMath    = $pdo->query("SELECT COUNT(*) FROM math_responses")->fetchColumn();
$correctMath  = $pdo->query("SELECT COUNT(*) FROM math_responses WHERE correct=1")->fetchColumn();
$mathPct      = $totalMath > 0 ? round(($correctMath / $totalMath) * 100) : 0;
$byCategory   = $pdo->query("SELECT category, COUNT(*) as total, SUM(correct) as correct FROM math_responses GROUP BY category ORDER BY category")->fetchAll(PDO::FETCH_ASSOC);
$recentStory  = $pdo->query("SELECT date, time, story, question_type, question, answer_given, correct, response_time_sec FROM story_responses ORDER BY created_at DESC LIMIT 20")->fetchAll(PDO::FETCH_ASSOC);
$recentMath   = $pdo->query("SELECT date, time, category, question, answer_given, correct, response_time_sec FROM math_responses ORDER BY created_at DESC LIMIT 20")->fetchAll(PDO::FETCH_ASSOC);
$totalClock   = $pdo->query("SELECT COUNT(*) FROM clock_responses")->fetchColumn();
$correctClock = $pdo->query("SELECT COUNT(*) FROM clock_responses WHERE correct=1")->fetchColumn();
$clockPct     = $totalClock > 0 ? round(($correctClock / $totalClock) * 100) : 0;
$clockByType  = $pdo->query("SELECT question_type, COUNT(*) as total, SUM(correct) as correct FROM clock_responses GROUP BY question_type ORDER BY question_type")->fetchAll(PDO::FETCH_ASSOC);
$recentClock  = $pdo->query("SELECT date, time, question_type, time_shown, answer_given, correct, response_time_sec FROM clock_responses ORDER BY created_at DESC LIMIT 15")->fetchAll(PDO::FETCH_ASSOC);
$totalShapes   = $pdo->query("SELECT COUNT(*) FROM shapes_responses")->fetchColumn();
$correctShapes = $pdo->query("SELECT COUNT(*) FROM shapes_responses WHERE correct=1")->fetchColumn();
$shapesPct     = $totalShapes > 0 ? round(($correctShapes / $totalShapes) * 100) : 0;
$shapesByMode  = $pdo->query("SELECT mode, COUNT(*) as total, SUM(correct) as correct FROM shapes_responses GROUP BY mode ORDER BY mode")->fetchAll(PDO::FETCH_ASSOC);
$recentShapes  = $pdo->query("SELECT date, time, mode, question, answer_given, correct, response_time_sec FROM shapes_responses ORDER BY created_at DESC LIMIT 15")->fetchAll(PDO::FETCH_ASSOC);
$totalVocab   = $pdo->query("SELECT COUNT(*) FROM vocabulary_responses")->fetchColumn();
$correctVocab = $pdo->query("SELECT COUNT(*) FROM vocabulary_responses WHERE correct=1")->fetchColumn();
$vocabPct     = $totalVocab > 0 ? round(($correctVocab / $totalVocab) * 100) : 0;
$vocabByWord  = $pdo->query("SELECT word, COUNT(*) as total, SUM(correct) as correct FROM vocabulary_responses GROUP BY word ORDER BY word")->fetchAll(PDO::FETCH_ASSOC);
$recentVocab  = $pdo->query("SELECT date, time, word, answer_given, correct, response_time_sec FROM vocabulary_responses ORDER BY created_at DESC LIMIT 15")->fetchAll(PDO::FETCH_ASSOC);
$weeklyStory  = $pdo->query("SELECT WEEK(created_at) as wk, YEAR(created_at) as yr, COUNT(*) as total, SUM(correct) as correct FROM story_responses GROUP BY YEAR(created_at), WEEK(created_at) ORDER BY yr DESC, wk DESC LIMIT 4")->fetchAll(PDO::FETCH_ASSOC);

// ---- 2026-2027 IEP Goals ----
$goals = [
    'SAI1' => ['area'=>'Reading Comprehension (HOW/WHY)', 'baseline'=>63, 'target'=>80, 'milestones'=>[
        ['date'=>'2026-10-01','pct'=>70,'label'=>'Oct 2026'],
        ['date'=>'2027-02-01','pct'=>75,'label'=>'Feb 2027'],
        ['date'=>'2027-03-06','pct'=>80,'label'=>'Mar 2027']]],
    'SAI2' => ['area'=>'Story Sequencing', 'baseline'=>36, 'target'=>80, 'milestones'=>[
        ['date'=>'2026-10-01','pct'=>65,'label'=>'Oct 2026'],
        ['date'=>'2027-02-01','pct'=>75,'label'=>'Feb 2027'],
        ['date'=>'2027-03-06','pct'=>80,'label'=>'Mar 2027']]],
    'SAI3' => ['area'=>'Addition Within 1,000', 'baseline'=>40, 'target'=>80, 'milestones'=>[
        ['date'=>'2026-10-01','pct'=>55,'label'=>'Oct 2026'],
        ['date'=>'2027-02-01','pct'=>70,'label'=>'Feb 2027'],
        ['date'=>'2027-03-06','pct'=>80,'label'=>'Mar 2027']]],
    'SAI4' => ['area'=>'Capacity Vocabulary', 'baseline'=>61, 'target'=>80, 'milestones'=>[
        ['date'=>'2026-10-01','pct'=>65,'label'=>'Oct 2026'],
        ['date'=>'2027-02-01','pct'=>75,'label'=>'Feb 2027'],
        ['date'=>'2027-03-06','pct'=>80,'label'=>'Mar 2027']]],
    'SAI5' => ['area'=>'Subtraction Within 1,000', 'baseline'=>0, 'target'=>80, 'milestones'=>[
        ['date'=>'2026-10-01','pct'=>55,'label'=>'Oct 2026'],
        ['date'=>'2027-02-01','pct'=>70,'label'=>'Feb 2027'],
        ['date'=>'2027-03-06','pct'=>80,'label'=>'Mar 2027']]],
    'SLP1' => ['area'=>'Pronouns', 'baseline'=>33, 'target'=>80, 'milestones'=>[
        ['date'=>'2026-09-01','pct'=>45,'label'=>'Sep 2026'],
        ['date'=>'2026-11-01','pct'=>45,'label'=>'Nov 2026'],
        ['date'=>'2027-02-01','pct'=>60,'label'=>'Feb 2027']]],
    'SLP2' => ['area'=>'Prepositional Phrases', 'baseline'=>38, 'target'=>80, 'milestones'=>[
        ['date'=>'2026-09-01','pct'=>45,'label'=>'Sep 2026'],
        ['date'=>'2026-11-01','pct'=>45,'label'=>'Nov 2026'],
        ['date'=>'2027-02-01','pct'=>60,'label'=>'Feb 2027']]],
    'SLP3' => ['area'=>'Functional Communication', 'baseline'=>22, 'target'=>70, 'milestones'=>[
        ['date'=>'2026-09-01','pct'=>35,'label'=>'Sep 2026'],
        ['date'=>'2026-11-01','pct'=>35,'label'=>'Nov 2026'],
        ['date'=>'2027-02-01','pct'=>50,'label'=>'Feb 2027']]],
    'SLP4' => ['area'=>'Turn Taking', 'baseline'=>10, 'target'=>70, 'milestones'=>[
        ['date'=>'2026-09-01','pct'=>25,'label'=>'Sep 2026'],
        ['date'=>'2026-11-01','pct'=>40,'label'=>'Nov 2026'],
        ['date'=>'2027-02-01','pct'=>55,'label'=>'Feb 2027']]],
    'B1'   => ['area'=>'Social Initiation', 'baseline'=>0, 'target'=>50, 'milestones'=>[
        ['date'=>'2026-09-01','pct'=>10,'label'=>'Sep 2026'],
        ['date'=>'2026-11-01','pct'=>20,'label'=>'Nov 2026'],
        ['date'=>'2027-02-01','pct'=>30,'label'=>'Feb 2027']]]
];

// Helper: fetch goal stats from iep_2027_responses
function getGoalStats($pdo, $goalCode) {
    try {
        $row = $pdo->prepare("SELECT COUNT(*) as total, SUM(correct) as correct, MAX(created_at) as last_at FROM iep_2027_responses WHERE goal_code=?");
        $row->execute([$goalCode]);
        $r = $row->fetch(PDO::FETCH_ASSOC);
        $total = (int)($r['total'] ?? 0);
        $correct = (int)($r['correct'] ?? 0);
        $pct = $total > 0 ? round(($correct/$total)*100) : 0;
        $lastAt = $r['last_at'] ?? null;
        $daysAgo = $lastAt ? (int)floor((time()-strtotime($lastAt))/86400) : null;
        return ['total'=>$total,'correct'=>$correct,'pct'=>$pct,'daysAgo'=>$daysAgo];
    } catch (Exception $e) {
        return ['total'=>0,'correct'=>0,'pct'=>0,'daysAgo'=>null];
    }
}

function getWeeklyStats($pdo, $goalCode) {
    try {
        $q = $pdo->prepare("SELECT YEAR(created_at) as yr, WEEK(created_at) as wk,
            COUNT(*) as total, SUM(correct) as correct
            FROM iep_2027_responses WHERE goal_code=?
            GROUP BY YEAR(created_at), WEEK(created_at)
            ORDER BY yr DESC, wk DESC LIMIT 8");
        $q->execute([$goalCode]);
        return array_reverse($q->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) { return []; }
}

function getRecentResponses($pdo, $goalCode) {
    try {
        $q = $pdo->prepare("SELECT date, time, question, answer_given, correct, response_time_sec FROM iep_2027_responses WHERE goal_code=? ORDER BY created_at DESC LIMIT 10");
        $q->execute([$goalCode]);
        return $q->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) { return []; }
}

// Check if table exists
$has2027 = false;
try {
    $pdo->query("SELECT 1 FROM iep_2027_responses LIMIT 1");
    $has2027 = true;
} catch (Exception $e) {}

// ---- Behavior data ----
$behaviorRows = [];
try {
    $behaviorRows = $pdo->query("SELECT * FROM behavior_checkins ORDER BY created_at DESC LIMIT 20")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {}
$firstthenRows = [];
try {
    $firstthenRows = $pdo->query("SELECT * FROM firstthen_sessions ORDER BY created_at DESC LIMIT 20")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {}
?>

<div class="header">
  <div>
    <h1>📊 Michael's IEP Dashboard</h1>
    <p>2026–2027 IEP Year · Generated <?= date("F j, Y g:i A") ?></p>
  </div>
  <a href="https://jaloza.com/michael/" style="color:#9CA3AF;font-family:'Nunito',sans-serif;font-size:14px;font-weight:800;text-decoration:none;">← Home</a>
</div>

<div class="export-bar">
  <button class="btn btn-green" onclick="exportAll2027()">⬇ Export All 2026-2027 Data</button>
  <div style="position:relative;display:inline-block;">
    <button class="btn btn-blue" onclick="document.getElementById('goal-dropdown').style.display=document.getElementById('goal-dropdown').style.display==='block'?'none':'block'">Export by Goal ▼</button>
    <div id="goal-dropdown" style="display:none;position:absolute;top:34px;left:0;background:#16213e;border:2px solid #0f3460;border-radius:10px;padding:6px;z-index:100;min-width:160px;">
      <?php foreach (array_keys($goals) as $gc): ?>
      <div onclick="exportGoal('<?= $gc ?>')" style="padding:6px 12px;cursor:pointer;color:#E8EEF8;font-size:13px;font-weight:700;border-radius:6px;" onmouseover="this.style.background='#0f3460'" onmouseout="this.style.background=''"><?= $gc ?> — <?= htmlspecialchars($goals[$gc]['area']) ?></div>
      <?php endforeach; ?>
    </div>
  </div>
  <button class="btn btn-gray" onclick="toggleSection('archive-section')">📦 Old Data ▼</button>
  <button class="btn btn-orange" onclick="window.print()">🖨 Print Report</button>
  <span style="margin-left:auto;display:flex;gap:8px;align-items:center;">
    <button class="btn btn-red" onclick="clearData('test')">🧪 Clear Test Data</button>
    <button class="btn btn-red" style="opacity:0.7;" onclick="clearData('all')">⚠️ Clear All Legacy</button>
  </span>
</div>

<div class="content">

<!-- SECTION 1: Archive (collapsed) -->
<div class="section" id="archive-section" style="display:none;">
  <h2>📦 Previous IEP Year Data (2025-2026)</h2>
  <p style="color:#6B7280;font-size:13px;margin-bottom:16px;">Read-only archive from story_responses and math_responses tables.</p>

  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:14px;margin-bottom:20px;">
    <div style="background:#0f3460;border-radius:12px;padding:16px;text-align:center;">
      <div style="font-size:11px;font-weight:800;color:#6B7280;margin-bottom:4px;">STORY ACCURACY</div>
      <div style="font-size:36px;font-weight:900;color:#5B8DEF;"><?= $storyPct ?>%</div>
      <div style="font-size:12px;color:#6B7280;"><?= $correctStory ?>/<?= $totalStory ?></div>
    </div>
    <div style="background:#0f3460;border-radius:12px;padding:16px;text-align:center;">
      <div style="font-size:11px;font-weight:800;color:#6B7280;margin-bottom:4px;">MATH ACCURACY</div>
      <div style="font-size:36px;font-weight:900;color:#FF9F1C;"><?= $mathPct ?>%</div>
      <div style="font-size:12px;color:#6B7280;"><?= $correctMath ?>/<?= $totalMath ?></div>
    </div>
    <div style="background:#0f3460;border-radius:12px;padding:16px;text-align:center;">
      <div style="font-size:11px;font-weight:800;color:#6B7280;margin-bottom:4px;">CLOCK ACCURACY</div>
      <div style="font-size:36px;font-weight:900;color:#7B5EA7;"><?= $clockPct ?>%</div>
      <div style="font-size:12px;color:#6B7280;"><?= $correctClock ?>/<?= $totalClock ?></div>
    </div>
    <div style="background:#0f3460;border-radius:12px;padding:16px;text-align:center;">
      <div style="font-size:11px;font-weight:800;color:#6B7280;margin-bottom:4px;">SHAPES ACCURACY</div>
      <div style="font-size:36px;font-weight:900;color:#EF476F;"><?= $shapesPct ?>%</div>
      <div style="font-size:12px;color:#6B7280;"><?= $correctShapes ?>/<?= $totalShapes ?></div>
    </div>
    <div style="background:#0f3460;border-radius:12px;padding:16px;text-align:center;">
      <div style="font-size:11px;font-weight:800;color:#6B7280;margin-bottom:4px;">VOCAB ACCURACY</div>
      <div style="font-size:36px;font-weight:900;color:#06D6A0;"><?= $vocabPct ?>%</div>
      <div style="font-size:12px;color:#6B7280;"><?= $correctVocab ?>/<?= $totalVocab ?></div>
    </div>
    <div style="background:#0f3460;border-radius:12px;padding:16px;text-align:center;">
      <div style="font-size:11px;font-weight:800;color:#6B7280;margin-bottom:4px;">SESSIONS</div>
      <div style="font-size:36px;font-weight:900;color:#E8EEF8;"><?= $sessions ?></div>
      <div style="font-size:12px;color:#6B7280;">story sessions</div>
    </div>
  </div>

  <h3 style="font-size:15px;font-weight:800;color:#9CA3AF;margin-bottom:12px;">Story by Question Type</h3>
  <?php if (empty($byType)): ?>
    <p style="color:#6B7280;font-size:13px;">No story data.</p>
  <?php else: foreach ($byType as $row):
    $pct = $row['total'] > 0 ? round(($row['correct']/$row['total'])*100) : 0;
    $col = $pct>=80?'#06D6A0':($pct>=60?'#FFD166':'#EF476F'); ?>
    <div class="progress-row">
      <div class="progress-label"><span class="badge badge-<?= $row['question_type'] ?>"><?= $row['question_type'] ?></span></div>
      <div class="progress-bg"><div class="progress-fill" style="width:<?= $pct ?>%;background:<?= $col ?>;"></div></div>
      <div class="progress-pct" style="color:<?= $col ?>"><?= $pct ?>%</div>
      <div style="font-size:12px;color:#6B7280;width:60px;"><?= $row['correct'] ?>/<?= $row['total'] ?></div>
    </div>
  <?php endforeach; endif; ?>

  <h3 style="font-size:15px;font-weight:800;color:#9CA3AF;margin:16px 0 12px;">Math by Category</h3>
  <?php if (empty($byCategory)): ?>
    <p style="color:#6B7280;font-size:13px;">No math data.</p>
  <?php else: foreach ($byCategory as $row):
    $pct = $row['total'] > 0 ? round(($row['correct']/$row['total'])*100) : 0;
    $col = $pct>=80?'#06D6A0':($pct>=60?'#FFD166':'#EF476F'); ?>
    <div class="progress-row">
      <div class="progress-label"><span class="badge badge-<?= $row['category'] ?>"><?= $row['category'] ?></span></div>
      <div class="progress-bg"><div class="progress-fill" style="width:<?= $pct ?>%;background:<?= $col ?>;"></div></div>
      <div class="progress-pct" style="color:<?= $col ?>"><?= $pct ?>%</div>
      <div style="font-size:12px;color:#6B7280;width:60px;"><?= $row['correct'] ?>/<?= $row['total'] ?></div>
    </div>
  <?php endforeach; endif; ?>

  <h3 style="font-size:15px;font-weight:800;color:#9CA3AF;margin:16px 0 12px;">Recent Story Responses</h3>
  <?php if (empty($recentStory)): ?>
    <p style="color:#6B7280;font-size:13px;">No story data yet.</p>
  <?php else: ?>
  <div style="overflow-x:auto;">
  <table>
    <tr><th>Date</th><th>Story</th><th>Type</th><th>Question</th><th>Answer Given</th><th>Correct</th><th>Sec</th></tr>
    <?php foreach ($recentStory as $r): ?>
    <tr>
      <td><?= htmlspecialchars($r['date']) ?> <?= htmlspecialchars($r['time']) ?></td>
      <td><?= htmlspecialchars($r['story']) ?></td>
      <td><span class="badge badge-<?= $r['question_type'] ?>"><?= $r['question_type'] ?></span></td>
      <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= htmlspecialchars($r['question']) ?></td>
      <td><?= htmlspecialchars($r['answer_given']) ?></td>
      <td><span class="badge <?= $r['correct']?'badge-yes':'badge-no' ?>"><?= $r['correct']?'YES':'NO' ?></span></td>
      <td><?= $r['response_time_sec'] ?></td>
    </tr>
    <?php endforeach; ?>
  </table>
  </div>
  <?php endif; ?>
</div>

<!-- SECTION 2: Current IEP Goals 2026-2027 -->
<div class="section">
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:8px;">
    <h2 style="margin-bottom:0;">🎯 Current IEP Goals — 2026-2027</h2>
    <span style="font-size:13px;color:#6B7280;font-weight:700;">IEP Date: March 6, 2026</span>
  </div>

  <?php if (!$has2027): ?>
  <div style="background:#451a03;border-radius:10px;padding:14px 18px;color:#FDE68A;font-size:14px;font-weight:700;margin-bottom:16px;">
    ⚠️ iep_2027_responses table not found. Run setup_2027_tables.sql in phpMyAdmin first.
  </div>
  <?php endif; ?>

  <?php foreach ($goals as $goalCode => $g):
    $stats = $has2027 ? getGoalStats($pdo, $goalCode) : ['total'=>0,'correct'=>0,'pct'=>0,'daysAgo'=>null];
    $curPct = $stats['pct'];
    $daysAgo = $stats['daysAgo'];
    $baseline = $g['baseline'];
    $target = $g['target'];
    // Fill color based on milestone thresholds
    $m1 = $g['milestones'][0]['pct'] ?? $target;
    $m2 = $g['milestones'][1]['pct'] ?? $target;
    $fillColor = $curPct >= $target ? '#06D6A0' : ($curPct >= $m2 ? '#FFD166' : '#EF476F');
    $fillPct = min($curPct, 100);
    $baselinePct = min($baseline, 100);
    $targetPct = min($target, 100);
    $today = date('Y-m-d');
    $weeklyData = $has2027 ? getWeeklyStats($pdo, $goalCode) : [];
    $recentResps = $has2027 ? getRecentResponses($pdo, $goalCode) : [];
  ?>
  <div class="goal-card">
    <div class="goal-card-header">
      <div>
        <span class="goal-badge"><?= $goalCode ?></span>
        <span class="goal-area"><?= htmlspecialchars($g['area']) ?></span>
      </div>
      <div class="goal-last">
        <?php if ($daysAgo !== null): ?>
          Last: <?= $daysAgo === 0 ? 'today' : ($daysAgo === 1 ? '1 day ago' : $daysAgo.' days ago') ?>
        <?php else: ?>
          No data yet
        <?php endif; ?>
      </div>
    </div>

    <div style="position:relative;">
      <div class="goal-progress-track">
        <div class="goal-fill" style="width:<?= $fillPct ?>%;background:<?= $fillColor ?>;"><?= $curPct ?>%</div>
        <div class="goal-baseline-marker" style="left:<?= $baselinePct ?>%;"></div>
        <div class="goal-target-marker" style="left:<?= $targetPct ?>%;"></div>
      </div>
    </div>
    <div class="goal-label-row">
      <span style="color:#9CA3AF;">Baseline: <?= $baseline ?>%</span>
      <span style="color:#06D6A0;font-weight:900;">Current: <?= $curPct ?>% (<?= $stats['correct'] ?>/<?= $stats['total'] ?> questions)</span>
      <span style="color:#FFD166;">Target: <?= $target ?>%</span>
    </div>

    <div class="milestones">
      <?php foreach ($g['milestones'] as $m):
        $isPast = $today > $m['date'];
        $achieved = $curPct >= $m['pct'];
        $cls = $achieved ? 'milestone achieved' : ($isPast ? 'milestone overdue' : 'milestone');
        $icon = $achieved ? '✅' : ($isPast ? '⚠️' : '🎯');
      ?>
      <div class="<?= $cls ?>"><?= $icon ?> <?= $m['label'] ?>: <?= $m['pct'] ?>%</div>
      <?php endforeach; ?>
    </div>

    <button class="expand-btn" onclick="toggleExpand('expand-<?= $goalCode ?>')">Expand ▼ weekly chart & recent responses</button>

    <div class="goal-expand" id="expand-<?= $goalCode ?>">
      <?php if (!empty($weeklyData)): ?>
      <div style="font-size:13px;font-weight:800;color:#9CA3AF;margin-bottom:8px;">Last 8 weeks accuracy:</div>
      <div class="weekly-chart">
        <?php foreach ($weeklyData as $w):
          $wpct = $w['total']>0 ? round(($w['correct']/$w['total'])*100) : 0;
          $wh = max(4, round($wpct * 0.7));
          $wc = $wpct>=80?'#06D6A0':($wpct>=60?'#FFD166':'#EF476F');
        ?>
        <div class="week-bar-wrap">
          <div style="font-size:10px;color:#9CA3AF;margin-bottom:2px;"><?= $wpct ?>%</div>
          <div class="week-bar" style="height:<?= $wh ?>px;background:<?= $wc ?>;"></div>
          <div class="week-label">W<?= $w['wk'] ?></div>
        </div>
        <?php endforeach; ?>
      </div>
      <?php else: ?>
      <p style="color:#6B7280;font-size:13px;margin-bottom:12px;">No weekly data yet.</p>
      <?php endif; ?>

      <?php if (!empty($recentResps)): ?>
      <div style="font-size:13px;font-weight:800;color:#9CA3AF;margin-bottom:8px;">Recent 10 responses:</div>
      <div style="overflow-x:auto;">
      <table>
        <tr><th>Date</th><th>Question</th><th>Answer</th><th>Correct</th><th>Sec</th></tr>
        <?php foreach ($recentResps as $r): ?>
        <tr>
          <td style="white-space:nowrap;"><?= htmlspecialchars($r['date']) ?></td>
          <td style="max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= htmlspecialchars(mb_substr($r['question'],0,60)) ?><?= strlen($r['question'])>60?'…':'' ?></td>
          <td><?= htmlspecialchars($r['answer_given']) ?></td>
          <td><span class="badge <?= $r['correct']?'badge-yes':'badge-no' ?>"><?= $r['correct']?'✓':'✗' ?></span></td>
          <td><?= $r['response_time_sec'] ?></td>
        </tr>
        <?php endforeach; ?>
      </table>
      </div>
      <?php else: ?>
      <p style="color:#6B7280;font-size:13px;">No responses yet for this goal.</p>
      <?php endif; ?>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<!-- SECTION 3: Behavior & Observation -->
<div class="section">
  <h2>👁️ Observation & Behavior Data</h2>

  <?php if (!empty($behaviorRows)): ?>
  <h3 style="font-size:15px;font-weight:800;color:#9CA3AF;margin-bottom:12px;">Behavior Check-ins</h3>
  <div style="overflow-x:auto;margin-bottom:20px;">
  <table>
    <tr>
      <?php $bcKeys = array_keys($behaviorRows[0]); foreach ($bcKeys as $k): ?>
      <th><?= htmlspecialchars($k) ?></th>
      <?php endforeach; ?>
    </tr>
    <?php foreach ($behaviorRows as $r): ?>
    <tr><?php foreach ($r as $v): ?><td><?= htmlspecialchars((string)$v) ?></td><?php endforeach; ?></tr>
    <?php endforeach; ?>
  </table>
  </div>
  <?php else: ?>
  <p style="color:#6B7280;font-size:13px;margin-bottom:16px;">No behavior check-in data yet.</p>
  <?php endif; ?>

  <?php if (!empty($firstthenRows)): ?>
  <h3 style="font-size:15px;font-weight:800;color:#9CA3AF;margin-bottom:12px;">First/Then Sessions</h3>
  <div style="overflow-x:auto;">
  <table>
    <tr>
      <?php $ftKeys = array_keys($firstthenRows[0]); foreach ($ftKeys as $k): ?>
      <th><?= htmlspecialchars($k) ?></th>
      <?php endforeach; ?>
    </tr>
    <?php foreach ($firstthenRows as $r): ?>
    <tr><?php foreach ($r as $v): ?><td><?= htmlspecialchars((string)$v) ?></td><?php endforeach; ?></tr>
    <?php endforeach; ?>
  </table>
  </div>
  <?php else: ?>
  <p style="color:#6B7280;font-size:13px;">No First/Then session data yet.</p>
  <?php endif; ?>

  <div style="margin-top:20px;">
    <h3 style="font-size:15px;font-weight:800;color:#9CA3AF;margin-bottom:12px;">Clock Accuracy by Type</h3>
    <?php if (empty($clockByType)): ?>
      <p style="color:#6B7280;font-size:13px;">No clock data yet.</p>
    <?php else: foreach ($clockByType as $row):
      $pct = $row['total']>0?round(($row['correct']/$row['total'])*100):0;
      $col = $pct>=80?'#06D6A0':($pct>=60?'#FFD166':'#EF476F');
      $label = $row['question_type']==='read_clock'?'Read Clock':'Match Clock'; ?>
      <div class="progress-row">
        <div class="progress-label"><span style="font-size:11px;font-weight:800;"><?= $label ?></span></div>
        <div class="progress-bg"><div class="progress-fill" style="width:<?= $pct ?>%;background:<?= $col ?>;"></div></div>
        <div class="progress-pct" style="color:<?= $col ?>"><?= $pct ?>%</div>
        <div style="font-size:12px;color:#6B7280;width:60px;"><?= $row['correct'] ?>/<?= $row['total'] ?></div>
      </div>
    <?php endforeach; endif; ?>

    <h3 style="font-size:15px;font-weight:800;color:#9CA3AF;margin:16px 0 12px;">Shapes Accuracy by Mode</h3>
    <?php if (empty($shapesByMode)): ?>
      <p style="color:#6B7280;font-size:13px;">No shapes data yet.</p>
    <?php else:
      $modeLabels = ['identify'=>'Identify Shape','equal_parts'=>'Equal Parts','attributes'=>'Attributes'];
      foreach ($shapesByMode as $row):
        $pct = $row['total']>0?round(($row['correct']/$row['total'])*100):0;
        $col = $pct>=80?'#06D6A0':($pct>=60?'#FFD166':'#EF476F');
        $label = $modeLabels[$row['mode']] ?? $row['mode']; ?>
      <div class="progress-row">
        <div class="progress-label" style="font-size:11px;font-weight:800;"><?= htmlspecialchars($label) ?></div>
        <div class="progress-bg"><div class="progress-fill" style="width:<?= $pct ?>%;background:<?= $col ?>;"></div></div>
        <div class="progress-pct" style="color:<?= $col ?>"><?= $pct ?>%</div>
        <div style="font-size:12px;color:#6B7280;width:60px;"><?= $row['correct'] ?>/<?= $row['total'] ?></div>
      </div>
    <?php endforeach; endif; ?>

    <h3 style="font-size:15px;font-weight:800;color:#9CA3AF;margin:16px 0 12px;">Vocabulary by Word</h3>
    <?php if (empty($vocabByWord)): ?>
      <p style="color:#6B7280;font-size:13px;">No vocabulary data yet.</p>
    <?php else: foreach ($vocabByWord as $row):
      $pct = $row['total']>0?round(($row['correct']/$row['total'])*100):0;
      $col = $pct>=80?'#06D6A0':($pct>=60?'#FFD166':'#EF476F'); ?>
      <div class="progress-row">
        <div class="progress-label" style="font-size:12px;font-weight:900;color:#E8EEF8;"><?= htmlspecialchars($row['word']) ?></div>
        <div class="progress-bg"><div class="progress-fill" style="width:<?= $pct ?>%;background:<?= $col ?>;"></div></div>
        <div class="progress-pct" style="color:<?= $col ?>"><?= $pct ?>%</div>
        <div style="font-size:12px;color:#6B7280;width:60px;"><?= $row['correct'] ?>/<?= $row['total'] ?></div>
      </div>
    <?php endforeach; endif; ?>
  </div>
</div>

</div><!-- /content -->

<script>
function toggleSection(id) {
  const el = document.getElementById(id);
  el.style.display = el.style.display === 'none' ? 'block' : 'none';
}

function toggleExpand(id) {
  const el = document.getElementById(id);
  el.classList.toggle('open');
  const btn = el.previousElementSibling;
  if (btn) btn.textContent = el.classList.contains('open') ? 'Collapse ▲' : 'Expand ▼ weekly chart & recent responses';
}

function exportAll2027() {
  window.location.href = 'export2027.php?type=all';
}

function exportGoal(gc) {
  document.getElementById('goal-dropdown').style.display='none';
  window.location.href = 'export2027.php?type=goal&goalCode='+gc;
}

async function clearData(scope) {
  const label = scope==='test'?'test data':'ALL legacy data (cannot be undone)';
  if (!confirm('Delete '+label+'?')) return;
  if (scope==='all' && !confirm('Second confirmation: permanently delete ALL story and math responses?')) return;
  const resp = await fetch('log.php', {
    method:'POST', headers:{'Content-Type':'application/json'},
    body:JSON.stringify({action:'clear',scope:scope,dataset:'all'})
  });
  const data = await resp.json();
  if (data.status==='ok') { alert('Done.'); location.reload(); }
  else alert('Error: '+(data.message||'unknown'));
}

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
  const dd = document.getElementById('goal-dropdown');
  if (dd && !dd.parentElement.contains(e.target)) dd.style.display='none';
});
</script>
</body>
</html>
