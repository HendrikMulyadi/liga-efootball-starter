CREATE DATABASE IF NOT EXISTS liga_efootball CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE liga_efootball;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','viewer') DEFAULT 'viewer'
);

CREATE TABLE teams (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  logo VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE matches (
  id INT AUTO_INCREMENT PRIMARY KEY,
  round_no INT DEFAULT NULL,
  team_home_id INT NOT NULL,
  team_away_id INT NOT NULL,
  match_date DATETIME DEFAULT NULL,
  score_home INT DEFAULT NULL,
  score_away INT DEFAULT NULL,
  status ENUM('scheduled','played') DEFAULT 'scheduled',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (team_home_id) REFERENCES teams(id) ON DELETE CASCADE,
  FOREIGN KEY (team_away_id) REFERENCES teams(id) ON DELETE CASCADE
);

CREATE TABLE players (
  id INT AUTO_INCREMENT PRIMARY KEY,
  team_id INT,
  name VARCHAR(100),
  goals INT DEFAULT 0,
  FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE
);
