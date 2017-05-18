# OIPA

This docker is built from the base ubuntu xenial image (16.04) and is then run in a virtual python environment.  It is fronted with a ngix proxy.  The OIPA git hub repo is pulled into /opt/oipa and a postgress db is iniitailised.  The docker entry point is a shell script in /usr/local/bin called startup.sh.  It starts the nginx, postgress and redis servers, runs the migrate function and creates a user called docker with a password of docker.  The server is exposed on http://127.0.0.1/8010 on the host machine.

    docker run -ti -p 8010:8010 tobybatch/ag-oipa

OIPA now avilable at http://localhost:8010/

Dockerhub [here](https://hub.docker.com/r/tobybatch/ag-oipa/).

## Changing the oipa password

You can change the oipa password in a running container by attaching to the container and setting the password:

    docker exec -ti `docker ps -a | grep ag-oipa | awk '{print $1}'` sudo -u postgres psql oipa -c "ALTER USER oipa WITH PASSWORD 'new_password';"
