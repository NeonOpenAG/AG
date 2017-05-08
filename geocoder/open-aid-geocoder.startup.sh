#!/bin/bash

/etc/init.d/nginx restart
cd /opt/open-aid-geocoder/scripts
bash ./start.sh
bash

