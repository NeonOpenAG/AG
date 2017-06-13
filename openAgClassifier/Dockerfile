FROM python:3
MAINTAINER tobias@neontribe.co.uk

WORKDIR /opt/autocoder

RUN apt-get update && apt-get upgrade -y
RUN apt-get -y install git vim htop nginx gettext build-essential python-pip qt5-default libqt5webkit5-dev build-essential python-lxml python-pip xvfb unzip wget

RUN wget -O /tmp/Anaconda3-4.3.0-Linux-x86_64.sh http://repo.continuum.io/archive/Anaconda3-4.3.0-Linux-x86_64.sh
RUN bash /tmp/Anaconda3-4.3.0-Linux-x86_64.sh -b
ENV PATH /root/anaconda3/bin:$PATH

RUN conda install -c anaconda qt=4.8.6 -y
ENV QMAKESPEC /root/anaconda3/mkspecs/linux-g++

RUN git clone https://github.com/fcappdev/OpenAgClassifier.git /opt/autocoder
RUN pip install -U numpy scipy scikit-learn
RUN pip install -r /opt/autocoder/requirements.txt
RUN /root/anaconda3/bin/python -m nltk.downloader punkt
RUN /root/anaconda3/bin/python -m nltk.downloader stopwords
RUN /root/anaconda3/bin/python -m nltk.downloader wordnet

RUN echo "server {\n\
    listen 8012 default_server;\n\
    root /var/www/html;\n\
    server_name _;\n\
    location / {\n\
        proxy_pass http://127.0.0.1:80;\n\
    }\n\
}\n" >> /etc/nginx/sites-available/default

# This is only needed for cli debug"
RUN apt-get -y install mysql-client

EXPOSE 8012
VOLUME agmysql

COPY install.sql /var/tmp/install.sql
COPY clean.sql /var/tmp/clean.sql
COPY update.sh /usr/local/bin/update.sh

# RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN echo "mysql -u root -p${MYSQL_ROOT_PASSWORD} -h agmysql < /var/tmp/clean.sql" >> .bash_history
RUN echo "startup.sh" >> .bash_history
RUN echo "export PS1='\[\033[01;32m\]\u\[\033[00m\]@\[\033[01;34m\]\h\[\033[00m\] \[\033[01;36m\]\W\[\033[00m\] $ '" >> /root/.bashrc

COPY startup.sh /usr/local/bin/startup.sh
RUN chmod 777 /usr/local/bin/startup.sh

# ENTRYPOINT ["/usr/local/bin/startup.sh"]
ENTRYPOINT ["/bin/bash"]

# vim: set filetype=dockerfile expandtab tabstop=2 shiftwidth=2 autoindent smartindent:
