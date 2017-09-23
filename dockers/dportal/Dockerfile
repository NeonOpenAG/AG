FROM ubuntu:xenial
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
    curl 
RUN git clone https://github.com/devinit/D-Portal

WORKDIR /opt/D-Portal

COPY nvmsetup.sh /tmp/nvmsetup.sh
RUN /tmp/nvmsetup.sh
RUN apt -y install npm

RUN /opt/D-Portal/bin/npm_install

RUN echo "#!/bin/bash\n\ngit pull origin $(git rev-parse --abbrev-ref HEAD)" > /usr/local/bin/update.sh
# # RUN ./bin/dstore init && ./bin/dstore_import_bd_ug_hn
RUN ./fetch
RUN ./install_deps
COPY process.sh /usr/local/bin/process.sh
RUN chmod 777 /usr/local/bin/process.sh
RUN ./bin/dstore init
RUN mkdir /opt/D-Portal/cache && chmod 777 /usr/local/bin/update.sh
RUN dportal/build

RUN ls
ADD dportal_serv dportal/serv
COPY dportal.startup.sh /usr/local/bin/startup.sh

EXPOSE 8011

ENTRYPOINT ["/usr/local/bin/startup.sh"]

# vim: set filetype=dockerfile expandtab tabstop=2 shiftwidth=2 autoindent smartindent:
