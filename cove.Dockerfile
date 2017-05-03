FROM python:3
MAINTAINER tobias@neontribe.co.uk

WORKDIR /opt/cove

RUN apt-get update && apt-get upgrade -y
RUN apt-get -y install git vim htop nginx gettext
RUN echo "DJANGO_SETTINGS_MODULE=cove_iati.settings" >> /etc/environment
RUN git clone https://github.com/OpenDataServices/cove.git /opt/cove
RUN git -C /opt/cove checkout 602-convert-upload
RUN pip3 install --upgrade -r requirements_dev.txt

COPY cove.startup.sh /usr/local/bin/startup.sh
COPY cove.ngnix.conf /etc/nginx/sites-available/default

EXPOSE 8008

ENTRYPOINT ["/usr/local/bin/startup.sh"]
# ENTRYPOINT ["/bin/bash"]

# vim: set filetype=dockerfile expandtab tabstop=2 shiftwidth=2 autoindent smartindent:
