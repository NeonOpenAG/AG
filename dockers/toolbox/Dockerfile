FROM ubuntu:16.04

MAINTAINER Toby Batch <tobias@neontribe.co.uk>

ENV VERSION=0.1.39

RUN apt update
RUN apt install -y \
	apt-transport-https \
        ca-certificates \
        ccze \
        composer \
        curl \
        php-zip \
        php-xml \
        php-curl \
        ruby-compass \
        software-properties-common \
	vim \
        wget

RUN curl -fsSL https://download.docker.com/linux/ubuntu/gpg | apt-key add 
RUN add-apt-repository \
   "deb [arch=amd64] https://download.docker.com/linux/ubuntu \
   $(lsb_release -cs) \
   stable"
RUN apt update
RUN apt install -y docker-ce

WORKDIR /opt
RUN wget https://github.com/NeonOpenAG/oagtoolbox/archive/v${VERSION}.tar.gz
RUN tar zxvf v${VERSION}.tar.gz
RUN apt install php7.0-sqlite3
RUN ln -s /usr/bin/sass /usr/local/bin/sass

WORKDIR /opt/oagtoolbox-${VERSION}
RUN composer install
RUN composer update

RUN sed -i 's/4096/40960/g' src/OagBundle/Service/Docker.php

# ENTRYPOINT ["/bin/bash"]
ENTRYPOINT ["./bin/console", "server:run", "0.0.0.0:8000"]
