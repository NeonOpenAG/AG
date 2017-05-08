FROM node:5.4.3
MAINTAINER tobias@neontribe.co.uk

WORKDIR /opt/

RUN apt-get update && apt-get upgrade -y
RUN apt-get -y install git vim htop nginx wget
RUN git clone https://github.com/devinit/D-Portal

WORKDIR /opt/D-Portal/bin

RUN bash ./getapts && npm install


COPY dportal.ngnix.conf /etc/nginx/sites-available/default
COPY dportal.startup.sh /usr/local/bin/startup.sh

EXPOSE 8011

ENTRYPOINT ["/usr/local/bin/startup.sh"]
# ENTRYPOINT ["/bin/bash"]

# vim: set filetype=dockerfile expandtab tabstop=2 shiftwidth=2 autoindent smartindent:
