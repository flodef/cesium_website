# Crowdfundinğ

PHP scripts and iframes to display crowdfunding informations in a fully customizable way.

## A word about \<iframe\> and height

For autoheight.js script to work, iframes.php file must be stored on the same domain as the HTML that calls the iframe.

## QR codes

img/qrcodes must be set with write permissions :

```
chmod +w o img/qrcodes
```

## Generation of images

If you are using this script on your own server, you might want to install PHP-GD library :

```
sudo apt install php-gd
```

Restarting your server will be necessary. For Apache :
```
/etc/init.d/apache2 restart
```
