 UserBalance service
============
 Backend RPC service. Part of the microservice core that contains business logic.

## Stack

- PHP 8.0
- Mysql 8

## Requests

List of all users.

`'http://localhost/'`

User detail page.

`'http://localhost:9501/user/1'`

Increase user balance.

`'http://localhost/balance/1/increase/5.34'`

Decrease user balance.

`'http://localhost/balance/1/decrease/1.13'`

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

