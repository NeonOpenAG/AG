Open Ag Classifier
==================

This docker depends on mysql:

    source ~/.openagrc
    docker run --name agmysql -e SQL_ROOT_PASSWORD=PASSWORD -v agmysql:/var/lib/mysql -d mysql

And then can be started with:

    source ~/.openagrc
    docker run \
        -e SQL_ROOT_PASSWORD=${SQL_ROOT_PASSWORD} \
        -p 8013:8013 \
        -p 9091:9091 \
        --link openag_mysql \
        -v $PERSIST_CLASSIFIER:/opt/autocoder/src/model/clf_data \
        -ti openagdata/autogeocoder

```
db = {"SERVER": "open-ag-classifier-mysql.cpd6ve6te6op.us-west-2.rds.amazonaws.com",
      "UID": "classifier",
      "PWD": "${SQL_ROOT_PASSWORD}",
      "DATABASE": "agrovoc_autocode",
      "PORT": "3306"
      }
```
