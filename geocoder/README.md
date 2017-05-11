# Open aid geocoder

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

Open aid geocoder now avilable at http://localhost:8009/

Dockerhub [here](https://hub.docker.com/r/tobybatch/ag-oageocoder/).


