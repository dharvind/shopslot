# shopslot
ShopSlot aims to be a quick ticketing solution for supermarkets (following COVID-19 situation in 2020).
Released as open source on Github.

In short, since COVID-19 lockdowns and supermarkets' queues overflowing with people which increases risks of contagion and waiting time, this project can be used by e.g. supermarkets to allow the public to obtain a ticket for a timeslot at the supermarket. This hopefully can help to allow presence of a maximum number of people in the supermarket during one timeslot.

Main features:
- Enable the public to select a shop, select a timeslot, book and confirm the timeslot
- Generate a ticket for the public which contains a QR code which can be used to verify the ticket's validity with a QR scanner
- Cron jobs to initialise a shop's timeslots for a week, deactivate and delete expired timeslot

To setup:
- Checkout the project in a directory on the web server
- Create your database using the sql file structure
- Add a line for your shop/supermarket in table Shop leaving email_verified as 0
e.g. # id, name, address, comments, email, max_per_slot, mon_alpha_csv, tue_alpha_csv, wed_alpha_csv, thu_alpha_csv, fri_alpha_csv, sat_alpha_csv, sun_alpha_csv, open_time, close_time, key, email_verified, slot_duration_min
'1', 'Winners Rose Belle', 'Rose Belle', '', 'w@gmail.com', '30', 'A,B,C,D,E,F,G,H', 'I,J,K,L,M,N,O,P', 'Q,R,S,T,U,V,W,X,Y,Z', 'A,B,C,D,E,F,G,H', 'I,J,K,L,M,N,O,P', 'Q,R,S,T,U,V,W,X,Y,Z', '', '09:00:00', '17:00:00', 'IUHDjsdhnlkfjhsoifuw9a8e70593849iu43u8rt894h304', '0', '30'
- Configure config/*php files
- Configure database, email account, timezone, email smtp settings
- Point domain or subdomain to the root directory/web dir
- Configure cron job in commands directory as 
0 0 * * * /usr/local/bin/php /home/whereyourrootdiris/shopslot/yii cron/generate-next-timeslots >/dev/null 2>&1
Refer to the comments in the commands directory.

Project has been developed with Yii2 PHP Framework.

Kind Regards and be safe,
Dharvin from Mauritius.
