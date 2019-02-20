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
