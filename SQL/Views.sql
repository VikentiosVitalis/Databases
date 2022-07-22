USE project2021;

-- Drop views
drop view Available_Services;
drop view Yphresies;
drop view sales;
drop view thecustomers;
drop view visits;
drop view danger;
drop view in_danger;
drop view min;
drop view custo_age_group;
drop view time_diff;
drop view most_visited;
drop view time_diff_2;
drop view most_serviced;
drop view serviced_most;

USE project2021; 

-- Ερωτημα 7 --------------------------------------------------------------------------------------------
-- View for the all the available services of our hotel // UPDATABLE
create view Available_Services as
select * from services;

select * from Available_Services;

-- Service fee and charge date for each used service
create view Yphresies as
select receiving_services.service_id, receiving_services.nfc_id, services.service_description, receiving_services.charge_description, receiving_services.service_fee, receiving_services.charge_date FROM receiving_services
left join services
on receiving_services.service_id = services.service_id;

select * from Yphresies
order by nfc_id;

-- Ερωτημα 8 --------------------------------------------------------------------------------------------
-- View for sales
create view sales as
select receiving_services.service_id, receiving_services.charge_description,services.service_description,sum(receiving_services.service_fee) as total_fees, count(receiving_services.nfc_id) AS num_of_sales FROM receiving_services
left join services
on receiving_services.service_id = services.service_id
group by service_id
order by service_id;

select * from sales;

-- Views for all the necessary data of each customer
create view thecustomers as
select customer.nfc_id, customer.first_name, customer.last_name, customer.date_of_birth, customer.id_number,
customer.id_type, customer.publish_dept_id , email.email, phone_number.phone_num, customer.total_charges from customer
left join email
on customer.nfc_id = email.nfc_id
left join phone_number
on customer.nfc_id = phone_number.nfc_id;

SELECT * FROM thecustomers;

-- Ερωτημα 9 --------------------------------------------------------------------------------------------
-- View in case of new COVID-19 patient which tracks entrance and exit datetimes from each service
create view visits as
select visiting.nfc_id, visiting.facility_id, facilities.facility_name, facilities.service_id, facilities.facility_description,
visiting.entrance_datetime, visiting.exit_datetime from visiting
left join facilities
on facilities.facility_id = visiting.facility_id;

select * from visits;

-- View for a specific positive customer // UPDATABLE
create view danger as
select * from visits;
-- where nfc_id = 2;
select * from danger;

-- Ερωτημα 10 --------------------------------------------------------------------------------------------
-- Customers who are in danger // UPDATABLE
create view in_danger as
select visits.exit_datetime as sick_person_left, visiting.entrance_datetime, visiting.nfc_id, visits.nfc_id as CoV2_positive from visits,visiting
where visiting.nfc_id <> visits.nfc_id
order by nfc_id,Cov2_positive;

select * from in_danger;

create view min as 
select CoV2_positive,nfc_id,entrance_datetime,sick_person_left,Minutes
from (
    select CoV2_positive, nfc_id, entrance_datetime, sick_person_left,
    TIMESTAMPDIFF(minute, entrance_datetime, sick_person_left) AS 'Minutes'
    from in_danger
) as joined
where Minutes <= 60 and Minutes >= -60
order by nfc_id;

select * from min;

-- Ερωτημα 11 --------------------------------------------------------------------------------------------
-- All Customer Ages--------------------------------------------------------------------------------------
create view custo_age_group as
select nfc_id,
CASE
WHEN age between 19 AND 40 THEN '20-40'
WHEN age between 41 AND 60 THEN '41-60'
ELSE '61+'
END AS Team
from (select nfc_id, TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) as age, null as Team from customer) as xx;

select * from custo_age_group;

-- 11A Last Year Visits-----------------------------------------------------------------------------------------------
create view time_diff as
select nfc_id,facility_id,months
from (
	select visiting.nfc_id, visiting.facility_id, month('2021-12-30') - month(visiting.exit_datetime) - (DATE_FORMAT('2021-12-30', '%m%d') <  DATE_FORMAT(visiting.exit_datetime, '%m%d')) as months,
    year('2021-12-30') - year(visiting.exit_datetime) - (DATE_FORMAT('2021-12-30', '%m%d') <  DATE_FORMAT(visiting.exit_datetime, '%m%d')) as years
    from visiting
) sub
where years = 0
order by years desc;

select * from time_diff;

-- 11B Most Visιted Spaces Last Year -------------------------------------------------------------------------------------------
create view most_visited as 
select joined.nfc_id, joined.facility_id, facilities.facility_name, Team, months
from (
    select time_diff.nfc_id, custo_age_group.Team, time_diff.facility_id, time_diff.months
    from time_diff
    left join custo_age_group
    on time_diff.nfc_id = custo_age_group.nfc_id
) as joined
left join facilities
on joined.facility_id = facilities.facility_id;

select * from most_visited;

select facility_id, facility_name, visits from (
select facility_id, facility_name, count(nfc_id) as visits, Team from most_visited where months<=12 group by Team, facility_id
) as x
where Team = '20-40';

-- 11C Most Serviced Select + View
create view time_diff_2 as
select nfc_id,service_id, months
from (
	select receiving_services.nfc_id, receiving_services.service_id, month('2021-12-30') - month(receiving_services.charge_date) - (DATE_FORMAT('2021-12-30', '%m%d') <  DATE_FORMAT(receiving_services.charge_date, '%m%d')) as months,
    year('2021-12-30') - year(receiving_services.charge_date) - (DATE_FORMAT('2021-12-30', '%m%d') <  DATE_FORMAT(receiving_services.charge_date, '%m%d')) as years
    from receiving_services
) sub
where years = 0
order by years desc;


-- 11B
select * from time_diff_2;

create view most_serviced as 
select joined.nfc_id, joined.service_id, Team, months, services.service_description
from (
    select time_diff_2.nfc_id, custo_age_group.Team, time_diff_2.service_id, time_diff_2.months
    from time_diff_2
    left join custo_age_group
    on time_diff_2.nfc_id = custo_age_group.nfc_id
) as joined
left join services
on joined.service_id = services.service_id;

select * from most_serviced;

select service_id, service_description, visits from (
select service_id, service_description, count(nfc_id) as visits, Team from most_serviced where months<=12 group by Team, service_id
) as x
where Team = '20-40';

-- 11 C
-- Serviced most
create view serviced_most as 
select distinct(joined.nfc_id), joined.service_id, Team, months, services.service_description
from (
    select time_diff_2.nfc_id, custo_age_group.Team, time_diff_2.service_id, time_diff_2.months
    from time_diff_2
    left join custo_age_group
    on time_diff_2.nfc_id = custo_age_group.nfc_id
) as joined
left join services
on joined.service_id = services.service_id;

select * from serviced_most;

select service_id, service_description, customers from (
select service_id, service_description, count(nfc_id) as customers, Team from serviced_most where months<=12 group by Team, service_id
) as x
where Team = '20-40';