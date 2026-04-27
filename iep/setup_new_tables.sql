-- New tables for Clock, Shapes, and Vocabulary apps
-- Run once on michael_iep database

CREATE TABLE IF NOT EXISTS clock_responses (
  id               INT AUTO_INCREMENT PRIMARY KEY,
  created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  date             VARCHAR(20),
  time             VARCHAR(20),
  question_type    VARCHAR(20),   -- 'read_clock' | 'match_clock'
  time_shown       VARCHAR(10),
  answer_given     VARCHAR(10),
  correct          TINYINT(1),
  response_time_sec INT,
  tokens_earned    INT,
  session_id       VARCHAR(40)
);

CREATE TABLE IF NOT EXISTS shapes_responses (
  id               INT AUTO_INCREMENT PRIMARY KEY,
  created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  date             VARCHAR(20),
  time             VARCHAR(20),
  mode             VARCHAR(20),   -- 'identify' | 'equal_parts' | 'attributes'
  question         TEXT,
  answer_given     VARCHAR(50),
  correct          TINYINT(1),
  response_time_sec INT,
  tokens_earned    INT,
  session_id       VARCHAR(40)
);

CREATE TABLE IF NOT EXISTS vocabulary_responses (
  id               INT AUTO_INCREMENT PRIMARY KEY,
  created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  date             VARCHAR(20),
  time             VARCHAR(20),
  word             VARCHAR(50),
  sentence_shown   TEXT,
  answer_given     VARCHAR(100),
  correct          TINYINT(1),
  response_time_sec INT,
  tokens_earned    INT,
  session_id       VARCHAR(40)
);
