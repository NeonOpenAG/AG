FROM python:3
MAINTAINER tobias@neontribe.co.uk

WORKDIR /opt/cove

RUN apt-get update && apt-get upgrade -y
RUN apt-get -y install git vim htop nginx gettext
RUN echo "DJANGO_SETTINGS_MODULE=cove_iati.settings" >> /etc/environment
RUN git clone https://github.com/OpenDataServices/cove.git /opt/cove
RUN git -C /opt/cove checkout 635-sort-xml
RUN pip3 install cython
RUN pip3 install -r requirements_iati.txt
RUN git clone https://github.com/IATI/IATI-Schemas.git
RUN mkdir -p media

RUN echo "#!/bin/bash\n\
\n\
/etc/init.d/nginx restart\n\
cd /opt/cove\n\
export DJANGO_SETTINGS_MODULE=cove_iati.settings\n\
python3 manage.py migrate\n\
python3 manage.py compilemessages\n\
python3 manage.py runserver\n" >> /usr/local/bin/startup.sh && chmod 777 /usr/local/bin/startup.sh
RUN echo "server {\n\
    listen 8008 default_server;\n\
    root /var/www/html;\n\
    server_name _;\n\
    location / {\n\
        proxy_pass http://127.0.0.1:8000;\n\
    }\n\
}\n" >> /etc/nginx/sites-available/default

COPY update.sh /usr/local/bin/update.sh

RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

EXPOSE 8008

ENTRYPOINT ["/usr/local/bin/startup.sh"]
# ENTRYPOINT ["/bin/bash"]

# vim: set filetype=dockerfile expandtab tabstop=2 shiftwidth=2 autoindent smartindent:
