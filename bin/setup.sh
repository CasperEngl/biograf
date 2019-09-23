#!/bin/bash

git pull

sh $(dirname $0)/npm.sh

composer install
cp .env.example .env

php artisan key:generate
php artisan migrate --seed