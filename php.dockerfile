FROM yiisoftware/yii2-php:7.2-apache

MAINTAINER Creditstar IT <it@creditstar.com>

RUN apt-get update
RUN apt-get upgrade -y

RUN apt-get install -y --no-install-recommends postgresql-client || true


