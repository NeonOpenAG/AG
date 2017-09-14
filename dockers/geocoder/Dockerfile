FROM python:3.5
MAINTAINER tobias@neontribe.co.uk

WORKDIR /opt/

RUN apt-get update && apt-get upgrade -y
RUN apt-get -y install git vim htop nginx wget python-dev python3-lxml
RUN git clone https://github.com/devgateway/geocoder-ie.git

COPY process.sh /usr/local/bin/process.sh

WORKDIR /opt/geocoder-ie
RUN sed -i '/lxlm/d' requirements.txt
RUN pip install -r requirements.txt
COPY geocoder.ini /opt/geocoder-ie
RUN python setup.py

ENTRYPOINT ["/bin/bash"]

# vim: set filetype=dockerfile expandtab tabstop=2 shiftwidth=2 autoindent smartindent:
