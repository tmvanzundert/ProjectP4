CREATE DATABASE IF NOT EXISTS plugandplay;

USE plugandplay;

SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `Order_Product`;
DROP TABLE IF EXISTS `Order`;
DROP TABLE IF EXISTS `User`;
DROP TABLE IF EXISTS `Product`;
DROP TABLE IF EXISTS `Location`;
DROP TABLE IF EXISTS `Supplier`;
SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE
    IF NOT EXISTS `Supplier` (
        `SupplierName` VARCHAR(40) PRIMARY KEY,
        `Address` VARCHAR(80),
        `Country` VARCHAR(50),
        `SalesPerson` VARCHAR(40),
        `PhoneNumber` VARCHAR(30)
    );

CREATE TABLE
    IF NOT EXISTS `Product` (
        `ProductName` VARCHAR(50) PRIMARY KEY,
        `Availability` TINYINT (1),
        `Price` DECIMAL(10, 2),
        `Status` ENUM (
            "Available",
            "Broken",
            "Battery Empty",
            "In Repair",
            "Stolen",
            "In Use"
        ),
        `Description` VARCHAR(50),
        -- Foreign Keys
        `ProviderName` VARCHAR(50),
        `StoredLocationName` VARCHAR(50)
    );

CREATE TABLE
    IF NOT EXISTS `Location` (
        `ChargingStationName` VARCHAR(50) PRIMARY KEY,
        `LocationAddress` VARCHAR(50),
        `LocationName` VARCHAR(50),
        -- Foreign Key
        `StockName` VARCHAR(50)
    );

CREATE TABLE
    IF NOT EXISTS `User` (
        `UserName` VARCHAR(30),
        `Address` VARCHAR(80),
        `AccountStatus` ENUM (
            "Active",
            "Inactive",
            "Suspended",
            "Blocked"
        ) DEFAULT "Active",
        `DateOfBirth` DATE,
        `EmailAddress` VARCHAR(30),
        `FirstName` VARCHAR(30),
        `LastName` VARCHAR(30),
        `Password` VARCHAR(100),
        `PhoneNumber` VARCHAR(30),
        `Role` ENUM (
            "Super Admin",
            "Administrator",
            "Supplier",
            "User"
        ),
        -- Foreign Key
        `PreferredLocationName` VARCHAR(50),
        -- Primary Key
        PRIMARY KEY (`UserName`, `Address`)
    );

CREATE TABLE
    IF NOT EXISTS `Order` (
        `ReferenceNumber` VARCHAR(20) PRIMARY KEY,
        `Date` DATE,
        `OpenBalance` VARCHAR(20),
        `PaymentMethod` VARCHAR(20),
        `Status` ENUM (
            "Payment Completed",
            "Payment Declined",
            "Payment Processing",
            "Picked Up",
            "Completed"
        ),
        `TotalPrice` DECIMAL(10, 2),
        -- Foreign Keys
        `ConsumerName` VARCHAR(30),
        `ConsumerAddress` VARCHAR(80),
        `CompanyName` VARCHAR(40)
    );

CREATE TABLE
    IF NOT EXISTS `Order_Product` (
        `ProductName` VARCHAR(50),
        `ReferenceNumber` VARCHAR(20),
        `Quantity` INT,
        PRIMARY KEY (`ProductName`, `ReferenceNumber`)
    );

