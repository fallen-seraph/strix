use strixProducts;

INSERT INTO products(
product_id, product_name, cost
) VALUES (
'0521345', 'web_glance_gander', '50.00'
);

INSERT INTO products(
product_id, product_name, cost
) VALUES (
'55346', 'web_glance_gaze', '29.99'
);

INSERT INTO products(
product_id, product_name, cost
) VALUES (
'553163', 'consulting', '1293.20'
);

use strixdb;

INSERT INTO account_information(
first_name, last_name, account_type, service, email, phone, address_one, city, state, zip, country
) VALUES (
'lucille', 'fuhrman', 'web_glance_gander', '1', 'lucillecfuhrman@inbound.plus', '111-222-3333', '1445 Prudence Street', 'Dearborn', 'MI', '48124', 'United States'
);

INSERT INTO account_information(
first_name, last_name, account_type, service, email, phone, address_one, address_two, city, state, zip, country
) VALUES (
'john', 'minor', 'web_glance_gaze', '1', 'johnmminor@inbound.plus', '817-457-4831', '4026 Waldeck Street', 'Apt 2A', 'Fort Worth', 'TX', '76112', 'United States'
);

INSERT INTO billing_information(
account_id, first_name, last_name, email, address_one, city, state, zip, country, preferred_payment_type, paypal
) VALUES (
'1', 'Lucille', 'Fuhrman', 'lucillecfuhrman@inbound.plus', '1445 Prudence Street', 'Dearborn', 'MI', '48124', 'United States', '1', '1'
);

INSERT INTO billing_information(
account_id, first_name, last_name, email, address_one, city, state, zip, country, preferred_payment_type, paypal, cc_num, cc_num_last_four, cc_exp, cc_sec_code
) VALUES (
'1', 'Lucille', 'Fuhrman', 'lucillecfuhrman@inbound.plus', '1445 Prudence Street', 'Dearborn', 'MI', '48124', 'United States', '1', '0', '4485886586914093', '4093', '5/2020', '578'
);

INSERT INTO billing_information(
account_id, first_name, last_name, email, address_one, address_two, city, state, zip, country, preferred_payment_type, paypal
) VALUES (
'2', 'John', 'Minor', 'johnmminor@inbound.plus', '4026 Waldeck Street', 'Apt 2A', 'Fort Worth', 'TX', '76112', 'United States', '1', '1'
);

INSERT INTO users(
account_id, username, email, password
) VALUES (
'1', 'lucillecfuhrman', 'lucillecfuhrman@inbound.plus', 'password'
);

INSERT INTO users(
account_id, username, email, password
) VALUES (
'2', 'johnmminor', 'johnmminor@inbound.plus', 'password'
);

INSERT INTO invoices(
account_id, invoice_status, due_date, total
) VALUES (
'1', 'paid', 'DATE()', '100.00'
);

INSERT INTO invoices(
account_id, invoice_status, due_date, total
) VALUES (
'2', 'unpaid', 'DATE()', '500.00'
);

INSERT INTO invoice_items(
account_id, invoice_number, line_number, product_id
) VALUES (
'1', '1', '1', '0521345'
);

INSERT INTO invoice_items(
account_id, invoice_number, line_number, product_id
) VALUES (
'2', '2', '1', '55346'
);

INSERT INTO invoice_items(
account_id, invoice_number, line_number, product_id
) VALUES (
'2', '2', '2', '553163'
);

use nagidb;

INSERT INTO nagios_contact(
account_id, contact_id, contact_name, alias, contact_groups, email, phone, receive
) VALUES (
'1', '1', '1_1_lucille', 'lucille', '1_1_group_alpha', 'lucillecfuhrman@inbound.plus', 111-222-3333, '1'
);

INSERT INTO nagios_contact(
account_id, contact_id, contact_name, alias, contact_groups, email, phone, misc, receive
) VALUES (
'1', '2', '1_2_kevin', 'kevin', '1_2_group_beta', 'spacey.space@inbound.plus', 111-333-4444, 'lucillecfuhrman@inbound.plus', '1'
);

INSERT INTO nagios_contact(
account_id, contact_id, contact_name, alias, contact_groups, email, phone, misc, receive
) VALUES (
'2', '1', '2_1_john', 'john', '2_1_group_beta', 'johnmminor@inbound.plus', 333-444-5555, 666-777-8888, '1'
);

INSERT INTO nagios_contact_group(
account_id, group_id, contact_group_name, alias, members
) VALUES (
'1', '1', '1_1_group_alpha', 'group_alpha', '1_1_lucille'
);

INSERT INTO nagios_contact_group(
account_id, group_id, contact_group_name, alias, members
) VALUES (
'1', '2', '1_2_group_beta', 'group_beta', '1_2_kevin'
);

INSERT INTO nagios_contact_group(
account_id, group_id, contact_group_name, alias, members
) VALUES (
'2', '1', '2_1_group_beta', 'group_beta', 'john'
);

INSERT INTO nagios_host(
account_id, host_id, host_name, alias, address, contact_groups
) VALUES (
'1', '1', 'host.localhost.net', 'junkHost for Testing', '123.123.123.123', '1_1_group_alpha\, 1_2_group_beta'
);

INSERT INTO nagios_host(
account_id, host_id, host_name, alias, address, contacts
) VALUES (
'1', '2', 'host2.localhost.net', 'junkHost2 for Testing', '111.222.333.444', '1_1_lucille'
);

INSERT INTO nagios_host(
account_id, host_id, host_name, alias, address, contact_groups
) VALUES (
'2', '1', 'john.localhost.net', 'johns_Host for Testing', '127.0.0.1', '2_1_group_beta'
);

INSERT INTO nagios_host_services(
account_id, host_id, service_num, host_name, service_description, check_command, contacts
) VALUES (
'1', '1', '1', 'host.localhost.net', 'stupid_desc_here', 'check_ping','101_lucille'
);

INSERT INTO nagios_host_services(
account_id, host_id, service_num, host_name, service_description, check_command, contact_groups
) VALUES (
'1', '1', '2', 'host.localhost.net', 'stupid_desc_here', 'check_pop', '101_group_alpha'
);

INSERT INTO nagios_host_services(
account_id, host_id, service_num, host_name, service_description, check_command, contact_groups
) VALUES (
'1', '2', '1', 'host2.localhost.net', 'stupid_desc_here', 'check_ping', '201_group_beta'
);

INSERT INTO nagios_host_services(
account_id, host_id, service_num, host_name, service_description, check_command, contacts, contact_groups
) VALUES (
'2', '1', '1', 'john.localhost.net', 'stupid_desc here', 'check_pop', '2_1_john', '2_1_group_beta'
);

