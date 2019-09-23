#!/bin/bash

git pull

sh $(dirname $0)/npm.sh

composer install
composer update

php artisan migrate