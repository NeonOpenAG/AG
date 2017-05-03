

    docker build --force-rm -t "tobybatch/ag-base" -f base.Dockerfile .
    docker commit db484fca2cd1 tobybatch/ag-base
    docker tag tobybatch/ag-base tobybatch/ag-base:default




```
FROM ubuntu:xenial
MAINTAINER tobias@neontribe.co.uk

# WORKDIR /opt/cove
ENV DJANGO_SETTINGS_MODULE cove_iati.settings

RUN apt-get update && apt-get upgrade -y
RUN apt-get -y install git python3 virtualenv vim htop gettext nginx
RUN echo "DJANGO_SETTINGS_MODULE=cove_iati.settings" >> /etc/environment

# git clone https://github.com/OpenDataServices/cove.git
# cd cove
# virtualenv .ve --python=/usr/bin/python3
# source .ve/bin/activate

# git checkout 602-convert-upload
# pip install --upgrade -r requirements_dev.txt
#
# DJANGO_SETTINGS_MODULE=cove_iati.settings python manage.py migrate
# DJANGO_SETTINGS_MODULE=cove_iati.settings python manage.py compilemessages
# DJANGO_SETTINGS_MODULE=cove_iati.settings python manage.py runserver

ENTRYPOINT ["/bin/bash"]
# ENTRYPOINT ["python", "manage.py", "runserver"]

# vim: set filetype=dockerfile expandtab tabstop=2 shiftwidth=2 autoindent smartindent:
```
