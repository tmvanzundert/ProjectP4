-- Test calls for stored procedures

-- Test AddProduct procedure
CALL AddProduct('TestProduct', 1, 99.99);

-- Test CreateUser procedure 
CALL CreateUser(
    'testuser',
    '123 Test St',
    'password123',
    '1990-01-01',
    'test@test.com', 
    'Test',
    'User',
    '1234567890',
    'User'
);

-- Test CreateSupplier procedure
CALL CreateSupplier(
    'TestSupplier',
    '456 Supplier St',
    'TestCountry',
    'John Doe',
    '0987654321'
);

-- Test UpdateStock procedure
CALL UpdateStock('TestProduct', 'TestLocation', 0);

-- Test GenerateSalesReport procedure
INSERT INTO `Order` (ReferenceNumber, Date, TotalPrice)
VALUES ('TEST123', '2023-01-01', 100.00);
CALL GenerateSalesReport('2023-01-01', '2023-12-31');

-- Clean up test data
/* DELETE FROM `Order` WHERE ReferenceNumber = 'TEST123';
DELETE FROM User WHERE UserName = 'testuser';
DELETE FROM Supplier WHERE SupplierName = 'TestSupplier';
DELETE FROM Product WHERE ProductName = 'TestProduct'; */

-- Existing procedure tests remain the same...

-- Additional comprehensive trigger tests

-- Test cascade updates for Product-Supplier relationship
INSERT INTO Supplier (SupplierName, Address, Country, SalesPerson, PhoneNumber)
VALUES ('TriggerSupplier', '789 Supplier Ave', 'TestLand', 'Jane Smith', '1122334455');

INSERT INTO Product (ProductName, Availability, Price, Status, ProviderName) 
VALUES ('CascadeTestProduct', 1, 299.99, 'Available', 'TriggerSupplier');

-- Test cascade update of supplier name
UPDATE Supplier 
SET SupplierName = 'TriggerSupplierNew'
WHERE SupplierName = 'TriggerSupplier';

-- Verify cascade worked
SELECT ProductName, ProviderName 
FROM Product 
WHERE ProductName = 'CascadeTestProduct';

-- Test multiple product status updates in same order
INSERT INTO Product (ProductName, Availability, Price, Status)
VALUES 
('MultiProduct1', 1, 99.99, 'Available'),
('MultiProduct2', 1, 149.99, 'Available');

INSERT INTO `Order` (ReferenceNumber, Date, Status, TotalPrice)
VALUES ('MULTITRIG', '2023-01-01', 'Payment Processing', 249.98);

INSERT INTO Order_Product (ProductName, ReferenceNumber, Quantity)
VALUES 
('MultiProduct1', 'MULTITRIG', 1),
('MultiProduct2', 'MULTITRIG', 1);

-- Test trigger handles multiple products
UPDATE `Order`
SET Status = 'Betaling Voltooid'
WHERE ReferenceNumber = 'MULTITRIG';

-- Verify all products updated
SELECT ProductName, Availability, Status
FROM Product 
WHERE ProductName IN ('MultiProduct1', 'MultiProduct2');

-- Test PreventNegativeStock with boundary value
UPDATE Product 
SET Availability = 0
WHERE ProductName = 'MultiProduct1';

-- Test RestrictProductDeletion with multiple orders
INSERT INTO `Order` (ReferenceNumber, Date, Status, TotalPrice)
VALUES ('MULTITRIG2', '2023-01-02', 'Payment Processing', 99.99);

INSERT INTO Order_Product (ProductName, ReferenceNumber, Quantity)
VALUES ('MultiProduct1', 'MULTITRIG2', 1);

-- Attempt delete should fail
DELETE FROM Product 
WHERE ProductName = 'MultiProduct1';

-- Create user shoud return error
CALL CreateUser(
    'testuser',
    '123 Test St',
    'password123',
    '1990-01-01',
    'test@test.com', 
    'Test',
    'User',
    '',
    'User'
);

-- Clean up all test data
/* DELETE FROM Order_Product WHERE ReferenceNumber IN ('MULTITRIG', 'MULTITRIG2');
DELETE FROM `Order` WHERE ReferenceNumber IN ('MULTITRIG', 'MULTITRIG2');
DELETE FROM Product WHERE ProductName IN ('CascadeTestProduct', 'MultiProduct1', 'MultiProduct2', 'DupeProduct');
DELETE FROM Supplier WHERE SupplierName = 'TriggerSupplierNew'; */