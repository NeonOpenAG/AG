FROM python:3
MAINTAINER tobias@neontribe.co.uk

WORKDIR /opt/cove
ENV SECRET_KEY=somesecretkey

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get -y install git vim htop nginx gettext && \
    git clone https://github.com/OpenDataServices/cove.git /opt/cove && \
    git fetch && git -C /opt/cove checkout 722-upload-management && \
    pip3 install cython && \
    pip3 install -r requirements_iati.txt && \
    mkdir -p media && \
   echo "#!/bin/bash\n\
\n\
/usr/local/bin/update.sh\n\
/etc/init.d/nginx restart\n\
cd /opt/cove\n\
export DJANGO_SETTINGS_MODULE=cove_iati.settings\n\
python3 manage.py migrate\n\
python3 manage.py compilemessages\n\
python3 manage.py runserver\n" >> /usr/local/bin/startup.sh && chmod 777 /usr/local/bin/startup.sh && \
   echo "server {\n\
    listen 8008 default_server;\n\
    client_max_body_size 20M;\n\
    root /var/www/html;\n\
    server_name _;\n\
    location / {\n\
        proxy_pass http://127.0.0.1:8000;\n\
    }\n\
}\n" >> /etc/nginx/sites-available/default

COPY update.sh /usr/local/bin/update.sh

RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

EXPOSE 8008
EXPOSE 8000

ENV DJANGO_SETTINGS_MODULE=cove_iati.settings
ENV SECRET_KEY=somesecretkey

ENTRYPOINT ["/usr/local/bin/startup.sh"]
# ENTRYPOINT ["/bin/bash"]

# vim: set filetype=dockerfile expandtab tabstop=2 shiftwidth=2 autoindent smartindent:
