fail2ban-geo
============

Displays locations of IP addresses banned using fail2ban on a Google map

============

Currently not ready for release, however feel free to take a look at current progress here:

http://rbx01.martyserver.co.uk/fail2ban-geo
http://ams01.martyserver.co.uk/fail2ban-geo
http://ewr01.martyserver.co.uk/fail2ban-geo
http://sfo01.martyserver.co.uk/fail2ban-geo

============

Current checklist:

- Add ability to download ip addresses
 
============

Thanks:

- Fail2Ban team for creating the awesome tool that protects zillions of servers from attackers!
- Google for it's awesome map

============

Setup:

1. Install Fail2Ban
2. Install Webserver + PHP + MySQL server
3. Restore provided MySQL dump to new database (contains co-ordinates)
4. Upload files to web-server directory
5. Setup config file (you need to add a random key so that other people can't add records to your db)

TBC...