# CoVE

This docker image builds off the base python 3 image and runs CoVE in the native python.  It is fronted with a ngix proxy.  The CoVE git hub repo is pulled into /opt/cove and branch 602-convert-upload is checkedout.  The docker entry point is a shell script in /usr/local/bin called startup.sh.  It startes ngix, sets the DJANGO_SETTINGS_MODULE variable, runs migrate, compile messages and runs the server.  The server is exposed on http://127.0.0.1/8008 on the host machine.

    docker run -ti -p 8008:8008 -v $(pwd)/media:/opt/cove/media openagdata/cove

To upload a file use (/opt/cove/upload/ is mointed from $HOME/.openag/data/cove/upload):

    docker exec -ti openag_cove python manage.py upload /opt/cove/upload/before_enrichment_activities.xml


CoVE now avilable at http://localhost:8008/

Dockerhub [here](https://hub.docker.com/r/tobybatch/ag-cove/).

