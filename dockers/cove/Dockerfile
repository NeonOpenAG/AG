FROM python:3
MAINTAINER tobias@neontribe.co.uk

WORKDIR /opt/cove
ENV SECRET_KEY=somesecretkey
ENV DJANGO_SETTINGS_MODULE=cove_iati.settings

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get -y install git vim htop gettext && \
    git clone https://github.com/OpenDataServices/cove.git /opt/cove && \
    git fetch && \
    pip3 install cython && \
    pip3 install -r requirements_iati.txt && \
    python manage.py migrate && \
    python manage.py compilemessages && \
    mkdir -p media
RUN echo "#!/bin/bash\n\nif [ ! -z \"\$PROCESS_DATA\" ]; then\n/usr/local/bin/process.sh\nexit \$?\nfi\n\n/usr/local/bin/update.sh\ncd /opt/cove\nexport DJANGO_SETTINGS_MODULE=$DJANGO_SETTINGS_MODULE\npython3 manage.py migrate\npython3 manage.py compilemessages\npython3 manage.py runserver 0.0.0.0:8000" > /usr/local/bin/startup.sh
RUN echo "#!/bin/bash\n\ngit pull origin \$(git rev-parse --abbrev-ref HEAD)\n" > /usr/local/bin/update.sh
RUN echo "#!/bin/bash\n\necho \"\$(</dev/stdin)\" > /tmp/file\nFILEPATH=\$(python manage.py upload /tmp/file)\nBASENAME=\$(/usr/bin/basename \$FILEPATH)\nXML=/opt/cove/media/\${BASENAME}/file\nERR=/opt/cove/media/\${BASENAME}/*.json\nif [ -e \"\$XML\" ]; then\n/bin/cat \$XML\nfi\nif [ -e \"$ERR\" ]; then\n(>&2 /bin/cat $ERR)\nfi\n" > /usr/local/bin/process.sh
RUN chmod 777 /usr/local/bin/startup.sh /usr/local/bin/update.sh /usr/local/bin/process.sh
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
COPY basic_iati_unordered_valid.csv /var/tmp

EXPOSE 8000

ENTRYPOINT ["/usr/local/bin/startup.sh"]
# ENTRYPOINT ["/bin/bash"]

# vim: set filetype=dockerfile expandtab tabstop=3 shiftwidth=2 autoindent smartindent:
