/* Drop Tables */

DROP TABLE IF EXISTS Ordered_dish;
DROP TABLE IF EXISTS Receipt;
DROP TABLE IF EXISTS Restaurant_table;
DROP TABLE IF EXISTS Customer_order;
DROP TABLE IF EXISTS Employee;
DROP TABLE IF EXISTS Account;
DROP TABLE IF EXISTS Dish;
DROP TABLE IF EXISTS Dish_classifier;
DROP TABLE IF EXISTS Payment_classifier;
DROP TABLE IF EXISTS Role_classifier;

/* Create Tables */

-- Сущность аккаунта работника
CREATE TABLE Account
(
	-- Содержит логин работника
	login varchar(64) NOT NULL UNIQUE,
	-- Содержит пароль работника
	password char(32) NOT NULL,
	PRIMARY KEY (login)
) WITHOUT OIDS;


-- Сущность заказа
CREATE TABLE Customer_order
(
	-- Содержит идентификационный номер заказа
	id bigserial NOT NULL,
	-- Содержит идентификационный номер работника
	waiter_id bigint NOT NULL,
	-- Содержит дату создания заказа
	date_created date NOT NULL,
	-- Содержит время открытия заказа
	time_open time NOT NULL,
	-- Содержит статус заказа
	status boolean NOT NULL,
	PRIMARY KEY (id)
) WITHOUT OIDS;


-- Сущность блюда
CREATE TABLE Dish
(
	-- Содержит идентификационный номер блюда
	id bigserial NOT NULL,
	-- Содержит идентификационный номер типа блюда
	category_id int NOT NULL,
	-- Содержит название блюда
	name varchar(250) NOT NULL,
	-- Содержит цену блюда
	price numeric(6) NOT NULL,
	-- Содержит доступность блюда
	available boolean NOT NULL,
	-- Содержит количество раз, когда блюдо заказывали
	ordered_time bigint DEFAULT 0 NOT NULL,
	PRIMARY KEY (id)
) WITHOUT OIDS;


-- Классификатор типа блюда
CREATE TABLE Dish_classifier
(
	-- Содержит идентификационный номер типа блюда
	id serial NOT NULL,
	-- Содержит название типа блюда
	name varchar(25) NOT NULL,
	PRIMARY KEY (id)
) WITHOUT OIDS;


-- Сущность работника
CREATE TABLE Employee
(
	-- Содержит идентификационный номер работника
	id bigserial NOT NULL,
	-- Содержит идентификационный номер должности работника
	role_id int NOT NULL,
	-- Содержит логин работника
	login varchar(64) NOT NULL UNIQUE,
	-- Содержит имя работника
	first_name varchar(128) NOT NULL,
	-- Содержит фамилию работника
	last_name varchar(128) NOT NULL,
	-- Содержит номер телефона работника
	phone_number varchar(15) NOT NULL,
	-- Содержит электронную почту работника
	email varchar(128) NOT NULL,
	-- Содержит зарплату работника
	salary numeric(10) DEFAULT 0,
	-- Содержит статус занятости работника
	is_employed boolean DEFAULT 'true' NOT NULL,
	PRIMARY KEY (id)
) WITHOUT OIDS;


-- Сущность заказного блюда
CREATE TABLE Ordered_dish
(
	-- Содержит идентификационный номер заказанного блюда
	uid bigserial NOT NULL,
	-- Содержит идентификационный номер заказа
	order_id bigint NOT NULL,
	-- Содержит идентификационный номер блюда
	dish_id bigint NOT NULL,
	-- Содержит статус готовности блюда
	ready boolean NOT NULL,
	PRIMARY KEY (uid)
) WITHOUT OIDS;


-- Классификатор способа оплаты
CREATE TABLE Payment_classifier
(
	-- Содержит идентификационный номер способа оплаты
	id smallint NOT NULL,
	-- Содержит название способа оплата
	name varchar(25) NOT NULL,
	PRIMARY KEY (id)
) WITHOUT OIDS;


-- Сущность чека
CREATE TABLE Receipt
(
	-- Содержит идентификационный номер заказа
	order_id bigint NOT NULL,
	-- Содержит дату закрытия заказа
	date_closed date NOT NULL,
	-- Содержит время закрытия заказа
	time_close time NOT NULL,
	-- Содержит итоговую сумму
	total numeric(10) NOT NULL,
	-- Содержит идентификационный номер способа оплаты
	payment_type_id smallint NOT NULL,
	PRIMARY KEY (order_id)
) WITHOUT OIDS;


-- Сущность стола
CREATE TABLE Restaurant_table
(
	-- Содержит идентификационный номер стола
	id bigserial NOT NULL,
	-- Содержит идентификационный номер заказа
	order_id bigint,
	-- Содержит идентификационный номер работника
	waiter_id bigint,
	-- Содержит вместимость стола
	capacity smallint NOT NULL,
	PRIMARY KEY (id)
) WITHOUT OIDS;


-- Классификатор должности работника
CREATE TABLE Role_classifier
(
	-- Содержит идентификационный номер должности работника
	id serial NOT NULL,
	-- Содержит название должности работника
	name varchar(25) NOT NULL,
	PRIMARY KEY (id)
) WITHOUT OIDS;

/* Create Foreign Keys */

