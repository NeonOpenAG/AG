#!/bin/bash

# python3 src/main.py -c geocode -f example.pdf  -tGN && cat out.tsv
# python3 src/main.py -c geocode -f /tmp/file.txt -tGH

if [ -z "$FILENAME" ]; then
    FILENAME=/tmp/file.xml
fi

if [ -z "$COUNTRY" ]; then
    COUNTRY=""
else
    COUNTRY="-t$COUNTRY"
fi

echo "$(</dev/stdin)" > $FILENAME 
cd /opt/geocoder-ie

cmd="python3 src/main.py -c geocode -f $FILENAME $COUNTRY -o json"
$cmd 2> /tmp/error.log 1> /tmp/output.log

/bin/cat out.json
echo "\n--- Out ---\n" >&2
/bin/cat /tmp/output.log >&2
echo "\n--- Err ---\n" >&2
/bin/cat /tmp/error.log >&2
