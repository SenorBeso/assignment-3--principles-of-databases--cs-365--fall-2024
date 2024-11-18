DROP DATABASE IF EXISTS student_passwords;
CREATE DATABASE student_passwords DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
USE student_passwords;
CREATE USER 'passwords_user'@'localhost' IDENTIFIED BY '';
GRANT ALL PRIVILEGES ON student_passwords.* TO 'passwords_user'@'localhost';

-- Website table entity
CREATE TABLE website (
    id INT AUTO_INCREMENT PRIMARY KEY,
    website_name VARCHAR(255) NOT NULL,
    site_url VARCHAR(255) NOT NULL
);

-- Account table entity
CREATE TABLE account_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(64) NOT NULL,
    last_name VARCHAR(64) NOT NULL,
    email VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    comment TEXT
);

-- Register relation table to link the entities for ER diagram
CREATE TABLE register (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account_id INT NOT NULL,
    website_id INT NOT NULL,
    FOREIGN KEY (account_id) REFERENCES account_info(id) ON DELETE CASCADE,
    FOREIGN KEY (website_id) REFERENCES website(id) ON DELETE CASCADE,
    UNIQUE(account_id, website_id)
);

-- Initializing Data
INSERT INTO website (website_name, site_url) VALUES ('example site', 'https://www.test.com');

-- initializing data
INSERT INTO account_info (first_name,last_name, email, username, password, comment) VALUES ('aiden', 'kiss', 'test@example.com', 'testuser', 'password', 'Test account');

-- initializing data
INSERT INTO register (account_id, website_id) VALUES (LAST_INSERT_ID(), LAST_INSERT_ID());
