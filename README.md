<img src="https://raw.githubusercontent.com/Duedot43/VirtualPass/master/src/Images/preview.png" width="100" height=auto onclick='location="https://virtualpass.net"'></img><br>
**Welcome to VirtualPass a simple yet effective Virtual Hall Pass manager**<br>
***
## What is VirtualPass?
VirtualPass is a simple website for checking in or out students from a classroom with a scan and go system based off of QR codes.<br><br>
It is very easy to set up and requires no third party dependinces it supplies easy to visualize graphs and system configuration right from the web page.<br><br>
User data is stored outside of the readable web scope so only the API with an API key can access this data.<br><br>
***
## Installation
* download the latest release<br>

* Unzip it and move it to `/var/www` assuming you are using an Apache server.<br>
* Install the PHP binary using your distros package manager.<br>
* Configure your server to run PHP code and tell it the website DIR is at `/var/www/VirtualPass/src/`.
***
## Setup
* go into your config file located at `/var/www/VirtualPass/config/config.ini`.
* Specify the settings you want descriptions of the settings can be found [here](https://github.com/Duedot43/VirtualPass/wiki).
* Next go to the VirtualPass website you just set up with your Apache server and log into the teacher portal using the username and password you made in the configuration file.
* Now click the `Make Your Room` button and type the number of the room you are in.
* It will give you a QR code that you can download, download it print it and put it in a place where students can easly scan it while going out you must do this for every classroom.

