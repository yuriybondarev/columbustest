CREATE DATABASE IF NOT EXISTS columbus;
USE columbus;

CREATE TABLE IF NOT EXISTS main (
    code INT NOT NULL PRIMARY KEY,
    title VARCHAR(200) NOT NULL
);