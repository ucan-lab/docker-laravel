FROM nginx:1.20
SHELL ["/bin/bash", "-oeux", "pipefail", "-c"]

WORKDIR /data

ENV TZ=UTC

COPY ./infra/docker/nginx/*.conf /etc/nginx/conf.d/
