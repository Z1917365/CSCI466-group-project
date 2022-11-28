/* Create Tables */

create table User
(
    Username varchar(50) UNIQUE Primary Key,
    Password varchar(50) NOT NULL,
    Iscust int (11) NOT NULL,
    Isemp int (11) NOT NULL,
    Email varchar(50) NOT NULL,
    Phone varchar(20) NOT NULL,
    Address varchar(100) NOT NULL,
    CCV varchar (10) NOT NULL,
    CC_Num varchar (20) NOT NULL,
    CC_Exp varchar (20) NOT NULL
 /* For Iscust and Isemp -> 1 for (true) 0 for (false)  */
);


create table Inventory
(
    Product_ID int (11) PRIMARY KEY AUTO_INCREMENT NOT NULL, 
    Price int(11) NOT NULL,
    QuantityinStock int (11) NOT NULL,
    Name varchar (50) NOT NULL

);


create table Cart
(
    Order_ID int(11) AUTO_INCREMENT PRIMARY KEY,
    Quantity int (11) NOT NULL,
    Total int(11) NOT NULL,
    Product_ID int (11) NOT NULL,

    FOREIGN KEY (Product_ID) References Inventory(Product_ID)
); 




create table Orders
(

Order_ID int (11) AUTO_INCREMENT, -- from cart
Username varchar(50) UNIQUE, -- from user
CCV int (11) NOT NULL,
CC_Num int (11) NOT NULL,
CC_Exp varchar (50) NOT NULL,
Shipping_address varchar(255) NOT NULL,

PRIMARY KEY (ORDER_ID),
FOREIGN KEY (Order_ID) References Cart (Order_ID),
FOREIGN KEY (Username) References User (Username)

);


/* Insert into Inventory */

INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name) VALUES (1,650,20,'Akita');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name) VALUES (2,900,30, 'Boxer');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name) VALUES (3,800, 10, 'Cavalier King Charles Spaniel');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name) VALUES (4,1200, 14, 'Yorkshire Terrier');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name) VALUES (5,1400, 45, 'English Bull Dog');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name) VALUES (6,150, 26, 'Samoyed');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name) VALUES (7,250, 32, 'Yorkie Poo');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name) VALUES (8,200, 14, 'Greate Dane');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name) VALUES (9,560, 6, 'Saint Bernard');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name) VALUES (10,550, 8, 'Greate Pyrenees');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name) VALUES (11,650, 17, 'Golden Retriever');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name) VALUES (12,2000, 18, 'Italian Greyhound');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name) VALUES (13,600, 25, 'Keeshond');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name) VALUES (14,1200, 12, 'Mastiff');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name) VALUES (15,850, 51, 'Dachshund');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name) VALUES (16, 2000, 18, 'Tosa');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name) VALUES (17,1350, 16, 'German Shepard');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name) VALUES (18,1500, 39, 'Rottweiler');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name) VALUES (19,750, 35, 'Polish Lowland Sheepdog');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name) VALUES (20, 2000, 24, 'Otterhound');


/* Insert into Cust */


INSERT INTO User (Username, Password, Iscust, Isemp, Email, Phone, Address, CCV, CC_Num, CC_Exp) VALUES ('BarkB@rk1','NotCh!cken', 1, 0, 'bark@email.com', '5553832145', '308 Negra Arroyo Lane Albuquerque, New Mexico', '234', '5678901234567890', '08/2024');
INSERT INTO User (Username, Password, Iscust, Isemp, Email, Phone, Address, CCV, CC_Num, CC_Exp) VALUES ('ruffScream98', 'NotB33ff', 1, 0, 'ruff@email.com','5552345127', '13197 Marybrook dr. Plainfield Il, 60435', '123','4567890123456789', '08/2029');
INSERT INTO User (Username, Password, Iscust, Isemp, Email, Phone, Address, CCV, CC_Num, CC_Exp) VALUES ('tinydogscream', 'NotL@mb1', 1, 0, 'tinydog@email.com', '5552341267', '701 W Lincoln Hwy, Dekalb, IL, 60115', '978', '4647632857120985', '08/2023');
INSERT INTO User (Username, Password, Iscust, Isemp, Email, Phone, Address, CCV, CC_Num, CC_Exp) VALUES ('NeverGonna', 'GiveYouUp', 1, 0, 'nevergonna@email.com', '5556463700', '1640 Dekalb Ave, Sycamore, IL, 60178', '378', '5384720403958395', '12/2022');
INSERT INTO User (Username, Password, Iscust, Isemp, Email, Phone, Address, CCV, CC_Num, CC_Exp) VALUES ('NeverGoingToINC', 'LetYouDown', 1, 0, 'nevergoing@email.com', '5554444321', '901 Lucinda Ave Stel, Dekalb, IL, 60115', '239', '7774635212348954', '02/26');






