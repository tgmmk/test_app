#ベースイメージ。php DockerHub公式イメージをベースに。
FROM php:8.1-fpm-buster

# コンテナ内のサーバー環境変数の設定
# https://matsuand.github.io/docs.docker.jp.onthefly/engine/reference/builder/#env
ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_HOME=/composer

# https://matsuand.github.io/docs.docker.jp.onthefly/engine/reference/builder/#copy
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# apt関係
# https://matsuand.github.io/docs.docker.jp.onthefly/engine/reference/builder/#run

    # インストール可能なパッケージ一覧更新
RUN apt-get update && \
    # Laravelに必要なパッケージインストール
    #  --no-install-recommends：不要なパッケージのインストール防止
    apt-get -y install --no-install-recommends git unzip libzip-dev libicu-dev libonig-dev && \
    # パッケージインストールで使用したキャッシュファイル削除
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* && \
    #  PHPの拡張ライブラリインストール
    docker-php-ext-install intl pdo_mysql zip bcmath

# https://matsuand.github.io/docs.docker.jp.onthefly/engine/reference/builder/#copy
COPY ./php.ini /usr/local/etc/php/php.ini

# https://matsuand.github.io/docs.docker.jp.onthefly/engine/reference/builder/#workdir
WORKDIR /data
