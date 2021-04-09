FROM ubuntu:latest

RUN apt update -y && apt upgrade -y && apt install python3 python3-pip -y
RUN mkdir /opt/chall/
WORKDIR /opt/chall
COPY ./src/ .
COPY ./requirements.txt .
RUN pip3 install -r requirements.txt
RUN rm requirements.txt
COPY ./algorithms.py /usr/local/lib/python3.8/dist-packages/jwt/
ENTRYPOINT ["python3","/opt/chall/app.py"]
