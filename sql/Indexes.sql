-- USE project2021; 
-- 3 Main indexes of our database
-- nfc_id / facility_id / service_id
CREATE INDEX nfc_id_idx ON receiving_services(nfc_id);
CREATE INDEX facility_id_idx ON having_access(facility_id);
CREATE INDEX service_id_idx ON receiving_services(service_id);