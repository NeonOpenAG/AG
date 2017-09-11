FROM ubuntu:15.04

MAINTAINER Toby Batch <tobias@neontribe.co.uk>

RUN apt-get update && apt-get -y install \
        openjdk-8-jdk \
        openjdk-8-jre \
        unzip \
        wget

WORKDIR /home
RUN wget -O ner.zip https://nlp.stanford.edu/software/stanford-ner-2016-10-31.zip
RUN unzip ner.zip

ENV port=9000 classifierPath=classifiers/english.muc.7class.distsim.crf.ser.gz outputFormat=inlineXML

EXPOSE $port

WORKDIR /home/stanford-ner-2016-10-31
CMD java -mx1000m -cp stanford-ner.jar edu.stanford.nlp.ie.NERServer \
            -loadClassifier $classifierPath \
            -port $port -outputFormat $outputFormat
# ENTRYPOINT ["/bin/bash"]