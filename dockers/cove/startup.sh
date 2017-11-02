#!/bin/bash

if [ ! -z "$PROCESS_DATA" ]; then
	/usr/local/bin/process.sh
	exit $?
fi

cd /opt/cove
export DJANGO_SETTINGS_MODULE=cove_iati.settings
python3 manage.py runserver 0.0.0.0:8000

