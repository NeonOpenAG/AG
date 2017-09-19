#!/bin/bash

cd /opt/cove
echo "$(</dev/stdin)" > /tmp/file.csv
CMD="/opt/cove/iati-cli -d -o /tmp/out /tmp/file.csv"
$CMD > /tmp/err.log
XML=/tmp/out/unflattened.xml
ERR=/tmp/out/results.json
if [ -e "$XML" ]; then
  cat $XML
fi
if [ -e "$ERR" ]; then
  (>&2 /bin/cat $ERR)
fi
