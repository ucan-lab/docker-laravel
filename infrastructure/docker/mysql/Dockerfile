FROM mysql:8.0

ENV TZ=UTC \
  MYSQL_DATABASE=laravel_local \
  MYSQL_USER=phper \
  MYSQL_PASSWORD=secret \
  MYSQL_ROOT_PASSWORD=secret

RUN mkdir -p /var/log/mysql && \
  touch /var/log/mysql/mysql-error.log && \
  touch /var/log/mysql/mysql-slow.log && \
  touch /var/log/mysql/mysql-query.log && \
  chown -R mysql:mysql /var/log/mysql

COPY ./my.cnf /etc/my.cnf
