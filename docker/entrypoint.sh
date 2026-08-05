#!/bin/sh
set -eu

attempt=1
while [ "$attempt" -le 20 ]; do
  if php /var/www/html/bin/setup.php; then
    break
  fi
  if [ "$attempt" -eq 20 ]; then
    echo "Database setup did not complete." >&2
    exit 1
  fi
  attempt=$((attempt + 1))
  sleep 3
done

exec "$@"
