#!/bin/bash

/etc/init.d/nginx restart
cd /opt/D-Portal
./serv -q http://d-portal.org/
bash

