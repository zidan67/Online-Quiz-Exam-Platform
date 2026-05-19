CREATE DATABASE IF NOT EXISTS online_quiz_exam_platform;
USE online_quiz_exam_platform;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('student', 'instructor', 'admin') NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS quizzes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    instructor_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    total_marks INT NOT NULL DEFAULT 0,
    time_limit_minutes INT NOT NULL,
    status ENUM('draft', 'published') NOT NULL DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (instructor_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT NOT NULL,
    question_text TEXT NOT NULL,
    marks INT NOT NULL DEFAULT 1,
    order_index INT NOT NULL DEFAULT 1,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS options (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question_id INT NOT NULL,
    option_text VARCHAR(255) NOT NULL,
    is_correct TINYINT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT NOT NULL,
    student_id INT NOT NULL,
    score INT NULL,
    started_at DATETIME NOT NULL,
    completed_at DATETIME NULL,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS answers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    attempt_id INT NOT NULL,
    question_id INT NOT NULL,
    selected_option_id INT NOT NULL,
    FOREIGN KEY (attempt_id) REFERENCES attempts(id) ON DELETE CASCADE,
    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE,
    FOREIGN KEY (selected_option_id) REFERENCES options(id) ON DELETE CASCADE
);

INSERT INTO users (id, name, email, password_hash, role, is_active) VALUES
(1, 'Demo Instructor', 'instructor@example.com', '$2y$10$5r.N8JCOj88hG5KUfocoh.azLrvGBfM5Y6m99WTx8SvJ6C2PYDfHe', 'instructor', 1),
(2, 'Demo Student', 'student@example.com', '$2y$10$5r.N8JCOj88hG5KUfocoh.azLrvGBfM5Y6m99WTx8SvJ6C2PYDfHe', 'student', 1),
(3, 'Demo Admin', 'admin@example.com', '$2y$10$5r.N8JCOj88hG5KUfocoh.azLrvGBfM5Y6m99WTx8SvJ6C2PYDfHe', 'admin', 1)
ON DUPLICATE KEY UPDATE name = VALUES(name);

INSERT INTO quizzes (id, instructor_id, title, description, total_marks, time_limit_minutes, status) VALUES
(1, 1, 'Basic Web Quiz', 'Simple demo quiz for Task 2 testing.', 2, 10, 'published')
ON DUPLICATE KEY UPDATE title = VALUES(title);

INSERT INTO questions (id, quiz_id, question_text, marks, order_index) VALUES
(1, 1, 'What does HTML stand for?', 1, 1),
(2, 1, 'Which PHP function is used to hash passwords?', 1, 2)
ON DUPLICATE KEY UPDATE question_text = VALUES(question_text);

INSERT INTO options (id, question_id, option_text, is_correct) VALUES
(1, 1, 'Hyper Text Markup Language', 1),
(2, 1, 'Home Tool Markup Language', 0),
(3, 1, 'Hyperlinks Text Main Language', 0),
(4, 1, 'High Text Machine Language', 0),
(5, 2, 'password_hash()', 1),
(6, 2, 'md5_password()', 0),
(7, 2, 'make_hash()', 0),
(8, 2, 'secure_password()', 0)
ON DUPLICATE KEY UPDATE option_text = VALUES(option_text), is_correct = VALUES(is_correct);
