FROM node:5.4.3
MAINTAINER tobias@neontribe.co.uk

WORKDIR /opt/

RUN apt-get update && apt-get upgrade -y
RUN apt-get -y install git vim htop nginx wget
RUN git clone https://github.com/devgateway/open-aid-geocoder.git

RUN wget https://github.com/devgateway/open-aid-geocoder/raw/windows-local/scripts/update.sh
RUN wget https://github.com/devgateway/open-aid-geocoder/raw/windows-local/scripts/install.sh
RUN bash update.sh
RUN bash install.sh
# RUN bash start.sh
COPY open-aid-geocoder.ngnix.conf /etc/nginx/sites-available/default
COPY open-aid-geocoder.startup.sh /usr/local/bin/startup.sh

EXPOSE 8009

ENTRYPOINT ["/usr/local/bin/startup.sh"]
# ENTRYPOINT ["/bin/bash"]

# vim: set filetype=dockerfile expandtab tabstop=2 shiftwidth=2 autoindent smartindent:
