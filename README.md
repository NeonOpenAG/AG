# AG Dockers

## CoVE

This docker image builds off the base python 3 image and runs CoVE in the native python.  It is fronted with a ngix proxy.  The CoVE git hub repo is pulled into /opt/cove and branch 602-convert-upload is checkedout.  The docker entry point is a shell script in /usr/local/bin called startup.sh.  It startes ngix, sets the DJANGO_SETTINGS_MODULE variable, runs migrate, compile messages and runs the server.  The server is exposed on http://127.0.0.1/8008 on the host machine.

    docker pull tobybatch/ag-cove
    docker run -ti -p 8008:8008 tobybatch/ag-cove

## Open aid geocoder

This docker image builds off the base node 4.4.3 image and runs the open aid geocoder in the native node environment.  It is fronted with a ngix proxy.  The open aid geocoder git hub repo is pulled into /opt/open-aid-geocoder.  The docker entry point is a shell script in /usr/local/bin called startup.sh.  It startes ngix, and then runs the node server.  The server is exposed on http://127.0.0.1/8009 on the host machine.

We are forced to expose the 3333 port as the JS tools hoit it directly.

    docker pull tobybatch/ag-oageocoder
    docker run -ti -p 8009:8009 -p 3333:3333 -v open-aid-geocoder-data:/opt/open-aid-geocoder/api/data/ tobybatch/ag-oageocoder

## OIPA

This docker is built from the base ubuntu xenial image (16.04) and is then run in a virtual python environment.  It is fronted with a ngix proxy.  The OIPA git hub repo is pulled into /opt/oipa and a postgress db is iniitailised.  The docker entry point is a shell script in /usr/local/bin called startup.sh.  It starts the nginx, postgress and redis servers, runs the migrate function and creates a user called docker with a password of docker.  The server is exposed on http://127.0.0.1/8010 on the host machine.

    docker pull tobybatch/ag-oipa
    docker run -ti -p 8010:8010 tobybatch/ag-oipa

--------------------

## TODO

 * Proxy forward the 3333 port for geocoded data.
 * https://github.com/devinit/D-Portal
 * Fix user creation in oipa application.
