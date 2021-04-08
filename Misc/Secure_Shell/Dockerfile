FROM ubuntu

RUN apt update && apt upgrade -y
RUN apt install python3 socat vim -y
RUN groupadd user

RUN mkdir /chall
COPY ./chall.py /chall
COPY ./entry.sh /chall
COPY ./my_v3ry_s3cr3t_f1l3.txt /

RUN useradd -G user --home=/chall challenger

RUN chown challenger:challenger /chall/chall.py

RUN chmod 4755 /chall/entry.sh
RUN chmod 4755 /chall/chall.py

EXPOSE 9001
ENTRYPOINT ["/chall/entry.sh"]
