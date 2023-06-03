FROM mysql/mysql-server:8.0

ENV TZ=UTC

RUN mkdir /var/log/mysql \
  && chown mysql:mysql $_ \
  && chmod 777 $_
