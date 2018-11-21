# Remove symlink
sudo rm -R /var/www/symfony_old && \
sudo cp -R /var/www/symfony_current /var/www/symfony_old/ && \
sudo rm /var/www/symfony && \
sudo rm -R /var/www/symfony_current && \
# Create symlink to older version && \
sudo ln -s /var/www/symfony_old /var/www/symfony