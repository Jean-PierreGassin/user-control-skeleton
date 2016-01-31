CREATE TABLE IF NOT EXISTS users (
        id INT(6) AUTO_INCREMENT PRIMARY KEY,
        user VARCHAR(30) UNIQUE NOT NULL,
        password VARCHAR(100) NOT NULL,
        first_name VARCHAR(30) NOT NULL,
        last_name VARCHAR(30) NOT NULL,
        user_group INT(2) NOT NULL);
