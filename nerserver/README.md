# Run it

    docker run -dt -p 9000:9000 --name openag_nerserver openagdata/nerserver

## Attach to it

    docker attach openag_nerserver

## Get a bash promt in it

    docker exec -ti openag_nerserver /bin/bash
