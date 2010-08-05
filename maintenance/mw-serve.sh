#! /bin/sh

case "$1" in
start)

echo "Starting mw-serve... "
# defaults to FastCGI, port 8899 on localhost, no daemonization
#su -c "PYTHONPATH=/opt/mwlib/lib/python2.5/site-packages \
#PATH=/usr/bin:/bin:/opt/mwlib/bin \
#PYTHON_EGG_CACHE=/opt/mwlib/var/cache/python-eggs \
#/opt/mwlib/bin/mw-serve \
su -c "/usr/bin/mw-serve \
  -p 8899 \
  -P http \
  -d \
  --cache-dir='/var/cache/pdfserver/' \
  --mwrender-logfile='/var/log/mw-serve/mw-render.log' \
  --mwzip-logfile='/var/log/mw-serve/mw-zip.log' \
  --mwpost-logfile='/var/log/mw-serve/mw-post.log' \
  --logfile='/vari/log/mw-serve/mw-serve.log' \
  --pid-file='/var/run/mw-serve.pid' \
  --report-from-mail=wikimaster@geneabase.com \
  --report-recipient=wikimaster@geneabase.com" www-data
;;

stop)
PIDFILE=/opt/mwlib/var/run/mw-serve.pid
if [ -e $PIDFILE ]; then
  PID=`cat $PIDFILE`
  echo -n "Stopping mw-serve, killing PID $PID..."
  if ! kill $PID; then
    echo "can't kill it."
  else
    echo "done."
    rm -f $PIDFILE
  fi
else
  echo "mw-serve does not appear to be running."
fi
;;

reload|force-reload)
echo "Reload not supported for mw-serve yet."
;;

restart)
"$0" stop && "$0" start
;;

*)
echo "Usage: /etc/init.d/mw-serve {start|stop|restart}"
exit 1
esac

exit 0
