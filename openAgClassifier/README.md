Open Ag Classifier
==================

This docker depends on mysql:

    docker volume create --name agmysql
    docker run --name agmysql -e MYSQL_ROOT_PASSWORD=PASSWORD -v agmysql:/var/lib/mysql -d mysql

And then can be started with:

    docker run -e MYSQL_ROOT_PASSWORD=inventedreadywatchgasoline --link agmysql -ti CONTAINER_ID

Currently it drops you insta bash shell as the trainer does not function.
