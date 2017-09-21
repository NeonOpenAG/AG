FROM python:3.5
MAINTAINER tobias@neontribe.co.uk

WORKDIR /opt/

RUN apt-get update && apt-get upgrade -y
RUN apt-get -y install git vim htop nginx wget python-dev python3-lxml
RUN git clone https://github.com/devgateway/geocoder-ie.git

WORKDIR /opt/geocoder-ie
RUN sed -i '/lxlm/d' requirements.txt
RUN pip install -r requirements.txt
COPY geocoder.ini /opt/geocoder-ie
RUN python setup.py

RUN apt install -y ssh
# ENTRYPOINT ["/usr/local/bin/process.sh"]

ENV country uk
ENV filename fo.pdf

RUN pip install lxml
COPY process.sh /usr/local/bin/process.sh
RUN chmod 777 /usr/local/bin/process.sh

ENTRYPOINT ["top"]
# ENTRYPOINT ["python3", "src/server.py"]

# vim: set filetype=dockerfile expandtab tabstop=2 shiftwidth=2 autoindent smartindent:
