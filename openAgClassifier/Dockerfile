FROM tobybatch/openagclassifier:postbuild
MAINTAINER tobias@neontribe.co.uk

COPY startup.sh /usr/local/bin/startup.sh
RUN chmod 777 /usr/local/bin/startup.sh
COPY install.sql /var/tmp/install.sql
COPY fetch_corpora.py /var/tmp/fetch_corpora.py

# This is only needed for cli debug
RUN apt-get -y install mysql-client

# RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
