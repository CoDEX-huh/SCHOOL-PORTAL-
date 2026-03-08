CREATE DATABASE IF NOT EXISTS school_portal;
USE school_portal;

DROP TABLE IF EXISTS announcements;
DROP TABLE IF EXISTS claims;
DROP TABLE IF EXISTS found_items;
DROP TABLE IF EXISTS lost_items;
DROP TABLE IF EXISTS grades;
DROP TABLE IF EXISTS exams;
DROP TABLE IF EXISTS enrollments;
DROP TABLE IF EXISTS subjects;
DROP TABLE IF EXISTS courses;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS roles;

CREATE TABLE roles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  full_name VARCHAR(120) NOT NULL,
  role_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (role_id) REFERENCES roles(id)
);

CREATE TABLE courses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  description TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE subjects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  course_id INT NOT NULL,
  professor_id INT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (course_id) REFERENCES courses(id),
  FOREIGN KEY (professor_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE enrollments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT NOT NULL,
  subject_id INT NOT NULL,
  status VARCHAR(30) NOT NULL DEFAULT 'Enrolled',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_student_subject (student_id, subject_id),
  FOREIGN KEY (student_id) REFERENCES users(id),
  FOREIGN KEY (subject_id) REFERENCES subjects(id)
);

CREATE TABLE exams (
  id INT AUTO_INCREMENT PRIMARY KEY,
  subject_id INT NOT NULL,
  title VARCHAR(150) NOT NULL,
  file_path VARCHAR(255) NULL,
  schedule_at DATETIME NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (subject_id) REFERENCES subjects(id)
);

CREATE TABLE grades (
  id INT AUTO_INCREMENT PRIMARY KEY,
  exam_id INT NOT NULL,
  student_id INT NOT NULL,
  score DECIMAL(10,2) NOT NULL,
  max_score DECIMAL(10,2) NOT NULL DEFAULT 100,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (exam_id) REFERENCES exams(id),
  FOREIGN KEY (student_id) REFERENCES users(id)
);

CREATE TABLE lost_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  reporter_id INT NOT NULL,
  item_details TEXT NOT NULL,
  image_path VARCHAR(255) NULL,
  location VARCHAR(200) NOT NULL,
  reported_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (reporter_id) REFERENCES users(id)
);

CREATE TABLE found_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  reporter_id INT NOT NULL,
  item_details TEXT NOT NULL,
  image_path VARCHAR(255) NULL,
  location VARCHAR(200) NOT NULL,
  reported_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (reporter_id) REFERENCES users(id)
);

CREATE TABLE claims (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT NOT NULL,
  lost_item_id INT NULL,
  found_item_id INT NULL,
  ownership_verification TEXT NOT NULL,
  status VARCHAR(30) NOT NULL DEFAULT 'Pending',
  claim_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (student_id) REFERENCES users(id),
  FOREIGN KEY (lost_item_id) REFERENCES lost_items(id) ON DELETE SET NULL,
  FOREIGN KEY (found_item_id) REFERENCES found_items(id) ON DELETE SET NULL
);

CREATE TABLE announcements (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  content TEXT NOT NULL,
  posted_by_id INT NOT NULL,
  publish_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (posted_by_id) REFERENCES users(id)
);

INSERT INTO roles (name) VALUES ('Admin'), ('Professor'), ('Student');

INSERT INTO users (username, password_hash, full_name, role_id) VALUES
('admin', 'Admin@123', 'System Administrator', 1),
('prof1', 'Prof@123', 'Professor One', 2),
('stud1', 'Stud@123', 'Student One', 3);

INSERT INTO courses (name, description) VALUES ('BSIT', 'Bachelor of Science in Information Technology');
INSERT INTO subjects (name, course_id, professor_id) VALUES ('Web Development', 1, 2);
INSERT INTO enrollments (student_id, subject_id, status) VALUES (3, 1, 'Enrolled');
