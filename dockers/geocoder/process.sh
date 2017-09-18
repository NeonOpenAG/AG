#!/bin/bash

# python3 src/main.py -c geocode -f example.pdf  -tGN && cat out.tsv
# python3 src/main.py -c geocode -f /tmp/file.txt -tGH

echo "$(</dev/stdin)" > /tmp/file.txt
cd /opt/geocoder-ie

cmd="python3 src/main.py -c geocode -f /tmp/file.txt -t$country"
echo $cmd
$cmd > out.txt

/bin/cat out.tsv
/bin/cat out.txt >&2

/bin/bash
