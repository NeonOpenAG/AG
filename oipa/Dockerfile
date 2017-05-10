FROM ubuntu:xenial
MAINTAINER tobias@neontribe.co.uk

RUN apt-get update && apt-get upgrade -y
RUN apt-get -y install \
    sudo \
    git \
    python-virtualenv \
    python-dev \
    python-pip \
    libxml2-dev \
    libxslt1-dev \
    zlib1g-dev \
    vim \
    htop \
    nginx \
    gettext \
    sqlite3 \
    libsqlite3-dev \
    postgresql-9.5 \
    postgresql-client \
    postgresql-server-dev-9.5 \
    postgis \
    postgresql-9.5-postgis-2.1 \
    postgresql-9.5-postgis-scripts \
    python-psycopg2 \
    libpq-dev \
    binutils \
    libproj-dev \
    gdal-bin \
    libgeos-3.5.0 \
    libgeos-dev \
    redis-server \
    libsqlite3-mod-spatialite \
    catdoc \
    odt2txt \
    antiword \
    poppler-utils \
    unrtf \
    perl \
    libimage-exiftool-perl \
    html2text \
    binutils \
    unrar-free \
    gzip \
    bzip2 \
    unzip \
    docx2txt
RUN git clone https://github.com/zimmerman-zimmerman/OIPA.git /opt/oipa
RUN apt-get -y install virtualenv

WORKDIR /opt/oipa/OIPA

RUN /etc/init.d/postgresql start && \
  sudo -u postgres bash -c "psql -c \"CREATE USER oipa WITH PASSWORD 'oipa';\"" && \
  sudo -u postgres bash -c "psql -c \"ALTER ROLE oipa SUPERUSER;\"" && \
  sudo -u postgres bash -c "psql -c \"CREATE DATABASE oipa;\""
RUN virtualenv .env && .env/bin/pip install --upgrade pip && .env/bin/pip install -r /opt/oipa/OIPA/requirements.txt

RUN echo "source /opt/oipa/OIPA/.env/bin/activate" >> $HOME/.bashrc
COPY oipa.startup.sh /usr/local/bin/startup.sh

EXPOSE 8010

ENTRYPOINT ["/usr/local/bin/startup.sh"]
# ENTRYPOINT ["/bin/bash"]

# vim: set filetype=dockerfile expandtab tabstop=2 shiftwidth=2 autoindent smartindent:

