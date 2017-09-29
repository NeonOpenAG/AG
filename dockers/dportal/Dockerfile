# FROM ubuntu:trusty
FROM node:6.5
MAINTAINER tobias@neontribe.co.uk

WORKDIR /opt

RUN apt-get update
RUN apt-get install -y git
RUN git clone https://github.com/devinit/D-Portal
RUN /opt/D-Portal/install_deps
RUN sed -i "s/serv.js/serv.js --port 8011/g" /opt/D-Portal/dportal/serv

WORKDIR /opt/D-Portal
COPY dportal.startup.sh /usr/local/bin/dportal.startup.sh
RUN chmod 777 /usr/local/bin/dportal.startup.sh

EXPOSE 8011
# ENTRYPOINT ["./serv", "-q", "http://d-portal.org/"]
ENTRYPOINT ["/usr/local/bin/dportal.startup.sh"]
