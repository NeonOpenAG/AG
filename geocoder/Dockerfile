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

RUN echo "server {\n\
    listen 8009 default_server;\n\
    root /var/www/html;\n\
    server_name _;\n\
    location / {\n\
        proxy_pass http://127.0.0.1:3000;\n\
    }\n\
}\n" >> /etc/nginx/sites-available/default

RUN echo "#!/bin/bash\n\
\n\
/usr/local/bin/update.sh\n\
/etc/init.d/nginx restart\n\
cd /opt/open-aid-geocoder/scripts\n\
bash ./start.sh\n" >> /usr/local/bin/startup.sh && chmod 777 /usr/local/bin/startup.sh


RUN mkdir /opt/open-aid-geocoder/api/uploads
RUN rm /opt/open-aid-geocoder/api/data/project-data.json
RUN rm /opt/open-aid-geocoder/app/conf/settings.json

# VOLUME /opt/open-aid-geocoder/app/conf
# VOLUME /opt/open-aid-geocoder/api/data/
# VOLUME /opt/open-aid-geocoder/api/uploads/

COPY update.sh /usr/local/bin/update.sh
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

EXPOSE 8009
EXPOSE 3333
WORKDIR /opt/open-aid-geocoder

ENTRYPOINT ["/usr/local/bin/startup.sh"]

# vim: set filetype=dockerfile expandtab tabstop=2 shiftwidth=2 autoindent smartindent:
