create table StoreItems (
        itemid CHAR(5) PRIMARY KEY,
	price DECIMAL(6,2)
);

create table ComicBooks (
	ISBN CHAR (13) UNIQUE,
	title VARCHAR (20),
	publishedDate DATE,
	noOfCopies INTEGER CHECK (noOfCopies >= 0),
	itemid CHAR(5) REFERENCES StoreItems(itemid)
);

create table TShirt (
	shirtsize VARCHAR(4),
	itemid CHAR(5) REFERENCES StoreItems (itemid)
);



create table Customers (
	custid CHAR(5),
	name VARCHAR(15),
	phone CHAR(10) UNIQUE not null,
	email VARCHAR (20) UNIQUE not null,
	address VARCHAR(40),
	PRIMARY KEY (custid)
);

/*	Gold Customer has an is-a relationship with customer	*/
create table GoldCustomers(
	dateJoined DATE, 
	custid CHAR(5) REFERENCES Customers (custid)
);

create table ItemOrder (
        orderid CHAR(5),
        custid CHAR(5) REFERENCES Customers (custid),
        itemid CHAR(5) REFERENCES StoreItems (itemid),
        dateOfOrder DATE,
        noOfItems INTEGER,
        shippedDate DATE,
        shippingFee decimal(4,2),
        PRIMARY KEY (orderid)
);

/
show errors;
