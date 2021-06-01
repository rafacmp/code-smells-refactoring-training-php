#!/bin/sh
set -euo pipefail

if [ -n "${NEWRELIC_LICENSE_KEY-}" ]; then
    cat >/usr/local/etc/php/conf.d/newrelic.ini <<EOF
extension = "newrelic.so"
[newrelic]
newrelic.license = "${NEWRELIC_LICENSE_KEY}"
newrelic.logfile = "/proc/self/fd/2"
newrelic.loglevel = "warning"
newrelic.appname = "course"
newrelic.daemon.address = "${NEWRELIC_DAEMON_HOST}:${NEWRELIC_DAEMON_PORT}"
EOF
fi

exec php-fpm
