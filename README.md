# lottery app
This app is built with the usage of Symfony 4 Framework

Installation
```
cp .env .env.local
```
set db settings at 
```
DATABASE_URL=mysql://db_user:db_pass@127.0.0.1:3306/db_name
```
```
composer install
bin/console doctrine:schema:update --force
```

that's it

you can run development server by using:
```
bin/console server:start
```
# Command
Command to run sending pending money gifts ():
```
bin/console lottery:send-to-bank-money
```
or
```
bin/console lottery:send-to-bank-money 20
```
where argument is a batch number

Command can be found here: src/Command/LotterySendToBankMoneyCommand.php
# Tests
Tests can be launched through:
```
bin/phpunit tests
```
tests can be found here: tests/LotterySericeTest.php
