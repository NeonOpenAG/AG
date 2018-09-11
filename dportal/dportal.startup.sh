#!/bin/bash

cd /opt/D-Portal
ctrack/watch 1>&2 &

cd /opt/D-Portal/dportal
source settings
./node_modules/.bin/plated watch --dumpjson --root=$PLATED_ROOT/ --output=$PLATED_OUTPUT --source=$PLATED_SOURCE &

if [ -e "/data/$IATI_XML" ]; then
  echo "-= Import data exists =-"
  mkdir -p /opt/D-Portal/dstore/cache/
  cp /data/$IATI_XML /opt/D-Portal/dstore/cache/$IATI_XML
  echo "Clearing data ..."
  rm /opt/D-Portal/dstore/cache/*  
  echo "cleared. Importing...."
  /bin/bash /opt/D-Portal/bin/dstore_import_cache 2> /tmp/error.log 1> /tmp/output.log
  echo "Done"
  cat /tmp/output.log
  if [ -e "$ERR" ]; then
      (>&2 /bin/cat /tmp/error.log)
  fi
fi

node js/serv.js --port 8011
