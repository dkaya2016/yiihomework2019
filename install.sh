#!/bin/sh

docker-compose run --rm php composer update --prefer-dist

docker-compose run --rm php composer install

docker-compose up -d
docker-compose run --rm php sh is-db-ready.sh "db" "php yii migrate --interactive=0"
docker-compose run --rm php sh is-db-ready.sh "db_test" "php tests/bin/yii migrate --interactive=0"
