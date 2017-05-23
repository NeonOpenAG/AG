#!/bin/bash

function usage {
    echo $USAGE
    cat <<EOF

Start the Open Agricultural Data Dockers in daemon mode.

h   Print help
v   Verbose output, including instruction for stopping/connecting

ACTIONs

status
    Show the status of the Open Agricultural Data Dockers.
start
    Start the docker, eithe rrunning new ones or starting stopped ones.
stop
    Stop the dockers.
destroy
    Stop and destroy the dockers.  Usae this reset the dockers to initial
    state.  If you also "rm -rf $HOME/.openag/data you will remoce
    persisted data.
restart
    stop and start
EOF
}

function destroy_dockers {
    stop_dockers
    IDS=$(docker ps -a -q --filter name=openag_ --format="{{.ID}}")
    for ID in $IDS; do
        echo Removing $ID
        docker rm $ID
    done
}

function stop_dockers {
    IDS=$(docker ps -a -q --filter name=openag_ --format="{{.ID}}")
    for ID in $IDS; do
        echo Stopping $ID
        docker stop $ID
    done
}

function start_dockers {
    start_docker openag_cove
    start_docker openag_oageocoder
    start_docker openag_oipa
    start_docker openag_dportal
}

function start_docker {
    NAME=$1
    echo "Processing $NAME"
    ID=$(docker ps -a -q --filter name=$NAME --format="{{.ID}}")
    if [ -z "$ID" ]; then
        echo "Running $NAME"
        run_$NAME
        return
    fi
    # If it's stopped, start it
    ID=$(docker ps -a -q --filter name=$NAME --filter "status=exited" --format="{{.ID}}")
    if [ ! -z "$ID" ]; then
        echo "Starting $NAME"
        docker start $NAME
        return
    fi
    echo "$NAME already running"
}

function run_openag_manager {
    docker run -it --link openag_dportal --link openag_oipa --link openag_oageocoder --link openag_cove 8a045896c67e /bin/bash
}

function run_openag_cove {
    docker run \
        -d \
        -p 8008:8008 \
        -v $PERSIST_COVE_MEDIA:/opt/cove/media \
        --name openag_cove \
        tobybatch/ag-cove
}

function run_openag_oageocoder {
    docker run \
        -d \
        -p 8009:8009 -p 3333:3333 \
        -v $PERSIST_GEO_DATA:/opt/open-aid-geocoder/api/data/ \
        -v $PERSIST_GEO_UPLOADS:/opt/open-aid-geocoder/api/uploads/ \
        -v $PERSIST_GEO_CONF:/opt/open-aid-geocoder/app/conf \
        --name openag_oageocoder \
        tobybatch/ag-oageocoder
}

function run_openag_oipa {
    docker run \
        -d \
        -p 8010:8010 \
        --name openag_oipa \
        tobybatch/ag-oipa
}

function run_openag_dportal {
    docker run \
        -d \
        -p 1408:1408 -p 8011:8011 \
        --name openag_dportal \
        tobybatch/ag-dportal
}


