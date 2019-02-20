### Technologies used within this small project:
- php (some parts are done with OOP practices, connection to MySql is done via PDO approach, generating XML document via DOMDocument, working with login cookies...)
- mysql (has generated temp testing data)
- javascript (jquery, ajax)
- css

HTML template for this application is taken from https://github.com/gurayyarar/AdminBSBMaterialDesign

*This application has php mixed with HTML which is not the best practice, but now it is time consuming for me to repack it and divide these 2 which is why they are mixed because this is how I started to work at first.*


### - Product Payment Information System -
Basic functionality, main idea was to simulate how the cash registers work. Combining the data from bought products into receipts and enabling the right users to view the data.

There are 2 types of accounts: worker and admin:
- __ADMIN__ : has the ability to see some information via graphs and can see data via tables (pagination used), have buttons to add/remove the data, can add/remove accounts etc. 
- __WORKER__ : has an option to add/remove bought items and to make the receipt.



How to install:
- load SQL file into MySql database server
- copy php files into the root directory of the server
- Login creditionals for accounts: 
    - USERNAME : admin | PASSWORD : admin
    - USERNAME : radnik1 | PASSWORD : radnik

