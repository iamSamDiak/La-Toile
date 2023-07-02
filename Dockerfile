FROM php:8.2.7-apache

WORKDIR /app

COPY . /app

EXPOSE 8000