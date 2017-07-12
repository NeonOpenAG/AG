# CoVE

This docker image builds off the base python 3 image and runs CoVE in the native python.  It takes a file in on the standard in and returns a parsed document on the standard out and validation errors on the standard error.

    cat sample-data/activity-standard-example-annotated.xml | docker run -i openagdata/cove

Dockerhub [here](https://hub.docker.com/r/openagdata/cove/).

