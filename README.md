This project demonstrates various SQL injection (SQLi) techniques and their prevention using secure coding practices in PHP and MySQL.
It includes previously vulnerable examples that are now fully secured using prepared statements.

Files Overview:

| File              | Description                                                                                                                  |
| ----------------- | ---------------------------------------------------------------------------------------------------------------------------- |
| `sqli_test.php`   | Accepts a `GET` parameter (`id`) and fetches user details. Now secured against GET-based SQL injections.                     |
| `update_user.php` | Accepts `POST` data to update a username. Previously allowed second-order SQLi, now fully secured.                           |
| `login.php`       | Accepts `POST` login credentials and validates them. Originally vulnerable to classic and time-based POST SQLi. Now secured. |


Security Features Implemented: 
1. Prepared Statements: All user input is safely bound to SQL queries using mysqli->prepare() and bind_param(), preventing injection.
2. Input Validation: Numeric checks added to sqli_test.php to avoid misuse of non-integer IDs.
3. Second-Order Protection: Inputs stored in the database can no longer break future queries.
4. POST & GET Protection: Both POST (login/update) and GET (id lookup) endpoints are sanitized.

How to Use (on MAMP):
1. Start MAMP and ensure MySQL is running on port 8889
2. Place the files in your htdocs folder (/Applications/MAMP/htdocs)
3. Set up a testdb database with a users table like:
CREATE DATABASE testdb;
USE testdb;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255),
  password VARCHAR(255)
);

INSERT INTO users (username, password) VALUES ('admin', 'admin123'), ('guest', 'guest123');
4. Access each file from your browser:
View users: http://localhost:8888/sqli_test.php?id=1
Update user: http://localhost:8888/update_user.php
Login form: http://localhost:8888/login.php

Testing with SQLMap
You can test the endpoints using SQLMap, an automated tool for SQL injection detection.

Example SQLMap commands:
# Testing GET-based injection
python3 sqlmap.py -u "http://localhost:8888/sqli_test.php?id=1" --batch --dbs

# Testing POST-based injection (update_user.php)
python3 sqlmap.py -u "http://localhost:8888/update_user.php" --data="id=2&username=test" --batch --dbs

# Testing POST-based injection (login.php)
python3 sqlmap.py -u "http://localhost:8888/login.php" --data="username=admin&password=admin123" --batch --dbs

# Testing stacked queries (stacked_test.php)
python3 sqlmap.py -u "http://localhost:8888/stacked_test.php?id=1" --batch --level=3 --risk=3 --technique=S


Educational Purpose
This project is intended for educational and academic demonstration of:
1. SQL injection vulnerabilities
2. The importance of parameterized queries
3. How to harden a PHP backend

To be used responsibly.

