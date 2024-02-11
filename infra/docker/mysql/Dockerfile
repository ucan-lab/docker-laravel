FROM mysql/mysql-server:8.0

ENV TZ=UTC

# RUN <<EOF
#   mkdir /var/log/mysql
#   chown mysql:mysql $_
#   chmod 777 $_
# EOF

RUN mkdir /var/log/mysql && \
    chown mysql:mysql /var/log/mysql && \
    chmod 777 /var/log/mysql
