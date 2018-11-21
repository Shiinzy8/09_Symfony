sudo rm /var/www/symfony && \
sudo ln -s /var/www/symfony_current /var/www/symfony && \
cd /var/www/symfony && \
sudo APP_ENV=$APP_ENV DATABASE_URL=$DATABASE_URL php bin/console docktrine:migrations:migrate --no-interaction && \
sudo chown -R www-data:www-data /var/www/symfony && \
sudo chown -h www-dat:www-data /var/www/symfony_current && \
sudo service nginx restart