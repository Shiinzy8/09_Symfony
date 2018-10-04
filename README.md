# 09_Symfony playground: php-fpm 7.2, ngnix, postgres 9.6, rabbitmq 3.7.5

Preparations <br />
  1. git clone project
  2. copy ot the root path docker folder from googleDrive
  3. cope 2 files ot the root directory from googleDrive: .env, .end.dist
    <br />Structure
    <br />09_Symfony
    <br />  |-bin ... and all other symfony folders
    <br />  |-docker
    <br />  |-vendor (no vendor run: composer install)
    <br />  |.env
    <br />  |.env.dist
      
How to run everything <br />
  1. add line to the etc/hosts (C:\Windows\system32\drivers\etc\hosts) file: 
  <br />  127.0.0.1	symfony.local
  2. on windows change 09_Symfony/docker/php7-fpm/Dockerfile:
  <br />  2.1. in powerShell run command: ipconfig
  <br />  2.2. find DockerNAT IPv4 address
  <br />  2.3. add line to the Dockerfile:
  <br />  RUN echo "xdebug.remote_host={{DockerNAT IPv4 address}}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
  <br />  2.4. and switch in this file xdebug.remote_connect_back to 0
  3. cd docker and run command: docker-compose up -d
  4. cd to root folder and run command: php bin/console cache:clear

Now you may enter symfony.local in your browser <br />
