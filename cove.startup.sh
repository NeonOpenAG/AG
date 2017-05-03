#!/bin/bash

/etc/init.d/nginx restart
cd /opt/cove
python manage.py migrate
python manage.py compilemessages
python manage.py runserver

