FROM alpine:latest AS scss_builder
RUN apk add sassc
COPY ./static/css/style.scss /tmp
RUN sassc --line-numbers /tmp/style.scss /tmp/style.css

FROM docker.io/library/php:8-apache AS final
# Enable Apache rewrite engine
RUN a2enmod rewrite
# Install mysql PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql

COPY --chown=33:33 . /var/www/html
COPY --from=scss_builder /tmp/style.css /var/www/html/static/css

EXPOSE 80