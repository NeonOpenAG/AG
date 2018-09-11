# D-Portal

This docker is built from the base ubuntu xenial image (16.04) and then node is installed.  It is fronted with a ngix proxy.  The D-Portal git hub repo is pulled into /opt/D-Portal.  The dportal install scrtipts are then run, (```bin/npm_install, ./dstore init```), and then the data is imported (```./dstore_import_bd_ug_hn```). It starts the nginx server and then the node server.

    docker run -ti -p 1408:1408 -p 8011:8011 openagdata/dportal

D-Portal now avilable at http://localhost:8011/

Dockerhub [here](https://hub.docker.com/r/openagdata/dportal/).

## Import data at run time

Put the XML to be imported in a folder and mount that on /data.   Then tell the container the name of the file, it defauilts to iati.xml

    docker run -ti -v $(pwd)/data:/data -e IATI_XML=data.xml -p 9011:8011 openagdata/dportal
