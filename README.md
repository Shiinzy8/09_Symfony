# 09_Symfony playground: php-fpm 7.2, ngnix, postgres 9.6, rabbitmq 3.7.5

Preparations
 	1. git clone project
	2. copy ot the root path docker folder from googleDrive
 	3. cope 2 files ot the root directory from googleDrive: .env, .end.dist
	Structure
		09_Symfony
		|-bin ... and all other symfony folders
		|-docker
		|-vendor (no vendor run: composer install)
		|.env
		|.env.dist

How to run everything
 	1. add line to the etc/hosts (C:\Windows\system32\drivers\etc\hosts) file: 
  127.0.0.1	symfony.local
	2. on windows change 09_Symfony/docker/php7-fpm/Dockerfile:
 		2.1. in powerShell run command: ipconfig
 		2.2. find DockerNAT IPv4 address
 		2.3. add line to the Dockerfile:
  RUN echo "xdebug.remote_host={{DockerNAT IPv4 address}}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
 		2.4. and switch in this file xdebug.remote_connect_back to 0
 	3. cd docker and run command: docker-compose up -d
 	4. cd to root folder and run command: php bin/console cache:clear

Now you may enter symfony.local in your browser
