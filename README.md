# Jean-PierreGassin/user-control-skeleton

A basic user control skeleton which was created for the sole purpose of personal development.

## Requirements

* MySQL
* PHP 5.4+ (not tested in previous versions)
* [node v4+](http://nodejs.org)
* [bower](http://bower.io): `npm install bower -g`

## Installation/usage

* Re-name 'env.example' to '.env' and configure
* Run `npm install`
* Run `bower install`
* Run `composer install`
* Run `gulp`
* Execute the following SQL and replace table names:

```sql
CREATE DATABASE user_control_skeleton;

CREATE TABLE IF NOT EXISTS user_control_skeleton.users (
    id INT(6) AUTO_INCREMENT PRIMARY KEY,
    user VARCHAR(30) UNIQUE NOT NULL,
    password VARCHAR(100) NOT NULL,
    first_name VARCHAR(30) NOT NULL,
    last_name VARCHAR(30) NOT NULL,
    user_group INT(1) DEFAULT 1,
		created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		updated_at TIMESTAMP NULL,
		deleted_at TIMESTAMP NULL,
		deleted INT(1) DEFAULT 0
) DEFAULT CHARSET=utf8;
```

## NOTE OF CAUTION:
This is not recommended for production environments
