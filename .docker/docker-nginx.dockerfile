FROM nginx:latest

MAINTAINER Cameron Smith

EXPOSE 80 443

VOLUME /var/cache/nginx

COPY ./.docker/config/default.conf /etc/nginx/conf.d/default.conf

ENTRYPOINT ["nginx"]
CMD ["-g", "daemon off;"]