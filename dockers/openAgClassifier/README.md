Open Ag Classifier
==================

The auto-classifier is a 24gb memory behemoth so we don't sdvise running it locally.  There is an AWC instance with it.

You need to set up a mysql instance and set up the following, the ```create_hierarchy_table.sql``` can be found [here](https://raw.githubusercontent.com/fcappdev/OpenAgClassifier/master/db/create_hierarchy_table.sql):

    CREATE DATABASE IF NOT EXISTS agrovoc_autocode;
    USE agrovoc_autocode;
    CREATE TABLE `agrovoc_autocode`.`agrovoc_terms` (
        L1 varchar(128) DEFAULT NULL,
        L2 varchar(128) DEFAULT NULL,
        L3 varchar(128) DEFAULT NULL,
        L4 varchar(128) DEFAULT NULL,
        L5 varchar(128) DEFAULT NULL,
        L6 varchar(128) DEFAULT NULL,
        L7 varchar(128) DEFAULT NULL,
        Code  varchar(128) DEFAULT NULL,
        `Use?` varchar(128) DEFAULT NULL
    );
    source create_hierarchy_table.sql

Then start the docker with:

    docker run \
        -e SQL_HOST=${SQL_HOST} \
        -e SQL_USER=${SQL_USER} \
        -e SQL_PORT=${SQL_PORT} \
        -e SQL_PASSWORD=${SQL_PASSWORD} \
        -p 8013:8013 \
        -p 9091:9091 \
        --link openag_mysql \
        -ti openagdata/autogeocoder

E.g.

    docker run \
        -e SQL_HOST=open-ag-classifier-mysql.cpd6ve6te6op.us-west-2.rds.amazonaws.com \
        -e SQL_USER=classifier \
        -e SQL_PORT=3306 \
        -e SQL_PASSWORD=${SQL_PASSWORD} \
        -p 8013:8013 \
        -p 9091:9091 \