ALTER TABLE Employee
	ADD FOREIGN KEY (login)
	REFERENCES Account (login)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE Ordered_dish
	ADD FOREIGN KEY (order_id)
	REFERENCES Customer_order (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE Receipt
	ADD FOREIGN KEY (order_id)
	REFERENCES Customer_order (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE Restaurant_table
	ADD FOREIGN KEY (order_id)
	REFERENCES Customer_order (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE Ordered_dish
	ADD FOREIGN KEY (dish_id)
	REFERENCES Dish (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE Dish
	ADD FOREIGN KEY (category_id)
	REFERENCES Dish_classifier (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE Customer_order
	ADD FOREIGN KEY (waiter_id)
	REFERENCES Employee (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE Restaurant_table
	ADD FOREIGN KEY (waiter_id)
	REFERENCES Employee (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE Receipt
	ADD FOREIGN KEY (payment_type_id)
	REFERENCES Payment_classifier (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE Employee
	ADD FOREIGN KEY (role_id)
	REFERENCES Role_classifier (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;

/* Comments */

COMMENT ON TABLE Account IS 'Сущность аккаунта работника';
COMMENT ON COLUMN Account.login IS 'Содержит логин работника';
COMMENT ON COLUMN Account.password IS 'Содержит пароль работника';
COMMENT ON TABLE Customer_order IS 'Сущность заказа';
COMMENT ON COLUMN Customer_order.id IS 'Содержит идентификационный номер заказа';
COMMENT ON COLUMN Customer_order.waiter_id IS 'Содержит идентификационный номер работника';
COMMENT ON COLUMN Customer_order.date_created IS 'Содержит дату создания заказа';
COMMENT ON COLUMN Customer_order.time_open IS 'Содержит время открытия заказа';
COMMENT ON COLUMN Customer_order.status IS 'Содержит статус заказа';
COMMENT ON TABLE Dish IS 'Сущность блюда';
COMMENT ON COLUMN Dish.id IS 'Содержит идентификационный номер блюда';
COMMENT ON COLUMN Dish.category_id IS 'Содержит идентификационный номер типа блюда';
COMMENT ON COLUMN Dish.name IS 'Содержит название блюда';
COMMENT ON COLUMN Dish.price IS 'Содержит цену блюда';
COMMENT ON COLUMN Dish.available IS 'Содержит доступность блюда';
COMMENT ON COLUMN Dish.ordered_time IS 'Содержит количество раз, когда блюдо заказывали';
COMMENT ON TABLE Dish_classifier IS 'Классификатор типа блюда';
COMMENT ON COLUMN Dish_classifier.id IS 'Содержит идентификационный номер типа блюда';
COMMENT ON COLUMN Dish_classifier.name IS 'Содержит название типа блюда';
COMMENT ON TABLE Employee IS 'Сущность работника';
COMMENT ON COLUMN Employee.id IS 'Содержит идентификационный номер работника';
COMMENT ON COLUMN Employee.role_id IS 'Содержит идентификационный номер должности работника';
COMMENT ON COLUMN Employee.login IS 'Содержит логин работника';
COMMENT ON COLUMN Employee.first_name IS 'Содержит имя работника';
COMMENT ON COLUMN Employee.last_name IS 'Содержит фамилию работника';
COMMENT ON COLUMN Employee.phone_number IS 'Содержит номер телефона работника';
COMMENT ON COLUMN Employee.email IS 'Содержит электронную почту работника';
COMMENT ON COLUMN Employee.salary IS 'Содержит зарплату работника';
COMMENT ON COLUMN Employee.is_employed IS 'Содержит статус занятости работника';
COMMENT ON TABLE Ordered_dish IS 'Сущность заказного блюда';
COMMENT ON COLUMN Ordered_dish.uid IS 'Содержит идентификационный номер заказанного блюда';
COMMENT ON COLUMN Ordered_dish.order_id IS 'Содержит идентификационный номер заказа';
COMMENT ON COLUMN Ordered_dish.dish_id IS 'Содержит идентификационный номер блюда';
COMMENT ON COLUMN Ordered_dish.ready IS 'Содержит статус готовности блюда';
COMMENT ON TABLE Payment_classifier IS 'Классификатор способа оплаты';
COMMENT ON COLUMN Payment_classifier.id IS 'Содержит идентификационный номер способа оплаты';
COMMENT ON COLUMN Payment_classifier.name IS 'Содержит название способа оплата';
COMMENT ON TABLE Receipt IS 'Сущность чека';
COMMENT ON COLUMN Receipt.order_id IS 'Содержит идентификационный номер заказа';
COMMENT ON COLUMN Receipt.date_closed IS 'Содержит дату закрытия заказа';
COMMENT ON COLUMN Receipt.time_close IS 'Содержит время закрытия заказа';
COMMENT ON COLUMN Receipt.total IS 'Содержит итоговую сумму';
COMMENT ON COLUMN Receipt.payment_type_id IS 'Содержит идентификационный номер способа оплаты';
COMMENT ON TABLE Restaurant_table IS 'Сущность стола';
COMMENT ON COLUMN Restaurant_table.id IS 'Содержит идентификационный номер стола';
COMMENT ON COLUMN Restaurant_table.order_id IS 'Содержит идентификационный номер заказа';
COMMENT ON COLUMN Restaurant_table.waiter_id IS 'Содержит идентификационный номер работника';
COMMENT ON COLUMN Restaurant_table.capacity IS 'Содержит вместимость стола';
COMMENT ON TABLE Role_classifier IS 'Классификатор должности работника';
COMMENT ON COLUMN Role_classifier.id IS 'Содержит идентификационный номер должности работника';
COMMENT ON COLUMN Role_classifier.name IS 'Содержит название должности работника';