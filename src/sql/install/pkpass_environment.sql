DELIMITER ;
CREATE TABLE IF NOT EXISTS `pkpass_environment` (
  `id` varchar(255) NOT NULL,
  `val` longtext NOT NULL,
  PRIMARY KEY (`id`)
);

insert ignore into pkpass_environment (id, val) values ('apple_certificate', '');
insert ignore into pkpass_environment (id, val) values ('apple_wwdr_certificate', '');
insert ignore into pkpass_environment (id, val) values ('apple_cert_pass', '');
insert ignore into pkpass_environment (id, val) values ('apple_passTypeIdentifier', '');
insert ignore into pkpass_environment (id, val) values ('apple_organizationName', '');
insert ignore into pkpass_environment (id, val) values ('apple_teamIdentifier', '');
insert ignore into pkpass_environment (id, val) values ('apple_logoText', '');
insert ignore into pkpass_environment (id, val) values ('apple_backFieldsLabel', '');


insert ignore into pkpass_environment (id, val) values ('apple_icon', '');
insert ignore into pkpass_environment (id, val) values ('apple_icon2x', '');
insert ignore into pkpass_environment (id, val) values ('apple_logo', '');
insert ignore into pkpass_environment (id, val) values ('apple_strip', '');



