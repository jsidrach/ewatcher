# PV-arduino

Arduino is a free hardware plataform. This project uses ARDUINO-YÚN as the component that integrates the device. 

It has two processors, ATmega32u4 and Atheros AR9331. The first one executes the Skecth programed through the Arduino IDE, and the second one executes Linino, a Linux operative system based in
OpenWRT.

This shield has integrated Ethernet and WiFi, USB-A port, microSD card slot, 20
digital pins of I/O, a 16 MHz clock, micro USB connector, ICSP
and 3 reset buttons. The communication between the two processors is made using the library Bridge

WiFi, Ethernet, USB-A connector and the microSD card are controlled by Linino and is the library Bridge the one taht offers an interface of this components for the Sketch of Arduino.

## External devices and asembling

This project needs three devices to be set. First, you need a CURRENT SENSOR and a VOLTAGE SENSOR. Both have to be assembled with the third device, the EMONTX SHIELD.

Along with the Emontx Shield, OpenEnergyMonitor gives a libray called Emonlib to program the shield. This shield can be easiliy assembled with the Arduino through the I/O connectors. Some components of the board have to be welded.

## Programming Arduino Yún

Arduino Y´un is programmed using the app Arduino IDE (1.5.4 and forward). The ATmega32u4 in the Arduino Yún comes with a bootloader that allows you to load the new code without an external
programmer. It communicates using the protocol AVR109.

### Aditional services. Linino Configuration

* **Servicio SFTP:** We need to install first SFTP in Linino for the exchange of files between the computer and the Arduino. Using SSH we do the following:

>>opkg update

>>opkg install openssh-sftp-server

* **PHP support:** The web server in Linino needs it for the configuration web in the monitoring system:

>>opkg update

>>opkg install php5 php5-cgi

We need also to access to the configuration file in the web server /etc/config/uhttpd and uncomment the line:

>>list interpreter “.php=/usr/bin/phpcgi”

* **Configuration web for the device:** The web-app created for the configuration of the clien device (calibration coefficients, apikey, server, etc) has to be installed in the device copying the content of the directory *Web de configuración*
in Arduino Yún in the directory /www.

## Web Configuration
 It has the following parameters:
 
* **URL / IP servidor EmonCMS:** Address of the server
* **Carpeta de instalación EmonCMS(empty if it is root):** Name of the emoncms directory
* **APIKEY de la cuenta EmonCMS:** Autentification key
* **Periodo de envío de datos al servidor EmonCMS(miliseconds):** Waiting time between data sendings
* **Tiempo de estabilizaci´on de sensores en arranque(miliseconds):** Time for the device to stabilize the data
* **Identificaci´on del nodo (number):** ID of the device
* **Habilitar/Deshabilitar sensores:** Enable os disable the sensor pipes
* **Calibración de sensores:** Coeficients of calibration for the sensors

You need to reboot the Sketch to actualize these parameters.

### Access to the configuration web

Tha access can be done either by WiFi or Ethernet.

If it is the first time you connect to the device, access to the open WiFi net ArduinoYun-XXXXXXXXXXXX. The device has a DHCP server So your computer can obtain an adecuated IP adress for this net.

If you want to connect by Ethernet you have to configure the net in your compuetr. By default the IP address of the device is 192.168.240.1, so you can, for example, set the following:

◦ IP: 192.168.240.19

◦ Subnet mask: 255.255.255.0

◦ Default gateaway: 192.168.240.1

Then connect through an Ethernet wire to the device

Using a web browser go to http://arduino.local or the IP addres http://192.168.240.1. Then you'll see the home page of ArduinoYunB1, which requires the password “arduino”. The next step is to click in *Configure*