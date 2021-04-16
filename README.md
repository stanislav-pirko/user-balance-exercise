 UserBalance service
============

## Task

Suggest a more optimal logic to process the user's balance to avoid deadlocks and incorrect accounting of the balance.
Extend the application with a service with methods for:
* Getting the current balance of the user.
* Increase the user's balance.
* Decrease the user's balance.

The final goal is a clean problem field solution.

## Stack

- PHP 8.0
- Mysql 8

## Requests

List of all users.

`'http://localhost/'`

User detail page.

`'http://localhost/user/1'`

Increase user balance.

`curl --location --request PUT 'localhost/balance/1/increase' --form 'value="1.5"`

Decrease user balance.

`curl --location --request PUT 'localhost/balance/1/decrease' --form 'value="1.5"'`

## Project Setup

Up new environment:

`make install`

Start environment:

`make start`

Stop environment:

`make stop`

See all make commands

`make help`

Full test circle

`make test`

Execute tests:

`tests-unit` 
`tests-integration`

Static code analysis:

`make style`

Code style fixer:

`make coding-standards-fixer`

Code style checker (PHP CS Fixer and PHP_CodeSniffer):

`make coding-standards`

Psalm is a static analysis tool for finding errors in PHP applications, built on top of PHP Parser:

`make psalm`

PHPStan focuses on finding errors in your code without actually running it.

`make phpstan`

Phan is a static analyzer for PHP that prefers to minimize false-positives. Phan attempts to prove incorrectness rather than correctness.

`make phan`

Enter in php container:

`make php-shell`

Watch containers logs

`make logs`

docker-compose run mysql mysql --host=mysql --port=3306 --protocol=tcp -u root -pmysql_pass < ./.docker/mysql/test_dump.sql
