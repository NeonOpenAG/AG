#!/bin/bash

/etc/init.d/nginx restart
cd /opt/D-Portal
./serv -q http://d-portal.org/
# for dev use this next bash command will mean the conainer does not exit when the dportal service stops
bash

