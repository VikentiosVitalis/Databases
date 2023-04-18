USE project2021;

CREATE TABLE customer (
    nfc_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(20),
    last_name VARCHAR(20),
    date_of_birth DATE NOT NULL,
    id_number INT,
    id_type VARCHAR(20),
    publish_dept_id VARCHAR(20),
    total_charges int not null
);

CREATE TABLE email (
	email VARCHAR(100) ,
	nfc_id INT ,
	PRIMARY KEY (email),
	FOREIGN KEY (nfc_id) REFERENCES customer(nfc_id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE phone_number(
    phone_num VARCHAR(15) NOT NULL UNIQUE,
    nfc_id INT ,
    PRIMARY KEY (phone_num),
    FOREIGN KEY (nfc_id) REFERENCES customer(nfc_id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE services(
	service_id INT PRIMARY KEY,
    service_description VARCHAR(50)
);

CREATE TABLE facilities(
	facility_id INT PRIMARY KEY,
    number_of_bedrooms INT NOT NULL,
    facility_name VARCHAR(50),
    facility_description varchar(50),
    service_id INT NOT NULL,
    FOREIGN KEY (service_id) REFERENCES services(service_id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE having_access (
	nfc_id INT ,
    facility_id INT  ,
    start_datetime DATETIME NOT NULL ,
    finish_datetime DATETIME NOT NULL ,
    PRIMARY KEY (nfc_id, facility_id) ,
    FOREIGN KEY (nfc_id) REFERENCES customer(nfc_id) ON UPDATE CASCADE ON DELETE CASCADE ,
    FOREIGN KEY (facility_id) REFERENCES facilities(facility_id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE sub_compulsory_service (
	service_id INT PRIMARY KEY ,
    FOREIGN KEY (service_id) REFERENCES services(service_id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE subscribing_to_services (
    subscribing_to_services_id INT PRIMARY KEY AUTO_INCREMENT ,
    service_id INT ,
    nfc_id INT ,
    sub_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (nfc_id) REFERENCES customer(nfc_id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES sub_compulsory_service(service_id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE receiving_services (
    receiving_services_id INT PRIMARY KEY AUTO_INCREMENT ,
    service_id INT ,
    nfc_id INT ,
    charge_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    charge_description VARCHAR(30),
    service_fee INT NOT NULL,
    FOREIGN KEY (nfc_id) REFERENCES customer(nfc_id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES services(service_id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE visiting (
    visiting_id INT PRIMARY KEY AUTO_INCREMENT ,
    nfc_id  INT ,
    facility_id INT ,
    entrance_datetime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
    exit_datetime DATETIME NOT NULL ,
    FOREIGN KEY (nfc_id) REFERENCES customer(nfc_id) ON UPDATE CASCADE ON DELETE CASCADE ,
    FOREIGN KEY (facility_id) REFERENCES facilities(facility_id) ON UPDATE CASCADE ON DELETE CASCADE
);
