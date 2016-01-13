
CREATE TABLE su (
                su_username VARCHAR(20) NOT NULL,
                su_password VARCHAR(32) NOT NULL,
                su_name VARCHAR(50) NOT NULL,
                su_email VARCHAR(50) NOT NULL,
                PRIMARY KEY (su_username)
);


CREATE TABLE invoice (
                invoice_id VARCHAR(10) NOT NULL,
                period_beginning DATE NOT NULL,
                period_end DATE NOT NULL,
                su_username VARCHAR(20) NOT NULL,
                PRIMARY KEY (invoice_id)
);


CREATE TABLE agent_user (
                agent_username VARCHAR(20) NOT NULL,
                agent_password VARCHAR(32) NOT NULL,
                contact_window_name VARCHAR(50) NOT NULL,
                contact_window_email VARCHAR(50) NOT NULL,
                PRIMARY KEY (agent_username)
);


CREATE TABLE agency (
                agency_id VARCHAR(10) NOT NULL,
                agency_name VARCHAR(50) NOT NULL,
                PRIMARY KEY (agency_id)
);


CREATE TABLE agent (
                agent_id VARCHAR(10) NOT NULL,
                agent_fname VARCHAR(50) NOT NULL,
                agent_lname VARCHAR(50) NOT NULL,
                agent_phone_no VARCHAR(50) NOT NULL,
                agency_id VARCHAR(10) NOT NULL,
                PRIMARY KEY (agent_id)
);


CREATE TABLE branch (
                branch_id VARCHAR(10) NOT NULL,
                branch_name VARCHAR(50) NOT NULL,
                agency_id VARCHAR(10) NOT NULL,
                agent_username VARCHAR(20) NOT NULL,
                PRIMARY KEY (branch_id)
);


CREATE TABLE property (
                property_id VARCHAR(10) NOT NULL,
                no_bed INT NOT NULL,
                no_bath VARCHAR NOT NULL,
                no_car INT,
                no_study INT NOT NULL,
                address VARCHAR(50) NOT NULL,
                price_low INT NOT NULL,
                price_high INT NOT NULL,
                agency_id VARCHAR(10) NOT NULL,
                agent_id VARCHAR(10) NOT NULL,
                PRIMARY KEY (property_id)
);


CREATE TABLE advertisement (
                ad_id VARCHAR(10) NOT NULL,
                ad_title VARCHAR(50) NOT NULL,
                ad_type VARCHAR(50) NOT NULL,
                date_created DATE NOT NULL,
                time_created TIME NOT NULL,
                ins_date_1 DATE NOT NULL,
                ins_date_2 DATE NOT NULL,
                ins_time_1 TIME NOT NULL,
                ins_time_2 TIME NOT NULL,
                auc_date DATE NOT NULL,
                auc_time TIME NOT NULL,
                local_dir VARCHAR(255) NOT NULL,
                property_id VARCHAR(10) NOT NULL,
                su_username VARCHAR(20) NOT NULL,
                invoice_id VARCHAR(10) NOT NULL,
                PRIMARY KEY (ad_id)
);


ALTER TABLE advertisement ADD CONSTRAINT su_advertisement_fk
FOREIGN KEY (su_username)
REFERENCES su (su_username)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE invoice ADD CONSTRAINT su_invoice_fk
FOREIGN KEY (su_username)
REFERENCES su (su_username)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE advertisement ADD CONSTRAINT invoice_advertisement_fk
FOREIGN KEY (invoice_id)
REFERENCES invoice (invoice_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE branch ADD CONSTRAINT agent_user_branch_fk
FOREIGN KEY (agent_username)
REFERENCES agent_user (agent_username)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE property ADD CONSTRAINT agency_property_fk
FOREIGN KEY (agency_id)
REFERENCES agency (agency_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE branch ADD CONSTRAINT agency_branch_fk
FOREIGN KEY (agency_id)
REFERENCES agency (agency_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE agent ADD CONSTRAINT agency_agent_fk
FOREIGN KEY (agency_id)
REFERENCES agency (agency_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE property ADD CONSTRAINT agent_property_fk
FOREIGN KEY (agent_id)
REFERENCES agent (agent_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE advertisement ADD CONSTRAINT property_advertisement_fk
FOREIGN KEY (property_id)
REFERENCES property (property_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;
