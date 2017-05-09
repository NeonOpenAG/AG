FROM ubuntu:trusty
MAINTAINER tobias@neontribe.co.uk

WORKDIR /opt/

RUN apt-get update && apt-get upgrade -y
RUN apt-get -y install git vim htop nginx wget sudo software-properties-common python-software-properties
RUN git clone https://github.com/devinit/D-Portal

WORKDIR /opt/D-Portal/bin

# These are explode out of D-Portal/bin/getapts, they don't habe a -y to automativally install dependencies.
RUN add-apt-repository ppa:chris-lea/node.js
RUN apt-get update
RUN apt-get -y install nodejs g++ build-essential

RUN npm install -g n
RUN n 0.10.24

WORKDIR /opt/D-Portal/dstore
RUN npm install

COPY dportal.ngnix.conf /etc/nginx/sites-available/default
COPY dportal.startup.sh /usr/local/bin/startup.sh

EXPOSE 8011

# ENTRYPOINT ["/usr/local/bin/startup.sh"]
ENTRYPOINT ["/bin/bash"]

# vim: set filetype=dockerfile expandtab tabstop=2 shiftwidth=2 autoindent smartindent:
