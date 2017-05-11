# AG Dockers

## Docker sources

### Docker files (in this repo)

 * [CoVE Dockerfile](https://github.com/neontribe/AG/tree/develop/cove) and resources.
 * [Open aid geocoder Dockerfile](https://github.com/neontribe/AG/tree/develop/geocoder) and resources.
 * [OIPA Dockerfile](https://github.com/neontribe/AG/tree/develop/oipa) and resources.
 * [D-Portal Dockerfile](https://github.com/neontribe/AG/tree/develop/dportal) and resources.

### Built docker images (on dockerhub)

 * [CoVE on dockerhub](https://hub.docker.com/r/tobybatch/ag-cove/).
 * [Open aid geocoder on dockerhub](https://hub.docker.com/r/tobybatch/ag-oageocoder/).
 * [OIPA on dockerhub](https://hub.docker.com/r/tobybatch/ag-oipa/).
 * [D-Portal on dockerhub](https://hub.docker.com/r/tobybatch/ag-dportal/).

## Quickstart

The dockers are all available on dockerhub and all can be run from there:

### CoVE

    docker run -ti -p 8008:8008 tobybatch/ag-cove

CoVE now aailable at http://localhost:8008/

### Open aid geocoder

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

### OIPA

    docker run -ti -p 8010:8010 tobybatch/ag-oipa

OIPA now aailable at http://localhost:8010/

### D-Portal

    docker run -ti -p 1408:1408 -p 8011:8011 tobybatch/ag-dportal

D-Portal now aailable at http://localhost:8011/

--------------------

## TODO

 * Fix user creation in oipa application.
