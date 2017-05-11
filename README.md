# AG Dockers

## CoVE

This docker image builds off the base python 3 image and runs CoVE in the native python.  It is fronted with a ngix proxy.  The CoVE git hub repo is pulled into /opt/cove and branch 602-convert-upload is checkedout.  The docker entry point is a shell script in /usr/local/bin called startup.sh.  It startes ngix, sets the DJANGO_SETTINGS_MODULE variable, runs migrate, compile messages and runs the server.  The server is exposed on http://127.0.0.1/8008 on the host machine.

    docker run -ti -p 8008:8008 tobybatch/ag-cove

CoVE now aailable at http://localhost:8008/

Details of this docker [here](https://github.com/neontribe/AG/tree/develop/cove).

Dockerhub [here](https://hub.docker.com/r/tobybatch/ag-cove/).

## Open aid geocoder

This docker image builds off the base node 4.4.3 image and runs the open aid geocoder in the native node environment.  It is fronted with a ngix proxy.  The open aid geocoder git hub repo is pulled into /opt/open-aid-geocoder.  The docker entry point is a shell script in /usr/local/bin called startup.sh.  It startes ngix, and then runs the node server.  The server is exposed on http://127.0.0.1/8009 on the host machine.

We are forced to expose the 3333 port as the JS tools hoit it directly.

The following instructions assume you are in the root folder of this repo

    cd geocoder
    export APP_HOME=$(pwd)
    rm data/project-data.json # If you want an *empty* install
    docker run -ti \
        -p 8009:8009 \
        -p 3333:3333 \
        -v $APP_HOME/data:/opt/open-aid-geocoder/api/data/ \
        -v $APP_HOME/uploads:/opt/open-aid-geocoder/api/uploads/ \
        -v $APP_HOME/conf:/opt/open-aid-geocoder/app/conf \
        tobybatch/ag-oageocoder

Open aid geocoder now aailable at http://localhost:8009/

Details of this docker [here](https://github.com/neontribe/AG/tree/develop/geocoder).

Dockerhub [here](https://hub.docker.com/r/tobybatch/ag-oageocoder/).

## OIPA

This docker is built from the base ubuntu xenial image (16.04) and is then run in a virtual python environment.  It is fronted with a ngix proxy.  The OIPA git hub repo is pulled into /opt/oipa and a postgress db is iniitailised.  The docker entry point is a shell script in /usr/local/bin called startup.sh.  It starts the nginx, postgress and redis servers, runs the migrate function and creates a user called docker with a password of docker.  The server is exposed on http://127.0.0.1/8010 on the host machine.

    docker run -ti -p 8010:8010 tobybatch/ag-oipa

OIPA now aailable at http://localhost:8010/

Details of this docker [here](https://github.com/neontribe/AG/tree/develop/oipa).

Dockerhub [here](https://hub.docker.com/r/tobybatch/ag-oipa/).

## D-Portal

This docker is built from the base ubuntu xenial image (16.04) and then node is installed.  It is fronted with a ngix proxy.  The D-Portal git hub repo is pulled into /opt/D-Portal.  The dportal install scrtipts are then run, (```bin/npm_install, ./dstore init```), and then the data is imported (```./dstore_import_bd_ug_hn```). It starts the nginx server and then the node server.

    docker run -ti -p 1408:1408 -p 8011:8011 tobybatch/ag-dportal

D-Portal now aailable at http://localhost:8011/

Details of this docker [here](https://github.com/neontribe/AG/tree/develop/dportal).

Dockerhub [here](https://hub.docker.com/r/tobybatch/ag-dportal/).

--------------------

## TODO

 * Fix user creation in oipa application.
