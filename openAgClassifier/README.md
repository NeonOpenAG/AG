Open Ag Classifier
==================

This docker depends on mysql:

    source ~/.openagrc
    docker run --name agmysql -e MYSQL_ROOT_PASSWORD=PASSWORD -v agmysql:/var/lib/mysql -d mysql

And then can be started with:

    source ~/.openagrc
    docker run \
        -e MYSQL_ROOT_PASSWORD=${MYSQL_ROOT_PASSWORD} \
        -p 8013:8013 \
        -p 9091:9091 \
        --link openag_mysql \
        -v $PERSIST_CLASSIFIER:/opt/autocoder/src/model/clf_data \
        -ti openagdata/autogeocoder
