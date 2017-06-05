FROM python:3
MAINTAINER tobias@neontribe.co.uk

WORKDIR /opt/autocoder

RUN apt-get update && apt-get upgrade -y
RUN apt-get -y install git vim htop nginx gettext build-essential pip3

RUN wget -O /tmp/Anaconda3-4.3.0-Linux-x86_64.sh http://repo.continuum.io/archive/Anaconda3-4.3.0-Linux-x86_64.sh
RUN /tmp/Anaconda3-4.3.0-Linux-x86_64.sh -b

RUN conda install -c anaconda qt=4.8.6 -y

RUN git clone https://github.com/fcappdev/OpenAgClassifier.git /opt/autocoder
RUN pip3 install -r requirements.txt

RUN echo "#!/bin/bash\n\
\n\
/etc/init.d/nginx restart\n\
cd /opt/cove\n\
export PATH=/home/ubuntu/anaconda3/bin:$PATH\n
python3 manage.py runserver\n" >> /usr/local/bin/startup.sh && chmod 777 /usr/local/bin/startup.sh
RUN echo "server {\n\
    listen 8012 default_server;\n\
    root /var/www/html;\n\
    server_name _;\n\
    location / {\n\
        proxy_pass http://127.0.0.1:80;\n\
    }\n\
}\n" >> /etc/nginx/sites-available/default

RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

EXPOSE 8008

ENTRYPOINT ["/usr/local/bin/startup.sh"]
# ENTRYPOINT ["/bin/bash"]

# vim: set filetype=dockerfile expandtab tabstop=2 shiftwidth=2 autoindent smartindent:
