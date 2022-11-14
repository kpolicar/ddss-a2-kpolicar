#
# Authors: Nuno Antunes <nmsa@dei.uc.pt>, João Antunes <jcfa@dei.uc.pt>
#

from php:8.1.11-apache


RUN apt-get update

# Install PDO and PGSQL Drivers
RUN apt-get install -y libpq-dev \
  && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
  && docker-php-ext-install pdo pdo_pgsql pgsql


