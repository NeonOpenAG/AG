#!/bin/bash

export PATH=/root/.nvm/versions/node/v8.5.0/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin
cd /opt/D-Portal
ctrack/watch 1>&2 &

cd /opt/D-Portal/dportal
source settings
./node_modules/.bin/plated watch --dumpjson --root=$PLATED_ROOT/ --output=$PLATED_OUTPUT --source=$PLATED_SOURCE &
node js/serv.js --port 8011
