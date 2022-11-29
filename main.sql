/* Create Tables */

create table User
(
    Username varchar(50) UNIQUE Primary Key,
    Password varchar(50) NOT NULL,
    Address varchar(100) NOT NULL,
    Email varchar(50) NOT NULL,
    CCV int (11) NOT NULL,
    CC_Num varchar (16) NOT NULL,
    CC_Exp varchar (50) NOT NULL,
    Iscust BIT (1) NOT NULL,
    Isemp BIT (1) NOT NULL 
 /* BIT is like a boolean datatype, 1 (for TRUE) 0 (for FALSE) */
);

create table Inventory
(
    Product_ID int (11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    Username varchar(50) NOT NULL, 
    Price int(11) NOT NULL,
    QuantityinStock int (11) NOT NULL,
    Name varchar (50) NOT NULL
);

create table Cart
(
    Order_ID int(11) AUTO_INCREMENT PRIMARY KEY,
    Quantity int (11) NOT NULL,
    Total int(11) DEFAULT 0,
    Product_ID int (11) NOT NULL,

    FOREIGN KEY (Product_ID) References Inventory(Product_ID)
);

create table Orders
(
    Confirm_Num int (11) AUTO_INCREMENT PRIMARY KEY,
    Is_processed BIT (1) DEFAULT 0,
    Is_shipped BIT (1) DEFAULT 0,
    amountPaid varchar(50) NOT NULL,
    track_order varchar(50) NOT NULL, /* Username..? */
    add_note varchar(50) NOT NULL /* String = "Quantity : ProductID : " */
);


create table Pics
(
    Product_ID int (11) AUTO_INCREMENT PRIMARY KEY,
    Img_Source varchar(50) NOT NULL
);


/* Insert into Inventory */

INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name, Username) VALUES (1,650,20, 'Akita', 'Hellodog');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name, Username) VALUES (2,900,30, 'Boxer', 'Hellodog');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name, Username) VALUES (3,800, 10, 'Cavalier King Charles Spaniel', 'Hellodog');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name, Username) VALUES (4,1200, 14, 'Yorkshire Terrier', 'Hellodog');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name, Username) VALUES (5,1400, 45, 'English Bull Dog', 'Goodbyedog');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name, Username) VALUES (6,150, 26, 'Samoyed', 'Goodbyedog');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name, Username) VALUES (7,250, 32, 'Yorkie Poo', 'Goodbyedog');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name, Username) VALUES (8,200, 14, 'Greate Dane', 'Goodbyedog');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name, Username) VALUES (9,560, 6, 'Saint Bernard', 'Barkybark');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name, Username) VALUES (10,550, 8, 'Greate Pyrenees', 'Barkybark');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name, Username) VALUES (11,650, 17, 'Golden Retriever', 'Barkybark');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name, Username) VALUES (12,2000, 18, 'Italian Greyhound', 'Barkybark');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name, Username) VALUES (13,600, 25, 'Keeshond', 'GopackGo');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name, Username) VALUES (14,1200, 12, 'Mastiff', 'GopackGo');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name, Username) VALUES (15,850, 51, 'Dachshund', 'GopackGo');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name, Username) VALUES (16, 2000, 18, 'Tosa', 'GopackGo');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name, Username) VALUES (17,1350, 16, 'German Shepard', 'GobearsGo');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name, Username) VALUES (18,1500, 39, 'Rottweiler', 'GobearsGo');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name, Username) VALUES (19,750, 35, 'Polish Lowland Sheepdog', 'GobearsGo');
INSERT INTO Inventory (Product_ID, Price, QuantityinStock, Name, Username) VALUES (20, 2000, 24, 'Otterhound', 'GobearsGo');


/* Insert into User */

INSERT INTO User (Username, Password, Iscust, Isemp, Email, Address, CCV, CC_Num, CC_Exp) VALUES ('BarkB@rk1', 'NotCh!cken', 1, 0, 'bark@email.com', '308 Negra Arroyo Lane Albuquerque, New Mexico', '234', '5678901234567890', '08/2024');
INSERT INTO User (Username, Password, Iscust, Isemp, Email, Address, CCV, CC_Num, CC_Exp) VALUES ('ruffScream98', 'NotB33ff', 1, 0, 'ruff@email.com', '13197 Marybrook dr. Plainfield Il, 60435', '123','4567890123456789', '08/2029');
INSERT INTO User (Username, Password, Iscust, Isemp, Email, Address, CCV, CC_Num, CC_Exp) VALUES ('tinydogscream', 'NotL@mb1', 1, 0, 'tinydog@email.com', '701 W Lincoln Hwy, Dekalb, IL, 60115', '978', '4647632857120985', '08/2023');
INSERT INTO User (Username, Password, Iscust, Isemp, Email, Address, CCV, CC_Num, CC_Exp) VALUES ('NeverGonna', 'GiveYouUp', 1, 0, 'nevergonna@email.com', '1640 Dekalb Ave, Sycamore, IL, 60178', '378', '5384720403958395', '12/2022');
INSERT INTO User (Username, Password, Iscust, Isemp, Email, Address, CCV, CC_Num, CC_Exp) VALUES ('NeverGoingToINC', 'LetYouDown', 1, 0, 'nevergoing@email.com', '901 Lucinda Ave Stel, Dekalb, IL, 60115', '239', '7774635212348954', '02/26');

