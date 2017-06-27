# AG Dockers

## Installation

[INSTALL.md](Install instruction)

### Docker files (in this repo)

## Running

After installing just run the script:

    /usr/bin/openag start

Running the script with a -h will give additional options.  Start, stop, destroy and status are supported.

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
