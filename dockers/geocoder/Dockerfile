FROM python:3.5
MAINTAINER tobias@neontribe.co.uk

WORKDIR /opt/

RUN apt-get update && apt-get upgrade -y
RUN apt-get -y install git vim htop nginx wget python-dev
RUN git clone https://github.com/devgateway/geocoder-ie.git

# RUN wget https://repo.continuum.io/archive/Anaconda3-4.2.0-Linux-x86_64.sh
# RUN bash Anaconda3-4.2.0-Linux-x86_64.sh -b -p /opt/anaconda
# RUN rm Anaconda3-4.2.0-Linux-x86_64.sh
# ENV PATH=/opt/anaconda/bin:$PATH
# RUN conda update conda

COPY process.sh /usr/local/bin/process.sh

WORKDIR /opt/geocoder-ie
RUN cat /etc/issue
RUN echo python --version

# RUN conda config --add channels conda-forge
# RUN conda config --add channels pypi
# RUN conda config --add channels brittainhard
# RUN conda config --add channels contango
# RUN sed -i '/pycorenlp/d' requirements.txt
# RUN sed -i '/lxlm/d' requirements.txt
# RUN sed -i '/flask_cors/d' requirements.txt
# RUN sed -i '/sner/d' requirements.txt
# RUN conda install --yes --file requirements.txt
RUN pip install -r requirements.txt

ENTRYPOINT ["/bin/bash"]

# vim: set filetype=dockerfile expandtab tabstop=2 shiftwidth=2 autoindent smartindent:
