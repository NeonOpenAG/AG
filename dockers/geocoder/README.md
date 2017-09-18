# Open aid geocoder

    cat ../../../repos/geocoder-ie/example.txt | docker \
        run -i \
        -e country=GH \
        --link openag_nerserver \
        --entrypoint /usr/local/bin/process.sh \
        openagdata/geocoder
