FROM node:4.4.3
MAINTAINER tobias@neontribe.co.uk

WORKDIR /opt/

RUN ls
RUN apt-get update && apt-get upgrade -y
RUN apt-get -y install git vim htop nginx wget
RUN git clone https://github.com/devgateway/open-aid-geocoder.git

RUN wget https://github.com/devgateway/open-aid-geocoder/raw/windows-local/scripts/update.sh
RUN wget https://github.com/devgateway/open-aid-geocoder/raw/windows-local/scripts/install.sh
RUN bash update.sh
RUN bash install.sh
# RUN bash start.sh
RUN ls
# COPY open-aid-geocoder.settings.json /opt/open-aid-geocoder/app/conf/settings.json
COPY open-aid-geocoder.ngnix.conf /etc/nginx/sites-available/default
COPY open-aid-geocoder.startup.sh /usr/local/bin/startup.sh
RUN mkdir /opt/open-aid-geocoder/api/uploads
RUN rm /opt/open-aid-geocoder/api/data/project-data.json
RUN rm /opt/open-aid-geocoder/app/conf/settings.json

# VOLUME /opt/open-aid-geocoder/app/conf
# VOLUME /opt/open-aid-geocoder/api/data/
# VOLUME /opt/open-aid-geocoder/api/uploads/

EXPOSE 8009
EXPOSE 3333

ENTRYPOINT ["/usr/local/bin/startup.sh"]

# vim: set filetype=dockerfile expandtab tabstop=2 shiftwidth=2 autoindent smartindent:
