#!/bin/bash

# docker run --name agmysql -e MYSQL_ROOT_PASSWORD=PASSWORD -v agmysql:/var/lib/mysql -d mysql

mysql -u root -p${MYSQL_ROOT_PASSWORD} -h mysql agrovoc_autocode
if [ "$?" != "0" ]; then
    mysql -u root -p${MYSQL_ROOT_PASSWORD} -h mysql < /var/tmp/install.sql
fi

