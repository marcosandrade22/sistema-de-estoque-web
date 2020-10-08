FROM php:apache-buster

# install mysqli
RUN docker-php-ext-configure mysqli \
	&& docker-php-ext-install mysqli \
	&& docker-php-ext-enable mysqli

# se der erro descomente as linhas abaixo e teste
# se nao solucionar o erro recomente as linhas abaixo
# RUN a2enmod rewrite
# RUN service apache2 restart
