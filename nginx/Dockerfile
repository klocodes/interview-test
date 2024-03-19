FROM nginx:stable-alpine

ARG TZ='UTC'

ARG DOMAIN

# https://wiki.alpinelinux.org/wiki/Setting_the_timezone
RUN echo "${TZ}" && apk --update add tzdata && \
    cp /usr/share/zoneinfo/$TZ /etc/localtime && \
    echo $TZ > /etc/timezone && \
    apk del tzdata

RUN apk add --no-cache bash inotify-tools python3 py3-pip certbot

RUN pip3 install --upgrade pip && \
    pip3 install certbot-nginx

RUN mkdir -p /etc/nginx/ssl

#RUN certbot --nginx --email hello@hwschool.online --agree-tos --non-interactive --domains ${DOMAIN} --redirect