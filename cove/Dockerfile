# FROM python:3
FROM ubuntu:xenial
MAINTAINER tobias@neontribe.co.uk

ENV SECRET_KEY=somesecretkey
ENV DJANGO_SETTINGS_MODULE=cove_iati.settings
ENV LC_ALL="C.UTF-8"

RUN apt-get update \
   && apt-get upgrade -y \
   && apt-get -y install git vim htop gettext python3-pip mercurial \
   && git clone https://github.com/OpenDataServices/cove.git /opt/cove
WORKDIR /opt/cove
RUN git fetch
RUN pip3 install --upgrade pip
RUN pip3 install cython
RUN pip3 install -r requirements_iati.txt
RUN mkdir -p media
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
RUN python3 manage.py migrate
RUN python3 manage.py compilemessages

COPY process.sh /usr/local/bin/process.sh
RUN chmod 777 /usr/local/bin/process.sh

EXPOSE 8000

ENTRYPOINT ["python3", "manage.py", "runserver", "0.0.0.0:8000"]
# ENTRYPOINT ["/bin/bash"]

# echo "#!/bin/bash\n\nif [ ! -z \"\$PROCESS_DATA\" ]; then\n/usr/local/bin/process.sh\nexit \$?\nfi\n\n/usr/local/bin/update.sh\ncd /opt/cove\nexport DJANGO_SETTINGS_MODULE=$DJANGO_SETTINGS_MODULE\npython3 manage.py migrate\npython3 manage.py compilemessages\npython3 manage.py runserver 0.0.0.0:8000" > /usr/local/bin/startup.sh

# vim: set filetype=dockerfile expandtab tabstop=3 shiftwidth=2 autoindent smartindent:
