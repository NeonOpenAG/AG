# OIPA

This docker is built from the base ubuntu xenial image (16.04) and is then run in a virtual python environment.  It is fronted with a ngix proxy.  The OIPA git hub repo is pulled into /opt/oipa and a postgress db is iniitailised.  The docker entry point is a shell script in /usr/local/bin called startup.sh.  It starts the nginx, postgress and redis servers, runs the migrate function and creates a user called docker with a password of docker.  The server is exposed on http://127.0.0.1/8010 on the host machine.

## Starting the docker

OIPA relies on pgsql and redis servers so we need to start those first.

If we want to persist data between docker restarts we need to provide a location for these file.  We could use volumes but in the simplest instance we'll just provide a folder on the host machine:

    export PERSIST_DIR=$HOME/.oipa/data
    mkdir -p $PERSIST_DIR/redis
    mkdir -p $PERSIST_DIR/pgsql

Now start the redis and SQL servers:

    docker run \
        --name openag_redis \
        -v $PERSIST_DIR/redis:/data \
        -dt \
        redis redis-server \
        --appendonly yes
    docker run \
        -dt \
        -e POSTGRES_PASSWORD=oipa \
        -e POSTGRES_USER=oipa \
        -e PGDATA=/var/lib/postgresql/data/pgdata \
        -e POSTGRES_DB=oipa \
        -v $PERSIST_DIR/pgsql:/var/lib/postgresql/data/pgdata \
        --name openag_pgsql \
        postgres

And now start the oipa docker:

    docker run \
        -dt \
        -p 8010:8010 \
        --link openag_pgsql \
        --link openag_redis \
        --name openag_oipa \
        openagdata/oipa

OIPA now avilable at http://localhost:8010/

## Changing the oipa password

You can change the oipa password in a running container by attaching to the container and setting the password:

    docker exec -ti `docker ps -a | grep ag-oipa | awk '{print $1}'` sudo -u postgres psql oipa -c "ALTER USER oipa WITH PASSWORD 'new_password';"
