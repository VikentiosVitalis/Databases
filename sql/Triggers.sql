-- Triggers 
use project2021; 

//==================================================================
delimiter $$

CREATE TRIGGER delete_customer BEFORE DELETE ON customer
	FOR EACH ROW 
    BEGIN
    UPDATE visiting SET nfc_id = NULL WHERE nfc_id = OLD.nfc_id;
	UPDATE receiving_services SET nfc_id = NULL WHERE nfc_id = OLD.nfc_id;
    END$$
delimiter ;
//=====================================================================

delimiter $$

CREATE TRIGGER get_new_charges AFTER INSERT ON receiving_services
	FOR EACH ROW 
    BEGIN
    UPDATE customer SET total_charges = total_charges + NEW.service_fee WHERE nfc_id = NEW.nfc_id;
    END$$
delimiter ;