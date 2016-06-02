CREATE TABLE USERS
(
user_id int NOT NULL AUTO_INCREMENT,
email varchar(255) NOT NULL,
password varchar(255) NOT NULL,
name varchar(255) NOT NULL,
lastname varchar(255) NOT NULL,
CONSTRAINT primary_key PRIMARY KEY (user_id),
CONSTRAINT unique_email UNIQUE (email)
);