#!/bin/bash

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

function run_openag_manager {
    docker run -it --link openag_dportal --link openag_oipa --link openag_geocoder --link openag_cove 8a045896c67e /bin/bash
}

function run_openag_nerserver {
    docker run \
        --name openag_nerserver \
        -dt \
        openagdata/nerserver
}

function run_openag_redis {
    docker run \
        --name openag_redis \
        -v $PERSIST_REDIS:/data \
        -dt \
        redis redis-server \
        --appendonly yes
}

function run_openag_pgsql {
    docker run \
        -dt \
        -e POSTGRES_PASSWORD=oipa \
        -e POSTGRES_USER=oipa \
        -e PGDATA=/var/lib/postgresql/data/pgdata \
        -e POSTGRES_DB=oipa \
        -v $PERSIST_PGSQL:/var/lib/postgresql/data/pgdata \
        --name openag_pgsql \
        postgres
}

# function run_openag_mysql {
    # if [ -z $SQL_ROOT_PASSWORD ]; then
        # echo "Mysql docker password not set. Either enter here or ctrl-c and set it in ~/.openegrc"
        # read SQL_ROOT_PASSWORD
    # fi
    # docker run \
        # -td \
        # -e SQL_ROOT_PASSWORD=$SQL_ROOT_PASSWORD \
        # -v $PERSIST_MYSQL:/var/lib/mysql \
        # --name openag_mysql \
        # mysql
# }

function run_openag_cove {
    docker run \
        -dt \
        -p 8008:8008 \
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
    docker run \
        -dt \
        -p 8009:8009 -p 3333:3333 \
        -v $PERSIST_GEO_DATA:/opt/open-aid-geocoder/api/data/ \
        -v $PERSIST_GEO_UPLOADS:/opt/open-aid-geocoder/api/uploads/ \
        -v $PERSIST_GEO_CONF:/opt/open-aid-geocoder/app/conf \
        --name openag_geocoder \
        openagdata/geocoder
}

function run_openag_oipa {
    run_openag_pgsql
    run_openag_redis
    docker run \
        -dt \
        -p 8010:8010 \
        --link openag_pgsql \
        --link openag_redis \
        --name openag_oipa \
        openagdata/oipa
}

function run_openag_dportal {
    docker run \
        -dt \
        -p 1408:1408 -p 8011:8011 \
        --name openag_dportal \
        -v $PERSIST_DPORTAL_CACHE:/opt/D-Portal/dstore/cache \
        openagdata/dportal
}

# function run_openag_classifier {
    # run_openag_mysql
    # docker run \
        # -e SQL_ROOT_PASSWORD=${SQL_ROOT_PASSWORD} \
        # -p 8013:8013 \
        # -p 9091:9091 \
        # --link openag_mysql \
        # -v openag-claissifier-data:/opt/autocoder/src/model/clf_data \
        # -dt \
        # --name openag_classisifer \
        # openagdata/classifier
# }

function run_openag_master {
    docker run \
        -d \
        -p 7080:80 \
        --name openag_master \
        tobybatch/openag
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
        docker exec -ti openag_$DOCKER python manage.py upload /opt/cove/upload/$(basename $FILE)
    elif [ "$DOCKER" == 'dportal' ]; then
        cp $FILE $PERSIST_DPORTAL_CACHE/$(basename $FILE)
        docker exec openag_dportal /bin/bash /opt/D-Portal/bin/dstore_import_cache
    else
        echo Unsupported action $2 for $DOCKER
    fi
}
