# Open aid geocoder

    docker run -td --link openag_nerserver --name openag_geocoder openagdata/geocoder:latest

    cat ../../../repos/geocoder-ie/example.txt| docker exec -i -e FILENAME=/tmp/test.txt -e COUNTRY=GH openag_geocoder /usr/local/bin/process.sh

    cat ../../../repos/geocoder-ie/example.xml| docker exec -i -e FILENAME=/tmp/test.xml -e COUNTRY=GH openag_geocoder /usr/local/bin/process.sh
