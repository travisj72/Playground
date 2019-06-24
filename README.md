# DatabasePlayground
Playground for PHP, Python and SQL 


These files contain functions that I have created to do specific things inside of php web pages, or for pulling data into databases.

# PHP Curl
PHP Curl is a call to a rest interface with a Curl. This function needs a url for the rest interface, the type of operation (POST, GET, DELETE ... ) and the data that goes in the body.

# PHP INI Operations
This file has a few functions to read through a .ini file and add or remove the certain key values from sections. Also when there is an attempt for an add there is a duplicate check.

# PHP Connect to MySQL DB
Pretty straightforward here, just connects to a SQL database and read through the data for names and ids. Lots of different paths to go here!

# PHP MySQL Sanitize input
I want to make my own method to clean input before it goes into a SQL query to prevent from harmful injections.

# Deep_Interface
This file is just a nifty thing that iterates through everything in your directory and prints out messages. These are all random and do nothing besides print out lines. 

# Gather_Data
This is my work in process project to gather data from an existing database and table and move it to a new database and table. It will log everything in a certain destination and then it will time the total process of this. It will create the new table if it is not there, else it will just update it.
