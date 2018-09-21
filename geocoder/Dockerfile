FROM python:3.5 
MAINTAINER tobias@neontribe.co.uk

WORKDIR /opt/geocoder-ie
ARG REMOTE_PORT=http://0.0.0.0:5000

COPY process.sh /usr/local/bin/process.sh
RUN apt-get update \
  && apt-get upgrade -y \
  && curl -sL https://deb.nodesource.com/setup_10.x | bash - \
  && chmod 777 /usr/local/bin/process.sh \
  && apt-get -y install \
      git \
      htop \
      nginx \
      nodejs \
      python-dev \
      python3-lxml \
      vim \
      wget \
  && git clone https://github.com/devgateway/geocoder-ie.git /opt/geocoder-ie \
  && sed -i '/lxlm/d' requirements.txt \
  && pip install -r requirements.txt \
  && pip install lxml uwsgi \
  && python setup.py \
  && chmod 777 /opt/geocoder-ie/server.sh \
  && sed -i "8s#.*#window.API_ROOT = '${REMOTE_PORT}'#" /opt/geocoder-ie/ui/src/main.js \
  && sed -i "7s#.*#socket = '${REMOTE_PORT}'#" /opt/geocoder-ie/uwsgi.ini

WORKDIR /opt/geocoder-ie/ui
RUN npm install && npm run build

COPY geocoder.ini /opt/geocoder-ie
COPY geocoder.tpl /opt/geocoder-ie
COPY uwsgi.ini /opt/geocoder-ie/uwsgi.ini


# RUN apt install -y ssh
# ENTRYPOINT ["/usr/local/bin/process.sh"]

ENV country uk
ENV filename fo.pdf
ENV OPENAG_NERSERVER openag_nerserver
ENV OPENAG_PORT 9000
ENV TERM=xterm

ENTRYPOINT ["/usr/local/bin/uwsgi", "/opt/geocoder-ie/uwsgi.ini"]
# ENTRYPOINT /bin/bash

EXPOSE 5000

# vim: set filetype=dockerfile expandtab tabstop=2 shiftwidth=2 autoindent smartindent:
