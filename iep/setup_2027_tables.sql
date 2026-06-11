-- IEP 2026-2027 tables
-- Run once on michael_iep database

CREATE TABLE IF NOT EXISTS iep_2027_sessions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  date VARCHAR(20),
  app_source VARCHAR(30),
  goal_code VARCHAR(20),
  questions_total INT,
  questions_correct INT,
  accuracy_pct DECIMAL(5,2),
  session_id VARCHAR(30)
);

CREATE TABLE IF NOT EXISTS iep_2027_responses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  date VARCHAR(20),
  time VARCHAR(20),
  goal_code VARCHAR(20),
  sub_type VARCHAR(30),
  question TEXT,
  answer_given VARCHAR(255),
  correct TINYINT(1),
  response_time_sec INT,
  session_id VARCHAR(30)
);
