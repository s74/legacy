CREATE USER RNAME@localhost IDENTIFIED BY 'RPASS';
CREATE DATABASE RNAME;
GRANT ALL ON RNAME.* TO RNAME@localhost;