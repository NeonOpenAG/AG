#!/bin/bash -e

function usage {
    echo $USAGE
    cat <<EOF

Start the Open Agricultural Data Dockers in daemon mode.

Docker names are:
 * cove
 * geocoder
 * oipa
 * dportal
 * manager

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
    Stop and destroy the dockers.  Use this reset the dockers to initial
    state.  If you also "rm -rf $HOME/.openag/data you will remoce
    persisted data.
update
    Pulls the updated git repo.
restart
    stop and start
reset
    Where possible clean out the data store.  Currently only D-Portal supports this
import
    Import data into the specified docker
EOF
}

function destroy_dockers {
    stop_dockers $@
    for ID in $@; do
        echo Removing $ID
        docker rm $ID
    done
}

function stop_dockers {
    for ID in $@; do
        echo Stopping $ID
        docker stop $ID
    done
}

function update_dockers {
    for ID in $@; do
        echo Updating $ID
        docker exec $ID update.sh
    done
}

function start_dockers {
    for DOCKER in $@; do
        start_docker openag_$DOCKER
    done
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

function run_openag_nerserver {
    docker run \
        --name openag_nerserver \
        -p 9000:9000 \
        -dt \
        openagdata/nerserver
}

function run_openag_cove {
    docker run \
        -dt \
        -p 8000:8000 \
        -v $PERSIST_COVE_MEDIA:/opt/cove/media \
        -v $PERSIST_COVE_UPLOAD:/opt/cove/upload \
        --name openag_cove \
        openagdata/cove
}

function run_openag_autogeocoder {
    run_openag_nerserver
    docker run \
        -ti \
        --link openag_nerserver \
        --name openag_autogeocoder \
        openagdata/autogeocoder
}

function run_openag_geocoder {
    set -e
    mkdir -p $PERSIST_GEO_DATA
    mkdir -p $PERSIST_GEO_UPLOADS
    mkdir -p $PERSIST_GEO_CONF
    set +e
    docker run \
        -dt \
        -p 8009:8009 -p 3333:3333 \
        -v $PERSIST_GEO_DATA:/opt/open-aid-geocoder/api/data/ \
        -v $PERSIST_GEO_UPLOADS:/opt/open-aid-geocoder/api/uploads/ \
        -v $PERSIST_GEO_CONF:/opt/open-aid-geocoder/app/conf \
        --name openag_geocoder \
        openagdata/geocoder
}

function run_openag_dportal {
    echo docker run \
        -dt \
        -p 1408:1408 -p 8011:8011 \
        --name openag_dportal \
        -v $PERSIST_DPORTAL_CACHE:/opt/D-Portal/dstore/cache \
        openagdata/dportal
}

function data_reset {
    if [ "$DOCKER" == 'dportal' ]; then
        docker exec openag_dportal /bin/bash /opt/D-Portal/bin/dstore_reset
    else
        echo Unsupported action $2 for $DOCKER
    fi
}

function data_import {
    DOCKER=$1
    FILE=$2

    if [ -z "$DOCKER" ] || [ -z "$FILE" ]; then
        echo $USAGE
        exit 1
    fi

    if [ ! -e "$FILE" ]; then
        echo Cannot locate file $FILE
        exit 1
    fi

    if [ "$DOCKER" == 'cove' ]; then
        cp $FILE $PERSIST_COVE_UPLOAD/$(basename $FILE)
        UPLOAD_FOLDER=$(docker exec -ti openag_$DOCKER python manage.py upload /opt/cove/upload/$(basename $FILE))
        echo $UPLOAD_FOLDER
    elif [ "$DOCKER" == 'dportal' ]; then
        cp $FILE $PERSIST_DPORTAL_CACHE/$(basename $FILE)
        docker exec openag_dportal /bin/bash /opt/D-Portal/bin/dstore_import_cache
    else
        echo Unsupported action $3 for $DOCKER
    fi
}

function openag_install_message {
    echo "openag not installed.  Run 'sudo openag install'"
    echo "or follow the hand install instructions at"
    echo "https://github.com/neontribe/AG/blob/develop/INSTALL.md"
}

function openag_install {
    set -e
    ROOTUID="0"
    if [ "$(id -u)" -ne "$ROOTUID" ] ; then
        openag_install_message
        exit 1
    fi

    if [ -e "$OAGCONF" ]; then
       echo "Configuration already exists at $OAGCONF"
       echo "Refusing to overwrite"
       exit 1
    fi

    mkdir -p $(dirname $OAGCONF)
    mkdir -p $OAGLIB

    echo "Creating openag default config:"
    cat <<EOF > $OAGCONF
export PERSIST_COVE_MEDIA=$OAGLIB/cove/media
export PERSIST_COVE_UPLOAD=$OAGLIB/cove/upload
export PERSIST_GEO_DATA=$OAGLIB/geocoder/data
export PERSIST_GEO_UPLOADS=$OAGLIB/geocoder/uploads
export PERSIST_GEO_CONF=$OAGLIB/geocoder/conf
export PERSIST_DPORTAL_CACHE=$OAGLIB/dportal
EOF
    source /usr/local/etc/openag.conf

    for path in $PERSIST_COVE_MEDIA $PERSIST_COVE_UPLOAD $PERSIST_GEO_DATA $PERSIST_GEO_UPLOADS $PERSIST_GEO_CONF $PERSIST_DPORTAL_CACHE; do
        if [ ! -d "$path" ]; then
            mkdir -p $path
        fi
    done

    if [ ! -f "$PERSIST_GEO_CONF/settings.json" ]; then
        wget -O $PERSIST_GEO_CONF/settings.json https://raw.githubusercontent.com/NeonOpenAG/AG/develop/dockers/geocoder/conf/settings.json
    fi
    set +e
}
