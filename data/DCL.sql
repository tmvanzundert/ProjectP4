-- DCL: Used for managing permissions and access control

DROP USER IF EXISTS 'dbuser'@'localhost';
DROP USER IF EXISTS 'lnaaktgeboren'@'%';
DROP USER IF EXISTS 'svandriel'@'%';
DROP USER IF EXISTS 'sdegier'@'%';
DROP USER IF EXISTS 'tvanzundert'@'%';

-- Service accounts
CREATE USER IF NOT EXISTS 'dbuser'@'localhost' IDENTIFIED BY 'LkC9STj5n6bztQ';

GRANT ALL PRIVILEGES ON plugandplay.* TO 'dbuser'@'localhost';

-- Developers
CREATE USER IF NOT EXISTS 'lnaaktgeboren'@'%' IDENTIFIED BY 'ENxS39eN7giS9h';
CREATE USER IF NOT EXISTS 'svandriel'@'%' IDENTIFIED BY 'xuW7yab5y8mmDx';
CREATE USER IF NOT EXISTS 'sdegier'@'%' IDENTIFIED BY 'kESbWFwGLY9Dqo';
CREATE USER IF NOT EXISTS 'tvanzundert'@'%' IDENTIFIED BY 'TVUPgwBm9fL7ST';

GRANT ALL PRIVILEGES ON plugandplay.* TO 'lnaaktgeboren'@'%';
GRANT ALL PRIVILEGES ON plugandplay.* TO 'svandriel'@'%';
GRANT ALL PRIVILEGES ON plugandplay.* TO 'sdegier'@'%';
GRANT ALL PRIVILEGES ON plugandplay.* TO 'tvanzundert'@'%';

-- reload privileges
FLUSH PRIVILEGES;