# AG Dockers

[![Build Status](https://travis-ci.org/neontribe/AG.svg?branch=master)](https://travis-ci.org/neontribe/AG)

## Installation

[Install instruction](INSTALL.md)

### Docker files (in this repo)

## Running

After installing just run the script:

    /usr/bin/openag start

Running the script with a -h will give additional options.  See [here](OPENAG.md) for more detailed usage.

## Building

You can build the dockers youreslf, or just pull them from docker hub.  You need to pass a set of ports and volumes, these are dtailed on the individual docker pages in this repo:

 * [CoVE Dockerfile](./dockers/cove) and resources.
 * [Open aid geocoder Dockerfile](./dockers/geocoder) and resources.
 * [D-Portal Dockerfile](./dockers/dportal) and resources.

## Accessing

Each docker exposes services on a port:

 * CoVE on [http://localhost:8000](http://localhost:8000)
 * Open aid geocoder on [http://localhost:8009](http://localhost:8009)
 * D-Portal on [http://localhost:8011](http://localhost:8011)

## Images

Each docker is built from a base image in this repo.  These are hosted on docker hub:

 * [CoVE on dockerhub](https://hub.docker.com/r/openagdata/ag-cove/).
 * [Open aid geocoder on dockerhub](https://hub.docker.com/r/openagdata/ag-oageocoder/).
 * [D-Portal on dockerhub](https://hub.docker.com/r/openagdata/ag-dportal/).

--------------------

## TODO

 * Fix user creation in oipa application.
