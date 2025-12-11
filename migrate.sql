SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS quiz_session_answers;
DROP TABLE IF EXISTS quiz_sessions;
DROP TABLE IF EXISTS answer_options;
DROP TABLE IF EXISTS questions;
DROP TABLE IF EXISTS quizzes;
DROP TABLE IF EXISTS subjects;
DROP TABLE IF EXISTS subject_categories;
DROP TABLE IF EXISTS users;

SET FOREIGN_KEY_CHECKS = 1;

-- USERS
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(250) NOT NULL UNIQUE,
  password_hash VARCHAR(250) NOT NULL,
  is_admin TINYINT DEFAULT 0,
  username VARCHAR(250) NOT NULL,
  first_name VARCHAR(250),
  last_name VARCHAR(250)
);

-- CATEGORIES
CREATE TABLE subject_categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(250) NOT NULL,
  description TEXT NULL
);

-- SUBJECTS (no user_id!)
CREATE TABLE subjects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT NOT NULL,
  title VARCHAR(250) NOT NULL,
  subject_details TEXT,
  sort_order INT DEFAULT 0,
  FOREIGN KEY (category_id) REFERENCES subject_categories(id) ON DELETE CASCADE
);

-- QUIZZES
CREATE TABLE quizzes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  subject_id INT NOT NULL,
  title VARCHAR(250) NOT NULL,
  explanation TEXT,
  difficulty ENUM('Beginner','Intermediate','Advanced','Mixed') DEFAULT 'Mixed',
  sort_order INT DEFAULT 0,
  FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
);

-- QUESTIONS
CREATE TABLE questions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  question_text TEXT NOT NULL,
  quiz_id INT NOT NULL,
  sort_order INT DEFAULT 0,
  explanation TEXT NULL,
  FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE
);

-- ANSWER OPTIONS
CREATE TABLE answer_options (
  id INT AUTO_INCREMENT PRIMARY KEY,
  question_id INT NOT NULL,
  option_text VARCHAR(250) NOT NULL,
  is_correct TINYINT DEFAULT 0,
  FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE
);

-- QUIZ SESSIONS
CREATE TABLE quiz_sessions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  quiz_id INT NOT NULL,
  user_id INT NOT NULL,
  score INT DEFAULT 0,
  session_status ENUM('in_progress','completed') DEFAULT 'in_progress',
  FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- QUIZ SESSION ANSWERS
CREATE TABLE quiz_session_answers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  session_id INT NOT NULL,
  question_id INT NOT NULL,
  selected_option_id INT NOT NULL,
  is_correct TINYINT NOT NULL DEFAULT 0,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (session_id) REFERENCES quiz_sessions(id) ON DELETE CASCADE,
  FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE,
  FOREIGN KEY (selected_option_id) REFERENCES answer_options(id) ON DELETE CASCADE
);

