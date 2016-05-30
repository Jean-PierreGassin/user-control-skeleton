# User Control Skeleton

A basic user control skeleton which was created for the sole purpose of personal development.

## Requirements

  * A MySQL Database (currently tested on MySQL)
  * PHP 5.4+ (untested in previous versions)
  * [bower](http://bower.io): `npm install bower -g`

## Quickstart

  * Clone this repo into your web server
  * composer/bower install
  * Re-name 'env.example' to '.env'
  * Create a 'user_control_skeleton' table
  * Run the following SQL:

  ```
  CREATE TABLE IF NOT EXISTS users (
      id INT(6) AUTO_INCREMENT PRIMARY KEY,
      user VARCHAR(30) UNIQUE NOT NULL,
      password VARCHAR(100) NOT NULL,
      first_name VARCHAR(30) NOT NULL,
      last_name VARCHAR(30) NOT NULL,
      user_group INT(2) NOT NULL
  );
  ```

## NOTE OF CAUTION:
  * Still in development, not for commercial use
