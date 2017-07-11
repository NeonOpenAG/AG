FROM python:2
MAINTAINER tobias@neontribe.co.uk

WORKDIR /opt
RUN apt install git
RUN git clone https://github.com/devgateway/geocoder-ie.git

RUN pip install prettytable nltk sner PyPDF2
RUN python -m nltk.downloader punkt
RUN python -m nltk.downloader stopwords
RUN python -m nltk.downloader wordnet

RUN sed -i 's/localhost/openag_nerserver/g' /opt/geocoder-ie/src/extraction/locations_extractor.py
RUN sed -i 's/1234/9000/g' /opt/geocoder-ie/src/extraction/locations_extractor.py

RUN apt update
RUN apt install -y vim htop less git telnet

RUN pip install ner
WORKDIR /opt/geocoder-ie/src

RUN echo "python geocode.py 46002-P-GN-DB0-005" >> /root/.bash_history
ENTRYPOINT ["/bin/bash"]
