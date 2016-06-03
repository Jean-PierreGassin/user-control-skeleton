CREATE DATABASE user_control_skeleton;

CREATE TABLE IF NOT EXISTS user_control_skeleton.users (
    id INT(6) AUTO_INCREMENT PRIMARY KEY,
    user VARCHAR(30) UNIQUE NOT NULL,
    password VARCHAR(100) NOT NULL,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    usergroup INT(1) DEFAULT 1,
		created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		updated_at TIMESTAMP NULL,
		deleted_at TIMESTAMP NULL,
		deleted INT(1) DEFAULT 0
) DEFAULT CHARSET=utf8;
