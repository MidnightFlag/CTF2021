FROM ubuntu:latest

RUN apt update -y && apt upgrade -y && apt install python3 python3-pip -y
RUN mkdir /opt/chall/
WORKDIR /opt/chall
COPY ./src/* .
COPY ./requirements.txt .
COPY ./pyjwt/ .
RUN pip3 install -r requirements.txt
RUN pip3 install ./pyjwt
RUN rm -rf pyjwt
RUN rm requirements.txt