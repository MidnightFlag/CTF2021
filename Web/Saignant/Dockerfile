FROM kacperzuk/heartbleed-testbed-nginx-bleed

RUN apt update && apt upgrade -y
RUN apt install curl
RUN rm /workdir/html/confidential.txt
COPY ./nginx.conf /usr/local/nginx/conf
COPY ./src/ /usr/local/nginx/
