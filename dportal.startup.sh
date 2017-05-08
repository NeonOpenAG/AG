#!/bin/bash

/etc/init.d/nginx restart
cd /opt/D-Portal/dportal
bash node js/serv.js --port=1337 --database=db/dstore.sqlite
bash

