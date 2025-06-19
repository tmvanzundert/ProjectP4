USE `plugandplay`;

-- Supplier inserts
INSERT INTO `Supplier` (`SupplierName`, `Address`, `Country`, `SalesPerson`, `PhoneNumber`) 
VALUES ("Power Supply Nu", "De Herbeenlaan 363", "Nederland", "Frans van Veen", "110101"),
("Amazon EU S.à r.l.", "Mr. Treublaan 7", "Nederland", "Annette Maan", "185396"),
("UGREEN.", "19H WAN DI PLAZA 3 TAI YU STREET SAN PO KONG KOWLOON BAY", "China", "Ping Yo", "734075");

-- Location inserts - Removed StockName initially since it has a circular reference with Product
INSERT INTO `Location` (`ChargingStationName`, `LocationName`, `LocationAddress`) 
VALUES ("Amsterdam Rai", "Amsterdam Rai", "Europaplein 24"),
("Breda Centraal", "Breda Centraal", " Stationsplein 16"),
("Rotterdam Euromast", "Rotterdam Euromast", "Parkhaven 20"),
("Utrecht Centraal", "Utrecht Centraal", "Croeselaan 14 P"),
("Jaarbeurs Utrecht", "Jaarbeurs Utrecht", "Croeselaan 14 P"),
("Amsterdam Centraal", "Amsterdam Centraal", "Croeselaan 14 P"),
("Rotterdam Centraal", "Rotterdam Centraal", "Croeselaan 14 P");

-- Product inserts with required fields
INSERT INTO `Product` (`ProductName`, `Availability`, `Price`, `Status`, `Description`, `ProviderName`, `StoredLocationName`) 
VALUES ("PlayGreen1", 1, 8.00, "Available", "4.000 mAh powerbank", "UGREEN.", "Amsterdam Rai"),
("PlayGreen2", 0, 8.00, "In Use", "10.000 mAh powerbank", "UGREEN.", "Breda Centraal"),
("PlayGreen3", 1, 8.00, "Available", "27.000 mAh powerbank", "UGREEN.", "Rotterdam Euromast");

