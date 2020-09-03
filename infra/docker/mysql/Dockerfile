FROM mysql:8.0
LABEL maintainer="ucan-lab <yes@u-can.pro>"

ENV TZ=UTC \
  MYSQL_DATABASE=laravel_local \
  MYSQL_USER=phper \
  MYSQL_PASSWORD=secret \
  MYSQL_ROOT_PASSWORD=secret

COPY ./my.cnf /etc/my.cnf
