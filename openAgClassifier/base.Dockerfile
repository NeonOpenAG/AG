FROM python:3
MAINTAINER tobias@neontribe.co.uk

WORKDIR /opt/autocoder

RUN apt-get update && apt-get upgrade -y
RUN apt-get -y install git vim htop nginx gettext build-essential python-pip qt5-default libqt5webkit5-dev build-essential python-lxml python-pip xvfb

RUN wget -O /tmp/Anaconda3-4.3.0-Linux-x86_64.sh http://repo.continuum.io/archive/Anaconda3-4.3.0-Linux-x86_64.sh
RUN bash /tmp/Anaconda3-4.3.0-Linux-x86_64.sh -b

RUN /root/anaconda3/bin/conda install -c anaconda qt=4.8.6 -y
RUN echo "export PATH=/root/anaconda3/bin:$PATH\n" >> /etc/profile.d/anaconda3.sh && chmod 777 /etc/profile.d/anaconda3.sh
RUN echo "\nexport PATH=/root/anaconda3/bin:$PATH\n" >> /etc/profile

RUN git clone https://github.com/fcappdev/OpenAgClassifier.git /opt/autocoder
RUN pip3 install -U numpy scipy scikit-learn
RUN pip3 install -r /opt/autocoder/requirements.txt

RUN echo "server {\n\
    listen 8012 default_server;\n\
    root /var/www/html;\n\
    server_name _;\n\
    location / {\n\
        proxy_pass http://127.0.0.1:80;\n\
    }\n\
}\n" >> /etc/nginx/sites-available/default

EXPOSE 8012
VOLUME agmysql

# ENTRYPOINT ["/usr/local/bin/startup.sh"]
ENTRYPOINT ["/bin/bash"]

# vim: set filetype=dockerfile expandtab tabstop=2 shiftwidth=2 autoindent smartindent:
