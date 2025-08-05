In case you get the error "Class "IntlDateFormatter" not found. . ." follow these steps:

1) End the XAMP services and close XAMPP.

2) Go to the XAMPP installation folder.

3) php folder.

4) Open the php.ini file.

5) Find the line with ";extension=intl" and turn it into "extension=intl" (without the quotes, of course).

6) Save the changes and start XAMP and its services again.

7) Update the CMS page and the error should dissapear.
