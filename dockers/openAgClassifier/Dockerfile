FROM python:3
MAINTAINER tobias@neontribe.co.uk

WORKDIR /opt/autocoder
ENV PATH /root/anaconda3/bin:$PATH
ENV QMAKESPEC /root/anaconda3/mkspecs/linux-g++

RUN apt-get update && apt-get upgrade -y && apt-get -y install git vim htop nginx gettext build-essential python-pip qt5-default libqt5webkit5-dev build-essential python-lxml python-pip xvfb unzip wget && wget -O /tmp/Anaconda3-4.3.0-Linux-x86_64.sh http://repo.continuum.io/archive/Anaconda3-4.3.0-Linux-x86_64.sh && bash /tmp/Anaconda3-4.3.0-Linux-x86_64.sh -b && conda install -c anaconda qt=4.8.6 -y && git clone https://github.com/fcappdev/OpenAgClassifier.git /opt/autocoder && pip install -U numpy scipy scikit-learn && pip install -r /opt/autocoder/requirements.txt && /root/anaconda3/bin/python -m nltk.downloader punkt && /root/anaconda3/bin/python -m nltk.downloader stopwords && /root/anaconda3/bin/python -m nltk.downloader wordnet && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && echo "server {\n\
    listen 8012 default_server;\n\
    root /var/www/html;\n\
    server_name _;\n\
    location / {\n\
        proxy_pass http://127.0.0.1:80;\n\
    }\n\
}\n" >> /etc/nginx/sites-available/default

EXPOSE 8012

COPY install.sql /var/tmp/install.sql
COPY update.sh /usr/local/bin/update.sh
COPY startup.sh /usr/local/bin/startup.sh

WORKDIR /opt/autocoder/src

ENTRYPOINT ["/usr/local/bin/startup.sh"]
# ENTRYPOINT ["/bin/bash"]

# vim: set filetype=dockerfile expandtab tabstop=2 shiftwidth=2 autoindent smartindent:
