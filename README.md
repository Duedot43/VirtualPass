<img src="https://raw.githubusercontent.com/Duedot43/VirtualPass/9964b06f96132ceec968d2db11fc68c2f3a31fe8/src/Images/preview.png" width="100" height=auto onclick='location="https://virtualpass.net"'></img><br>
**Welcome to VirtualPass, a simple yet effective Virtual Hall Pass manager**<br>
***
## What is VirtualPass?
VirtualPass is a simple website for checking in or out students from a classroom with a scan and go system based off of QR codes.<br><br>
VirtualPass is very easy to set up and requires no third party dependencies, it supplies easy to visualize graphs and system configuration right from the web page.<br><br>
User data is stored outside the readable web scope so only the API with an API key can access this data.<br><br>
***
## Installation
* Download the latest release.<br>

* Unzip the file and move it to `/var/www`. This is assuming you are using an Apache server.<br>
* Install `php composer npm php-apache`<br>
* Install the composer dependinces by running `composer install`<br>
* Configure your server to run PHP code and tell it the website DIR is at `/var/www/VirtualPass/src/`.
***
## Setup
* go into your config file located at `/var/www/VirtualPass/config/config.ini`.
* Specify settings you want. Descriptions of the settings can be found [here](https://github.com/Duedot43/VirtualPass/wiki).
* Next go to the VirtualPass website you just set up with your Apache server and log into the teacher portal using the username and password you made in the configuration file.
* Now click the `Make Your Room` button and type the number of the room you are in.
* It will generate a QR code that you can download, print, then integrate in the classroom.
* You must do this for every classroom.

