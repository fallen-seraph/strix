use strixProducts;

INSERT INTO SERVICES(service_name, command_name, description, available_arguments, argument_one) VALUES ('FTP', 'check_ftp', 'remote check of ftp services over normal ports', '1', 'port');

INSERT INTO SERVICES(service_name, command_name, description, available_arguments, argument_one, argument_two, argument_three) VALUES ('Host Status', 'check-host-alive', 'Check the connectivity of the host', '3', 'warning threshold', 'critical threshold', 'packets')

INSERT INTO SERVICES(service_name, command_name, description, available_arguments, argument_one) VALUES ('Check Apache', 'check_http', 'Checks the status of Apache', '1', 'ip address')

INSERT INTO SERVICES(service_name, command_name, description, available_arguments, argument_one) VALUES ('Check IMAP', 'check_imap', 'Checks the status of incoming email', '1', 'port')

INSERT INTO SERVICES(service_name, command_name, description, available_arguments, argument_one) VALUES ('Check SMTP', 'check_smtp', 'Checks the status of outgoing email', '1', 'port')
