FROM nginx:1.23-alpine

# Add www-data
RUN set -x ; \
    addgroup -g 82 -S www-data ; \
    adduser -u 82 -D -S -G www-data www-data && exit 0 ; exit 1

COPY .deploy/production/proxy/default.conf /etc/nginx/conf.d/default.conf

CMD ["nginx", "-g", "daemon off;"]