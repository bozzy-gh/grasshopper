#!/bin/sh
### BEGIN INIT INFO
# Provides:          grasshopper
# Required-Start:    $local_fs $network $remote_fs
# Should-Start:      ramlog apache2 nginx php5-fpm
# Required-Stop:     $local_fs $network $remote_fs
# Should-Stop:
# Default-Start:     2 3 4 5
# Default-Stop:      0 1 6
# Description:       Grasshopper Monitor Service
### END INIT INFO

NAME="Grasshopper"
SCRIPT="python /var/www/exec/monitor/monitor.py"
USER=root

PIDFILE=/run/grasshopper.pid
LOGFILE=/var/log/grasshopper/monitor.log

start(){
	if [ -f "$PIDFILE" ]; then
		echo "$NAME is already running" >&2
		return 1
	else
		echo "Starting $NAME" >&2
		local CMD="$SCRIPT &> \"$LOGFILE\" & echo \$!"
		su -c "$CMD" $USER > "$PIDFILE"
		echo "$NAME running" >&2
	fi
}

stop(){
	if [ -f "$PIDFILE" ]; then
		echo "Stopping $NAME" >&2
		kill -15 $(cat "$PIDFILE")
		rm "$PIDFILE"
		echo "$NAME stopped" >&2
	else
		echo "$NAME is not running" >&2
		return 1
	fi
}

remove(){
    stop
    rm -f "$PIDFILE"
    update-rc.d -f grasshopper remove
    rm -fv "$0"
}

case "$1" in
	start)
		start
	;;
	stop)
		stop
	;;
	remove)
		remove
	;;
	restart)
		stop
		start
	;;
	*)
		echo "Usage: $0 {start|stop|restart|remove}"
	;;
esac