FROM kacperzuk/heartbleed-testbed-nginx-bleed

RUN rm /workdir/html/confidential.txt

COPY ./src/ /workdir/html/

ENTRYPOINT ['/bin/sh -c echo "Nginx started" && /usr/local/nginx/sbin/nginx']
