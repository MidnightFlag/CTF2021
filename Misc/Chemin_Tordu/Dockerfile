FROM ubuntu

RUN apt update && apt upgrade -y
RUN apt install python3 python3-pip socat -y
RUN pip3 install num2words
RUN groupadd user

RUN mkdir /chall
COPY ./chall.py /chall
COPY ./entry.sh /chall

RUN useradd -G user --home=/chall challenger

RUN chown challenger:challenger /chall/chall.py

RUN chmod 4755 /chall/entry.sh
RUN chmod 4755 /chall/chall.py

EXPOSE 9000
ENTRYPOINT ["/chall/entry.sh"]
