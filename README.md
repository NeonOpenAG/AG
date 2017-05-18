# AG Dockers

## Installation

Install details as a stand alone application are [here](INSTALL.md).

You can build the dockers youreslf, or just pull them from docker hub.  You need to pass a set of ports and volumes, these are dtailed on the individual docker pages in this repo:

 * [CoVE Dockerfile](./cove) and resources.
 * [Open aid geocoder Dockerfile](./geocoder) and resources.
 * [OIPA Dockerfile](./oipa) and resources.
 * [D-Portal Dockerfile](./dportal) and resources.

## Building

Each docker is built from a base image in this repo.  These are hosted on docker hub:

 * [CoVE on dockerhub](https://hub.docker.com/r/tobybatch/ag-cove/).
 * [Open aid geocoder on dockerhub](https://hub.docker.com/r/tobybatch/ag-oageocoder/).
 * [OIPA on dockerhub](https://hub.docker.com/r/tobybatch/ag-oipa/).
 * [D-Portal on dockerhub](https://hub.docker.com/r/tobybatch/ag-dportal/).

--------------------

## TODO

 * Fix user creation in oipa application.
