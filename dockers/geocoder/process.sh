#!/bin/bash

# python3 src/main.py -c geocode -f example.pdf  -tGN && cat out.tsv
# python3 src/main.py -c geocode -f /tmp/file.txt -tGH

if [ -z "$FILENAME" ]; then
    FILENAME=/tmp/file.xml
fi

if [ -z "$COUNTRY" ]; then
    COUNTRY=uk
fi

echo "$(</dev/stdin)" > $FILENAME 
cd /opt/geocoder-ie

cmd="python3 src/main.py -c geocode -f $FILENAME -t$COUNTRY -o json"
$cmd 2> /tmp/error.log 1> /tmp/output.log

/bin/cat out.json
/bin/cat /tmp/error.log >&2
