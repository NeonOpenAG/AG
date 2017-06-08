MYSQL
=====

OpenAgClassifier added a need for a mysql image so we need to start one:

    docker volume create --name agmysql
    docker run --name agmysql -e MYSQL_ROOT_PASSWORD=somerootpassword -v agmysql:/var/lib/mysql -d mysql
