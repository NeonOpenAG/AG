Open Ag Classifier
==================

This docker depends on mysql:

    docker volume create --name agmysql
    docker run --name agmysql -e MYSQL_ROOT_PASSWORD=PASSWORD -v agmysql:/var/lib/mysql -d mysql

And then can be started with:

    docker run \
        -e MYSQL_ROOT_PASSWORD=${MYSQL_ROOT_PASSWORD} \
        -p 8013:8013 \
        --link openag_mysql \
        -v openag-claissifier-data:/opt/autocoder/src/model/clf_data \
        -ti d85af205f5c4
