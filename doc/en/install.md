How to install Cesium website on your computer
===

## How to install the web server le serveur web

To run Cesium website on your computer, you will need install a web server, and PHP ; the later converts the source code contained in *.php files into HTML the browser can understand.

Linux users will need two packages: 
- apache2
- php

For instance, Debian-like (Ubuntu, Linux Mint, etc.) users will have to run:

```
sudo apt install apache2 php
```

Windows users can use [WAMP Serveur](https://www.wampserver.com/).

## .htaccess

Create a .htaccess in cesium_website directory, with the following text : 

```
<IfModule mod_rewrite.c>
RewriteEngine On

# Adaptez la ligne suivante à votre configuration (avec un slash à la fin)
RewriteBase /cesium-website-project/cesium_website/

RewriteOptions InheritDown

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule .*\.php - [L]

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^([^/]+)/(.*)$ index.php?lang=$1&page=/$2 [L]
</IfModule>

```

Edit RewriteBase directive to match your own setup.

If, when trying to access the site, you get a "404 Not Found" error, this means your `.htaccess` file is not taken into account by Apache.

You will then need to edit `/etc/apache2/apache2.conf` file and replace :

```
<Directory /var/www/>
        Options Indexes FollowSymLinks
        AllowOverride None
        Require all granted
</Directory>
```
with :
```
<Directory /var/www/>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
</Directory>
```

## config.php

In ̀`config.php`, edit $rootURL var according to your setup.


