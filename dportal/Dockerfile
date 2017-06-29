FROM ubuntu:xenial
MAINTAINER tobias@neontribe.co.uk

RUN apt-get update && apt-get upgrade -y && \
  apt-get -y install \
    git \
    vim \
    htop \
    nginx \
    wget \
    sudo \
    software-properties-common \
    python-software-properties \
    gcc-5 g++-5 build-essential \
    nodejs-legacy \
    nodejs \
    npm && \
  git clone https://github.com/devinit/D-Portal && \
  ./bin/npm_install

COPY dportal.ngnix.conf /etc/nginx/sites-available/default
COPY dportal.startup.sh /usr/local/bin/startup.sh
COPY update.sh /usr/local/bin/update.sh

WORKDIR /opt/D-Portal/dstore
RUN ./dstore init

WORKDIR /opt/D-Portal/bin
RUN mkdir /opt/D-Portal/cache && ./dstore_import_bd_ug_hn && chmod 777 /usr/local/bin/update.sh

EXPOSE 8011
EXPOSE 1408

ENTRYPOINT ["/usr/local/bin/startup.sh"]
# ENTRYPOINT ["/bin/bash"]

# vim: set filetype=dockerfile expandtab tabstop=2 shiftwidth=2 autoindent smartindent:
