FROM sail-8.2/app:latest
LABEL authors="xiehq"

COPY xdebug.ini /etc/php/8.2/cli/conf.d/20-xdebug.ini
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN apt update && \
    apt install -y net-tools iputils-ping telnet

RUN apt remove -y nodejs && ln -s /usr/local/node-v18.17.0-linux-x64/bin/node /usr/bin/node
