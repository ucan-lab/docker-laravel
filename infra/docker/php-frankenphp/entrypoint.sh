#!/bin/sh
set -e

UID=${UID:-1000}
GID=${GID:-1000}
USERNAME=${USERNAME:-phper}

echo "Starting with UID: $UID, GID: $GID, USERNAME: $USERNAME"

if ! id "$USERNAME" >/dev/null 2>&1; then
  useradd -u "$UID" -o -m "$USERNAME"
fi
# Align the primary group GID when possible; ignore when the GID already exists
# (e.g. a host GID that collides with a system group, common on macOS).
groupmod -g "$GID" "$USERNAME" 2>/dev/null || true

mkdir -p /home/"$USERNAME"/.config/psysh
chown -R "$USERNAME":"$USERNAME" /home/"$USERNAME"
chown "$USERNAME":"$USERNAME" /composer
chown "$USERNAME":"$USERNAME" /workspace
# FrankenPHP (Caddy) writable state dirs
chown -R "$USERNAME":"$USERNAME" /data /config 2>/dev/null || true

export HOME=/home/"$USERNAME"

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
  set -- frankenphp run --config /etc/frankenphp/Caddyfile "$@"
fi

exec gosu "$USERNAME" "$@"
