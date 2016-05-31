# Jean-PierreGassin/user-control-skeleton

A basic user control skeleton which was created for the sole purpose of personal development.

## Requirements

* A MySQL Database (currently tested on MySQL)
* PHP 5.4+ (untested in previous versions)
* [node](http://node.js.org)
* [bower](http://bower.io): `npm install bower -g`

## Installation/usage

* Re-name 'env.example' to '.env' and configure
* Create the table set in your .env file
* Run `npm install`
* Run `bower install`
* Run `composer install`
* Run `gulp`
* Run the following SQL:

```sql
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
This is not recommended for commercial use
