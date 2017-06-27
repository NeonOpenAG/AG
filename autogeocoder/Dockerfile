FROM python:2
MAINTAINER tobias@neontribe.co.uk

WORKDIR /opt
RUN apt install git
RUN git clone https://github.com/tobybatch/autogeocoder.git

RUN sed -i 's/localhost/openag_nerserver/g' /opt/autogeocoder/src/extraction/locations_extractor.py
RUN sed -i 's/1235/9000/g' /opt/autogeocoder/src/extraction/locations_extractor.py

RUN pip install prettytable nltk sner PyPDF2
RUN python -m nltk.downloader punkt
RUN python -m nltk.downloader stopwords
RUN python -m nltk.downloader wordnet

WORKDIR /opt/autogeocoder/src

ENTRYPOINT ["/bin/bash"]