-- User inserts remain the same as they appear correct
-- Keeping just a few examples for brevity
INSERT INTO `User` (`UserName`, `Address`, `DateOfBirth`, `EmailAddress`, `FirstName`, `LastName`, `Password`, `PhoneNumber`, `Role`) 
VALUES ('hdevries', 'Hendrick van loonlaan 4', '1994-01-17', 'hdevries@gmail.com', 'Hans', 'de Vries', '$2y$10$5BM1s.ZBEMqSltCPbIQb9erKxx5ac4xJgFg0MEderCt7XAolwW8wW', '06-37229539', 'User'),
('pjansen', 'Amsterdamseweg 23', '1990-03-25', 'pjansen@gmail.com', 'Peter', 'Jansen', '$2y$10$aBC1s.ZBEMqSltCPbIQb9erKxx5ac4xJgFg0MEderCt7XAolwW8wW', '06-12345678', 'User'),
('msmith', 'Rotterdamlaan 56', '1988-07-12', 'msmith@gmail.com', 'Maria', 'Smith', '$2y$10$cDE1s.ZBEMqSltCPbIQb9erKxx5ac4xJgFg0MEderCt7XAolwW8wW', '06-23456789', 'User'),
('wbakker', 'Utrechtsestraat 89', '1995-11-30', 'wbakker@gmail.com', 'Willem', 'Bakker', '$2y$10$dFG1s.ZBEMqSltCPbIQb9erKxx5ac4xJgFg0MEderCt7XAolwW8wW', '06-34567890', 'User'),
('kmuller', 'Haagweg 12', '1992-05-08', 'kmuller@gmail.com', 'Karl', 'Muller', '$2y$10$eHI1s.ZBEMqSltCPbIQb9erKxx5ac4xJgFg0MEderCt7XAolwW8wW', '06-45678901', 'User'),
('avisser', 'Bredaseweg 45', '1987-09-14', 'avisser@gmail.com', 'Anna', 'Visser', '$2y$10$fJK1s.ZBEMqSltCPbIQb9erKxx5ac4xJgFg0MEderCt7XAolwW8wW', '06-56789012', 'User'),
('rberg', 'Eindhovenlaan 78', '1993-12-03', 'rberg@gmail.com', 'Robert', 'Berg', '$2y$10$gLM1s.ZBEMqSltCPbIQb9erKxx5ac4xJgFg0MEderCt7XAolwW8wW', '06-67890123', 'User'),
('lkoster', 'Groningerstraat 34', '1991-04-22', 'lkoster@gmail.com', 'Lisa', 'Koster', '$2y$10$hNO1s.ZBEMqSltCPbIQb9erKxx5ac4xJgFg0MEderCt7XAolwW8wW', '06-78901234', 'User'),
('tmaas', 'Tilburgseweg 67', '1989-08-19', 'tmaas@gmail.com', 'Thomas', 'Maas', '$2y$10$iPQ1s.ZBEMqSltCPbIQb9erKxx5ac4xJgFg0MEderCt7XAolwW8wW', '06-89012345', 'User'),
('sking', 'Leidseweg 90', '1996-02-28', 'sking@gmail.com', 'Sarah', 'King', '$2y$10$jRS1s.ZBEMqSltCPbIQb9erKxx5ac4xJgFg0MEderCt7XAolwW8wW', '06-90123456', 'User'),
('dklein', 'Almerelaan 123', '1986-06-15', 'dklein@gmail.com', 'David', 'Klein', '$2y$10$kTU1s.ZBEMqSltCPbIQb9erKxx5ac4xJgFg0MEderCt7XAolwW8wW', '06-01234567', 'User'),
('epost', 'Zwollestraat 456', '1994-10-11', 'epost@gmail.com', 'Emma', 'Post', '$2y$10$lVW1s.ZBEMqSltCPbIQb9erKxx5ac4xJgFg0MEderCt7XAolwW8wW', '06-12345098', 'User'),
('hvos', 'Apeldoornweg 789', '1990-01-07', 'hvos@gmail.com', 'Henrik', 'Vos', '$2y$10$mXY1s.ZBEMqSltCPbIQb9erKxx5ac4xJgFg0MEderCt7XAolwW8wW', '06-23450987', 'User'),
('jmeer', 'Dordrechtlaan 012', '1988-05-24', 'jmeer@gmail.com', 'Julia', 'Meer', '$2y$10$nZA1s.ZBEMqSltCPbIQb9erKxx5ac4xJgFg0MEderCt7XAolwW8wW', '06-34509876', 'User'),
('bwit', 'Delftsestraat 345', '1993-09-09', 'bwit@gmail.com', 'Ben', 'Wit', '$2y$10$oBC1s.ZBEMqSltCPbIQb9erKxx5ac4xJgFg0MEderCt7XAolwW8wW', '06-45098765', 'User'),
('ngroen', 'Nijmegenweg 678', '1987-03-18', 'ngroen@gmail.com', 'Nina', 'Groen', '$2y$10$pDE1s.ZBEMqSltCPbIQb9erKxx5ac4xJgFg0MEderCt7XAolwW8wW', '06-50987654', 'User'),
('fbruin', 'Arnhemstraat 901', '1992-07-26', 'fbruin@gmail.com', 'Frank', 'Bruin', '$2y$10$qFG1s.ZBEMqSltCPbIQb9erKxx5ac4xJgFg0MEderCt7XAolwW8wW', '06-09876543', 'User'),
('czwart', 'Haarlemweg 234', '1995-12-13', 'czwart@gmail.com', 'Clara', 'Zwart', '$2y$10$rHI1s.ZBEMqSltCPbIQb9erKxx5ac4xJgFg0MEderCt7XAolwW8wW', '06-98765432', 'User'),
('mgeel', 'Zaandamstraat 567', '1991-04-01', 'mgeel@gmail.com', 'Marco', 'Geel', '$2y$10$sJK1s.ZBEMqSltCPbIQb9erKxx5ac4xJgFg0MEderCt7XAolwW8wW', '06-87654321', 'User'),
('prood', 'Helmondlaan 890', '1989-08-20', 'prood@gmail.com', 'Paula', 'Rood', '$2y$10$tLM1s.ZBEMqSltCPbIQb9erKxx5ac4xJgFg0MEderCt7XAolwW8wW', '06-76543210', 'User');