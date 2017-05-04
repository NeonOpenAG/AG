#!/bin/bash
ESC_SEQ="\x1b["
COL_RESET=$ESC_SEQ"39;49;00m"
COL_RED=$ESC_SEQ"31;01m"
COL_GREEN=$ESC_SEQ"32;01m"
COL_YELLOW=$ESC_SEQ"33;01m"
COL_BLUE=$ESC_SEQ"34;01m"
COL_MAGENTA=$ESC_SEQ"35;01m"
COL_CYAN=$ESC_SEQ"36;01m"

/etc/init.d/redis-server start
/etc/init.d/postgresql start

# /etc/init.d/nginx restart
cd /opt/oipa/OIPA
source /opt/oipa/OIPA/.env/bin/activate

python ./manage.py supervisor --daemonize
if [ "$?" != 0 ]; then
  echo
  echo -e "$COL_RED"SERVER DID NOT START CLEAN"$COL_RESET"
  echo
else
  echo
  echo -e "$COL_GREEN"Server Running"$COL_RESET"
  echo
fi

python ./manage.py migrate --noinput
echo "from django.contrib.auth.models import User; User.objects.create_superuser(email='docker@example.com', username='docker', password='docker')" | /opt/oipa/OIPA/manage.py shell
python ./manage.py runserver 0.0.0.0:8010