INSERT INTO User (Username, Password, Iscust, Isemp, Email, Address, CCV, CC_Num, CC_Exp) VALUES ('Hellodog', 'ItisME',0, 1, 'Hello@email.com', '901 Normal Ave Stel, Dekalb, IL, 60115', '339', '8584635212348987', '01/27');
INSERT INTO User (Username, Password, Iscust, Isemp, Email, Address, CCV, CC_Num, CC_Exp) VALUES ('Goodbyedog', 'ItisnotME',0, 1, 'Goodbye@email.com', '802 Annie Gliddeb Ave Stel, Dekalb, IL, 60115', '545', '8554525212348987', '09/23');
INSERT INTO User (Username, Password, Iscust, Isemp, Email, Address, CCV, CC_Num, CC_Exp) VALUES ('Barkybark', 'BarkBarky',0, 1, 'Barkybark43@email.com', '532 Annie Glidden Dr Backers, Dekalb, IL, 60115', '631', '8554525212376210', '07/22');
INSERT INTO User (Username, Password, Iscust, Isemp, Email, Address, CCV, CC_Num, CC_Exp) VALUES ('GopackGo', 'GobearsGO',0, 1, 'Gopackgo@email.com', '456 Lucinda Dr, Dekalb, IL, 60115', '542', '8554525215453000', '10/27');
INSERT INTO User (Username, Password, Iscust, Isemp, Email, Address, CCV, CC_Num, CC_Exp) VALUES ('GobearsGo', 'packerdog',0, 1, 'packerdog.com', '650 Normal Dr, Dekalb, IL, 60115', '490', '8554525243434000', '11/29');


/* Insert into Pics */

INSERT INTO Pics (Img_Source) VALUES ('https://i.imgur.com/IquceOo.jpg');
INSERT INTO Pics (Img_Source) VALUES ('https://i.imgur.com/mtghjK6.jpg');
INSERT INTO Pics (Img_Source) VALUES ('https://i.imgur.com/GB1FWdY.jpg');
INSERT INTO Pics (Img_Source) VALUES ('https://i.imgur.com/d7U4t9q.jpg');
INSERT INTO Pics (Img_Source) VALUES ('https://i.imgur.com/nK3qGO2.jpg');
INSERT INTO Pics (Img_Source) VALUES ('https://i.imgur.com/x3cJzm1.jpg');
INSERT INTO Pics (Img_Source) VALUES ('https://i.imgur.com/z8iVyQD.jpg');
INSERT INTO Pics (Img_Source) VALUES ('https://i.imgur.com/QQ2sPaY.jpg');
INSERT INTO Pics (Img_Source) VALUES ('https://i.imgur.com/rtCjFP8.jpg');
INSERT INTO Pics (Img_Source) VALUES ('https://i.imgur.com/TtNfyUW.jpg');
INSERT INTO Pics (Img_Source) VALUES ('https://i.imgur.com/alMd66I.jpg');
INSERT INTO Pics (Img_Source) VALUES ('https://i.imgur.com/VeZvygl.jpg');
INSERT INTO Pics (Img_Source) VALUES ('https://i.imgur.com/3xC5jMI.jpg');
INSERT INTO Pics (Img_Source) VALUES ('https://i.imgur.com/woo4pFQ.jpg');
INSERT INTO Pics (Img_Source) VALUES ('https://i.imgur.com/A1FnRBu.jpg');
INSERT INTO Pics (Img_Source) VALUES ('https://i.imgur.com/mouKsV6.jpg');
INSERT INTO Pics (Img_Source) VALUES ('https://i.imgur.com/xxgLe1n.jpg');
INSERT INTO Pics (Img_Source) VALUES ('https://i.imgur.com/3hZlrqZ.jpg');
INSERT INTO Pics (Img_Source) VALUES ('https://i.imgur.com/iY1auEX.jpg');
INSERT INTO Pics (Img_Source) VALUES ('https://i.imgur.com/tjLs2mA.jpg');

