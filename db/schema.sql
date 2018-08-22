DROP DATABASE IF EXISTS cheers_db;
CREATE DATABASE cheers_db;
USE cheers_db;

CREATE TABLE cheers (

id INT NOT NULL AUTO_INCREMENT,
name VARCHAR(255) NOT NULL,
ingredients VARCHAR(255) NOT NULL,
recipe VARCHAR(255) NOT NULL,
PRIMARY KEY (id)
);
