#!/bin/sh
# run.sh

until pg_isready -h postgresdb -p 5432; do
  >&2 echo "Postgres is unavailable - sleeping"
  sleep 1
done

>&2 echo "Postgres is up - executing command"
exec psql "host='postgresdb' port='5432' dbname='kddb' user='user' password='password'" -f /var/www/site/create_db.sql > /dev/null &

: "${APACHE_CONFDIR:=/etc/apache2}"
: "${APACHE_ENVVARS:=$APACHE_CONFDIR/envvars}"
if test -f "$APACHE_ENVVARS"; then
	. "$APACHE_ENVVARS"
fi

# Apache gets grumpy about PID files pre-existing
: "${APACHE_RUN_DIR:=/var/run/apache2}"
: "${APACHE_PID_FILE:=$APACHE_RUN_DIR/apache2.pid}"
rm -f "$APACHE_PID_FILE"

exec /usr/sbin/apache2ctl -D FOREGROUND

exec tail -f /dev/null

