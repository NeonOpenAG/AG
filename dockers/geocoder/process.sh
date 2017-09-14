#!/bin/bash

echo "$(</dev/stdin)" > /tmp/file
FILEPATH=$(python manage.py upload /tmp/file)
BASENAME=$(/usr/bin/basename $FILEPATH)
XML=/opt/cove/media/${BASENAME}/file
ERR=/opt/cove/media/${BASENAME}/*.json
if [ -e "$XML" ]; then
	/bin/cat $XML
fi
if [ -e "" ]; then
	(>&2 /bin/cat )
fi

