# AG Dockers

## Installation

Install details as a stand alone application are [here](INSTALL.md).

## Running

After installing just run the script:

    /usr/bin/openag start

and start a browser pointed at [http://localhost:7080](http://localhost:7080)

Running the script with a -h will give additional options:

```
$ openag -h

openag [-v] [-h] [status|start|stop|destroy|restart]

Start the Open Agricultural Data Dockers in daemon mode.

h   Print help
v   Verbose output, including instruction for stopping/connecting

ACTIONs

status
    Show the status of the Open Agricultural Data Dockers.
start
    Start the docker, eithe rrunning new ones or starting stopped ones.
stop
    Stop the dockers.
destroy
    Stop and destroy the dockers.  Usae this reset the dockers to initial
    state.  If you also "rm -rf /home/tobias/.openag/data you will remoce
    persisted data.
restart
    stop and start

```

## Building

You can build the dockers youreslf, or just pull them from docker hub.  You need to pass a set of ports and volumes, these are dtailed on the individual docker pages in this repo:

 * [CoVE Dockerfile](./cove) and resources.
 * [Open aid geocoder Dockerfile](./geocoder) and resources.
 * [OIPA Dockerfile](./oipa) and resources.
 * [D-Portal Dockerfile](./dportal) and resources.

## Accessing

Each docker exposes services on a port:

 * CoVE on [http://localhost:8008](http://localhost:8008)
 * Open aid geocoder on [http://localhost:8009](http://localhost:8009)
 * OIPA on [http://localhost:8010](http://localhost:8010)
 * D-Portal on [http://localhost:8011](http://localhost:8011)

## Images

Each docker is built from a base image in this repo.  These are hosted on docker hub:

 * [CoVE on dockerhub](https://hub.docker.com/r/tobybatch/ag-cove/).
 * [Open aid geocoder on dockerhub](https://hub.docker.com/r/tobybatch/ag-oageocoder/).
 * [OIPA on dockerhub](https://hub.docker.com/r/tobybatch/ag-oipa/).
 * [D-Portal on dockerhub](https://hub.docker.com/r/tobybatch/ag-dportal/).

--------------------

## TODO

 * Fix user creation in oipa application.
