FROM php:fpm-buster
# タイムゾーン(東京)
ENV TZ Asia/Tokyo
# 色々パッケージとか追加(パッケージの操作管理などに使うツール類？とmysqliパッケージ)
RUN apt-get update \
&& apt-get install -y \
git \
zip \
unzip \
vim \
libpq-dev \
&& docker-php-ext-install pdo_mysql pdo_pgsql mysqli
# メール受信用のやつのSMTPサーバーとかポートなどいろいろ設定
RUN curl -sSL https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 -o mhsendmail \
    && chmod +x mhsendmail \
    && mv mhsendmail /usr/local/bin/mhsendmail \
    && echo 'sendmail_path = "/usr/local/bin/mhsendmail --smtp-addr=mailhog:1025"' > /usr/local/etc/php/conf.d/sendmail.ini

COPY src /usr/share/nginx/html
