FROM ubuntu:zenial
MAINTAINER tobias@neontribe.co.uk

WORKDIR /opt

RUN apt-get update && apt-get upgrade -y && \
  apt-get -y install \
    git \
    vim \
    htop \
    wget \
    sudo \
    software-properties-common \
    python-software-properties \
    gcc-5 g++-5 build-essential \
    nodejs-legacy \
    nodejs \
    npm && \
    git clone https://github.com/devinit/D-Portal

WORKDIR /opt/D-Portal
RUN /opt/D-Portal/bin/npm_install

RUN echo "#!/bin/bash\n\ngit pull origin $(git rev-parse --abbrev-ref HEAD)" > /usr/local/bin/update.sh
# RUN ./bin/dstore init && ./bin/dstore_import_bd_ug_hn
RUN ./bin/dstore init
RUN mkdir /opt/D-Portal/cache && chmod 777 /usr/local/bin/update.sh

EXPOSE 8011
EXPOSE 1408

ENTRYPOINT ["./bin/serv", "-q", "http://d-portal.org/"]
# ENTRYPOINT ["/bin/bash"]

# vim: set filetype=dockerfile expandtab tabstop=2 shiftwidth=2 autoindent smartindent:
