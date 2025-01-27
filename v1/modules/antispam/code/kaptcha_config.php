<?php

# KCAPTCHA configuration file

$alphabet = "0123456789abcdefghijklmnopqrstuvwxyz"; # do not change without changing font files!

# symbols used to draw CAPTCHA
$allowed_symbols = "0123456789"; #digits
//$allowed_symbols = "23456789abcdefghkmnpqrstuvxyz"; #alphabet without similar symbols (o=0, 1=l, i=j)

# folder with fonts
$fontsdir = 'fonts';

# CAPTCHA string length
//$length = mt_rand(4,5); # random 6 or 7
$length = 5;

# CAPTCHA image size (you do not need to change it, whis parameters is optimal)
$width = 160;
$height = 45;

# symbol's vertical fluctuation amplitude divided by 2
$fluctuation_amplitude = 3;

# increase safety by prevention of spaces between symbols
$no_spaces = false;

# show credits
$show_credits = false; # set to false to remove credits line. Credits adds 12 pixels to image height
$credits = ''; # if empty, HTTP_HOST will be shown

# CAPTCHA image colors (RGB, 0-255)
$foreground_color = array(100, 100, 100);
$background_color = array(255, 255, 255);
//$foreground_color = array(mt_rand(0,100), mt_rand(0,100), mt_rand(0,100));
//$background_color = array(mt_rand(200,255), mt_rand(200,255), mt_rand(200,255));

# JPEG quality of CAPTCHA image (bigger is better quality, but larger file size)
$jpeg_quality = 180;

# mysql configuration
/*$conf["db_host"]='localhost';
$conf["db_name"]='mywatch';
$conf["db_user"]='root';
$conf["db_password"]='123';
$conf["db_table"]='antispam';
*/
include_once("../../../config.php");
$conf["db_host"]=$mainConfig['db']['main']['host'];
$conf["db_name"]=$mainConfig['db']['main']['name'];
$conf["db_user"]=$mainConfig['db']['main']['user'];
$conf["db_password"]=$mainConfig['db']['main']['password'];
$conf["db_table"]='antispam';
?>
