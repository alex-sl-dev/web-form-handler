# Web Form Handler on Plain PHP



## Installation PHP dependencies via composer

```bash
composer install 
composer update
```

## Setup database
Don't forget about weather in your region. Maybe need add a town,
check around the world! (You can't see Event Session)
```bash
mysql -u root -p myDB < schema.sql
```

## Configuration for script 

Copy sample of configuration file. Define values for your envelope.

```bash
cp config.sample.ini config.ini
```

## Run web script

```bash
php -S 0.0.0.0:8888 -t public
```
