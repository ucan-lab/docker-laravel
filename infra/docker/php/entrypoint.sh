#!/bin/sh
set -e

UID=${UID}
GID=${GID}
USERNAME=${USERNAME}

echo "Starting with UID: $UID, GID: $GID, USERNAME: $USERNAME"

useradd -u "$UID" -o -m "$USERNAME"
groupmod -g "$GID" "$USERNAME"

mkdir -p /home/"$USERNAME"/.config/psysh
chown "$USERNAME":"$USERNAME" /home/"$USERNAME"/.config/psysh
chown "$USERNAME":"$USERNAME" /composer
chown "$USERNAME":"$USERNAME" /workspace

export HOME=/home/"$USERNAME"

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

exec gosu "$USERNAME" "$@"
