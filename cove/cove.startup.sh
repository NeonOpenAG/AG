#!/bin/bash

/etc/init.d/nginx restart
cd /opt/cove
export DJANGO_SETTINGS_MODULE=cove_iati.settings
python3 manage.py migrate
python3 manage.py compilemessages
python3 manage.py runserver

