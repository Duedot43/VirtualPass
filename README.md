# VirtualPass
This is a program where a student scans a QR code with a unique link that is descrobed in the $_GET variable in the link if this 
QRID is not registered to a room it will ask the user to register it and store it into a file in registered_qrid with the page=<qrid> number and the specified room number to report in the log
if the identifier cookie is not found in the clients browser the student will register their info and generate a random set of numbers as a unique_ID which is
stored in the value of the cookie along with a folder with the uniquie ID's name and info in a text file which is to be reported in the log file
Tested for GNU/Linux may work on MacOS, and a Windows version is in progress

############################################
#//////////////////////////////////////////#
#//THIS PROGRAM IS DESIGNED FOR GNU/LINUX//#
#//////////////////////////////////////////#
############################################
