CREATE USER 'WA_DbUser'@'localhost' IDENTIFIED BY  'secretpassword1';

GRANT USAGE ON * . * TO  'WA_DbUser'@'localhost' IDENTIFIED BY  'secretpassword1' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;

#GRANT ALL PRIVILEGES ON  `csit537_project1` . * TO  'WA_DbUser'@'localhost';
GRANT ALL PRIVILEGES ON  `cafedroid` . * TO  'WA_DbUser'@'localhost';
