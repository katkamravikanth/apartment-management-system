# create databases
CREATE DATABASE IF NOT EXISTS `ams_apartment1`;

# create ams user and grant rights
CREATE USER 'ams'@'localhost' IDENTIFIED BY 'local';
GRANT ALL PRIVILEGES ON *.* TO 'ams'@'%';