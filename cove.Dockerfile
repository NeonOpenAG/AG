FROM tobybatch/ag-base:default
MAINTAINER tobias@neontribe.co.uk

RUN git clone https://github.com/OpenDataServices/cove.git /opt/cove
RUN virtualenv $HOME/.ve --python=/usr/bin/python3
RUN /bin/bash -c "source $HOME/.ve/bin/activate"
RUN git -C /opt/cove checkout 602-convert-upload
RUN pip install --upgrade -r /opt/cove/requirements_dev.txt

COPY cove.startup.sh /usr/local/bin/startup.sh
COPY cove.ngnix.conf /etc/nginx/sites-available/default

EXPOSE 8008

ENTRYPOINT ["/usr/local/bin/startup.sh"]
# ENTRYPOINT ["/bin/bash"]

# vim: set filetype=dockerfile expandtab tabstop=2 shiftwidth=2 autoindent smartindent:
