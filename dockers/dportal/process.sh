#!/bin/bash

if [ -z "$FILENAME" ]; then
	FILENAME="unknown"
fi

cd /opt/D-Portal
rm /opt/D-Portal/dstore/cache/*
echo "$(</dev/stdin)" > /opt/D-Portal/dstore/cache/$FILENAME
/bin/bash /opt/D-Portal/bin/dstore_import_cache 2> /tmp/error.log 1> /tmp/output.log

cat /tmp/output.log
if [ -e "$ERR" ]; then
  (>&2 /bin/cat /tmp/error.log)
fi

