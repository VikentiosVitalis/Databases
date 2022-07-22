USE project2021;

-- UPDATE Function customer
 UPDATE customer SET 
	 first_name = 'Eldor'	
     WHERE nfc_id = 50;
    
-- SELECT * FROM customer; 
DELETE FROM customer WHERE nfc_id = 18; 

-- ------------------------------------

-- UPDATE Function services
 UPDATE services SET 
	 service_description = 'Beverage'
     WHERE service_id = 1;
    
-- SELECT * FROM services; 
DELETE FROM services WHERE service_description = 'Drink'; 

-- ------------------------------------

-- UPDATE Function facilities
 UPDATE facilities SET 
	 number_of_bedrooms = 4
     WHERE facility_id = 50;
    
-- SELECT * FROM facilities;  
DELETE FROM facilities WHERE facility_description = 'West'; 

-- ------------------------------------

-- UPDATE Function email
 UPDATE email SET 
	 email = 'test50@ntua.gr', 
	 nfc_id = 50 WHERE email = 'vrisley1d@mashable.com';
    
-- SELECT * FROM email; 
DELETE FROM email WHERE nfc_id = 50; 

 -- ------------------------------------

-- UPDATE Function phone_number 
UPDATE phone_number SET
	 phone_num = '6144950249',
     nfc_id = 50 WHERE phone_num = '7144950243';
    
-- SELECT * FROM phone_number; 
 DELETE FROM phone_number WHERE nfc_id = 50; 
 
-- -------------------------------------------

-- UPDATE Function having_access
 UPDATE having_access SET 
	 finish_datetime = '2021-07-21 15:15:05'
     WHERE nfc_id = 50;
    
-- SELECT * FROM having_access;  
DELETE FROM having_access WHERE nfc_id = 50; 

-- ------------------------------------

-- SELECT * FROM sub_compulsory_service; 
DELETE FROM sub_compulsory_service WHERE service_id = 7; 

-- -------------------------------------------------------------------------------------------------

-- UPDATE Function subscribing_to_services
UPDATE subscribing_to_services SET
	 service_id = 5,
     sub_date = '2021-12-12' WHERE nfc_id = 50; 
-- SELECT * FROM subscribing_to_services;  
 DELETE FROM subscribing_to_services WHERE nfc_id = 50; 
 
-- ----------------------------------------------------------

-- UPDATE Function receiving_services
UPDATE receiving_services SET 
	 service_id = 5,
     charge_date = '2021-12-12 16:54:30' WHERE nfc_id = 50;
    
-- SELECT * FROM receiving_services; 
 DELETE FROM receiving_services WHERE nfc_id = 50; 
 
-- -----------------------------------------------------

-- UPDATE Function visiting
UPDATE visiting SET 
     exit_datetime = '2021-12-12 16:54:30' 
     WHERE nfc_id = 50;
    
-- SELECT * FROM visiting; 
 DELETE FROM visiting WHERE nfc_id = 50; 
 
-- -----------------------------------------------------