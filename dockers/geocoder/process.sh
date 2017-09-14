#!/bin/bash

# python3 src/main.py -c geocode -f example.pdf  -tGN && cat out.tsv

echo "$(</dev/stdin)" > /tmp/file
cat /tmp/file

# cd /opt/geocoder-ie
# python3 src/main.py -c geocode -f /tmp/file -t${country} > out.txt

# /bin/cat out.tsv
# /bin/cat out.txt >&2
