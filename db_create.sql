drop database nagidb; drop database strixProducts; drop database strixdb; drop database accountLogs;

CREATE DATABASE nagidb;
CREATE DATABASE strixdb;
CREATE DATABASE strixProducts;
CREATE DATABASE accountLogs;

--CREATE USER 'nagiTest'@'localhost' IDENTIFIED BY 'hV22buZAVFk22fx';
GRANT ALL ON nagidb.* TO 'nagiTest'@'localhost';
GRANT ALL ON strixdb.* TO 'nagiTest'@'localhost';
GRANT ALL ON strixProducts.* TO 'nagiTest'@'localhost';
GRANT ALL ON accountLogs.* TO 'nagiTest'@'localhost';
