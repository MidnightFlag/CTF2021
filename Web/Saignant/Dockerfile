FROM kacperzuk/heartbleed-testbed-nginx-bleed

RUN rm /workdir/html/confidential.txt
COPY ./nginx.conf /usr/local/nginx/conf
COPY ./src/ /workdir/html/
