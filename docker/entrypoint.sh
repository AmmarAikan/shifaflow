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

# Railway may re-enable an Apache MPM when preparing the runtime image.
# PHP's Apache module requires prefork, so normalize the enabled MPMs here
# immediately before the server starts.
if command -v a2dismod >/dev/null 2>&1; then
  a2dismod -f mpm_event mpm_worker >/dev/null 2>&1 || true
  a2enmod mpm_prefork >/dev/null
fi

# Railway assigns each deployment a public port through PORT. Apache defaults
# to port 80, so keep its listener and virtual host in sync with the platform.
if [ -n "${PORT:-}" ]; then
  sed -ri "s/^Listen [0-9]+$/Listen ${PORT}/" /etc/apache2/ports.conf
  sed -ri "s/<VirtualHost \\*:[0-9]+>/<VirtualHost *:${PORT}>/" \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/sites-enabled/*.conf
fi

apache2ctl configtest

exec "$@"
