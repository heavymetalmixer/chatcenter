In case you get the error "Class "IntlDateFormatter" not found when using XAMPP (I recommend Laragon 6 instead). . ." follow these steps:

1) End the XAMP services and close XAMPP.

2) Go to the XAMPP installation folder.

3) php folder.

4) Open the php.ini file.

5) Find the line with ";extension=intl" and turn it into "extension=intl" (without the quotes, of course).

6) Save the changes and start XAMP and its services again.

7) Update the CMS page and the error should dissapear.




To make HTTPS possible:

1) Go to https://curl.se/docs/caextract.html and dowload the "cacert.pem" file at the top of the website.

2) Generally speaking you must paste this file in xx/php/extras/ssl/, but specifically for Laragon you must also do paste it inside xx/laragon/etc/ssl/.

3) In the php.ini file (inside xx/php/) enable the "curl.cainfo" line and make sure the path points to the cacert.pem file.

4) Make sure that "extension=curl" and "extension=openssl" are enabled.

5) Save the php.ini file.
