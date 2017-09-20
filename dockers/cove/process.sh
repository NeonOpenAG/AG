#!/bin/bash

if [ -z "$FILENAME" ]; then
	FILENAME="unknown"
fi

cd /opt/cove
echo "$(</dev/stdin)" > /tmp/$FILENAME
CMD="/opt/cove/iati-cli -d -o /tmp/out /tmp/$FILENAME"
$CMD > /dev/null 2>&1
ERR=/tmp/out/results.json

cat /tmp/out/*.xml
if [ -e "$ERR" ]; then
  (>&2 /bin/cat $ERR)
fi