-- Log not existing products
CREATE TABLE
    IF NOT EXISTS `LogProduct` (
        `ProductName` VARCHAR(50) PRIMARY KEY,
        `Count` INT DEFAULT 1,
        `Timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    

-- Because of error, these constraints are added to the tables after the CREATE: (errno: 150 "Foreign key constraint is incorrectly formed")
ALTER TABLE `Product` 
        ADD CONSTRAINT FK_Product FOREIGN KEY (`ProviderName`) REFERENCES Supplier (`SupplierName`) ON UPDATE CASCADE,
        ADD CONSTRAINT FK_StoredLocation FOREIGN KEY (`StoredLocationName`) REFERENCES Location (`ChargingStationName`) ON UPDATE CASCADE;

ALTER TABLE `Location`
		ADD CONSTRAINT FK_Location FOREIGN KEY (`StockName`) REFERENCES Product (`ProductName`) ON UPDATE CASCADE;
        
ALTER TABLE `User`        
        ADD CONSTRAINT FK_User FOREIGN KEY (`PreferredLocationName`) REFERENCES Location (`ChargingStationName`) ON UPDATE CASCADE;

ALTER TABLE `Order`
        ADD CONSTRAINT FK_Order FOREIGN KEY (`ConsumerName`, `ConsumerAddress`) REFERENCES User (`UserName`, `Address`),
 		ADD CONSTRAINT FK_Supplier FOREIGN KEY (`CompanyName`) REFERENCES Supplier (`SupplierName`) ON UPDATE CASCADE;
        
ALTER TABLE `Order_Product`        
        ADD CONSTRAINT FK_OrderProduct_Product FOREIGN KEY (`ProductName`) REFERENCES `Product` (`ProductName`) ON UPDATE CASCADE ON DELETE CASCADE,
        ADD CONSTRAINT FK_OrderProduct_Order FOREIGN KEY (`ReferenceNumber`) REFERENCES `Order` (`ReferenceNumber`) ON UPDATE RESTRICT ON DELETE CASCADE;



DROP PROCEDURE IF EXISTS AddProduct; -- Remove the procedure if it already exists

DELIMITER //

CREATE PROCEDURE IF NOT EXISTS AddProduct (
    IN ProductName VARCHAR(50),
    IN Availability TINYINT(1),
    IN Price DECIMAL(10,2)
)
BEGIN
    INSERT INTO Product (
        ProductName,
        Availability,
        Price
    )
    VALUES (
        ProductName,
        Availability,
        Price
    );
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS CreateUser; -- Remove the procedure if it already exists

DELIMITER //
-- Create a new stored procedure   
CREATE PROCEDURE IF NOT EXISTS CreateUser (
    IN UserName VARCHAR(30),
    IN Address VARCHAR(80),
    IN Password VARCHAR(100),
    IN DateOfBirth DATE,
    IN EmailAddress VARCHAR(30),
    IN FirstName VARCHAR(30),
    IN LastName VARCHAR(30),
    IN PhoneNumber VARCHAR(30),
    IN Role ENUM (
        "Super Admin",
        "Administrator",
        "Supplier",
        "User"
    )
)
BEGIN
    INSERT INTO User (
        UserName,
        Address,
        Password,
        DateOfBirth,
        EmailAddress,
        FirstName,
        LastName,
        PhoneNumber,
        Role
    )
    VALUES (
        UserName,
        Address,
        Password,
        DateOfBirth,
        EmailAddress,
        FirstName,
        LastName,
        PhoneNumber,
        Role
    );
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS CreateSupplier;
        DELIMITER //
-- Now you can call the procedure like this:
CREATE PROCEDURE IF NOT EXISTS CreateSupplier (
    IN SupplierName VARCHAR(40),
    IN Address VARCHAR(80),
    IN Country VARCHAR(50),
    IN SalesPerson VARCHAR(40),
    IN PhoneNumber VARCHAR(30)
)
BEGIN
    INSERT INTO Supplier (
        SupplierName,
        Address,
        Country,
        SalesPerson,
        PhoneNumber
    )
    VALUES (
        SupplierName,
        Address,
        Country,
        SalesPerson,
        PhoneNumber
    );
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS UpdateStock;
        DELIMITER //
-- Create a new stored procedure

CREATE PROCEDURE IF NOT EXISTS UpdateStock (
    IN ProductName VARCHAR(50),
    IN StockName VARCHAR(50),
    IN Availability TINYINT(1)
)
BEGIN
    UPDATE Product
    SET Availability = Availability
    WHERE ProductName = ProductName AND StockName = StockName;
END //
DELIMITER ;


DROP PROCEDURE IF EXISTS GenerateSalesReport;
DELIMITER //
-- Create a new stored procedure
CREATE PROCEDURE IF NOT EXISTS GenerateSalesReport (
    IN StartDate DATE,
    IN EndDate DATE
)
BEGIN
    SELECT 
        SUM(TotalPrice) AS TotalSales,
        COUNT(*) AS TotalOrders
    FROM 
        `Order`
    WHERE 
        Date BETWEEN StartDate AND EndDate;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER IF NOT EXISTS UpdateOrderStatus -- Update order status to 'Betaling Voltooid' when payment is completed
AFTER UPDATE ON `Order` FOR EACH ROW
BEGIN
    IF NEW.Status = 'Betaling Voltooid' THEN
        UPDATE Product
        SET Availability = 0,
            Status = 'Gereserveerd voor klant'
        WHERE ProductName IN (SELECT ProductName FROM Order_Product WHERE ReferenceNumber = NEW.ReferenceNumber);
    END IF;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER IF NOT EXISTS PreventNegativeStock -- Prevent negative stock for a product
BEFORE UPDATE ON Product FOR EACH ROW
BEGIN
    DECLARE currentStock INT;
    SELECT Availability INTO currentStock FROM Product WHERE ProductName = NEW.ProductName;
    IF NEW.Availability < 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Stock cannot be negative';
    END IF;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER IF NOT EXISTS RestrictProductDeletion -- Prevent deletion of a product if it is part of an order
BEFORE DELETE ON Product FOR EACH ROW
BEGIN
    DECLARE productCount INT;
    SELECT COUNT(*) INTO productCount FROM Order_Product WHERE ProductName = OLD.ProductName;
    IF productCount > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cannot delete product that is part of an order';
    END IF;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER IF NOT EXISTS ThrowErrorEmptyUserField
BEFORE INSERT ON User FOR EACH ROW
BEGIN
    IF (NEW.UserName IS NULL OR NEW.UserName = '') OR
        (NEW.Password IS NULL OR NEW.Password = '') OR
        (NEW.EmailAddress IS NULL OR NEW.EmailAddress = '') OR
        (NEW.Role IS NULL)
    THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'All user fields must be filled in';
    END IF;
END //
DELIMITER ;