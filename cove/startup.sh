#!/bin/bash

echo "$(</dev/stdin)" > /tmp/file
FILEPATH=$(python manage.py upload /tmp/file)
BASENAME=$(/usr/bin/basename $FILEPATH)
echo FILEPATH=$FILEPATH
echo BASENAME=$BASENAME
/bin/ls /opt/cove/media/*
XML=/opt/cove/media/${BASENAME}/file
ERR=/opt/cove/media/${BASENAME}/*.json
/bin/cat $XML
(>&2 /bin/cat $ERR)
