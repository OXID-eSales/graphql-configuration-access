SET @@session.sql_mode = '';

REPLACE INTO `oxuser` (`OXID`, `OXACTIVE`, `OXRIGHTS`, `OXSHOPID`, `OXUSERNAME`, `OXPASSWORD`, `OXPASSSALT`, `OXCUSTNR`, `OXUSTID`, `OXUSTIDSTATUS`, `OXCOMPANY`, `OXFNAME`, `OXLNAME`, `OXSTREET`, `OXSTREETNR`, `OXADDINFO`, `OXCITY`, `OXCOUNTRYID`, `OXSTATEID`, `OXZIP`, `OXFON`, `OXFAX`, `OXSAL`, `OXBONI`, `OXCREATE`, `OXREGISTER`, `OXPRIVFON`, `OXMOBFON`, `OXBIRTHDATE`, `OXURL`, `OXWRONGLOGINS`, `OXUPDATEKEY`, `OXUPDATEEXP`, `OXPOINTS`, `OXTIMESTAMP`) VALUES
('4d7a345d24356293cc79b426e6d2c2a6',	1,	'malladmin',	1,	'noreply@oxid-esales.com',	'$2y$10$2JhjaEzBWE1/CbPtgW8CDuXw0pRllIhd50PjFNWsSmGXbh7lrOty6',	'',	1,	'',	0,	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	0,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'',	'0000-00-00',	'',	0,	'',	0,	0,	'2023-09-13 14:33:18'),
('01ba0f60-bd8e-4c01-bcf6-aa457bcb',	1,	'user',	1,	'JanvierJaimesVelasquez@cuvox.de',	'$2y$10$xHmv1FlZeE655s8FlZK47ekriYyj81dpq0lrYxVIFLGH2YzovWTXq',	'',	2,	'',	0,	'Omni Realty',	'Janvier',	'Jaimes',	'Wilkinson Street',	'2215',	'',	'Springfield',	'8f241f11096877ac0.98748826',	'',	'37172',	'615-384-2150',	'',	'MR',	1000,	'2023-03-15 08:53:42',	'2023-03-15 08:53:42',	'',	'',	'1998-06-17',	'',	0,	'',	0,	0,	'2023-03-15 08:55:52');

REPLACE INTO `oxgroups` (`OXID`, `OXRRID`, `OXACTIVE`, `OXTITLE`, `OXTITLE_1`, `OXTITLE_2`, `OXTITLE_3`, `OXTIMESTAMP`) VALUES
('oxidadmin',	9,	1,	'Shop-Admin',	'Store Administrator',	'',	'',	'2023-04-26 10:13:29'),
('oxidcustomer',	14,	1,	'Kunde',	'Customer',	'',	'',	'2023-04-26 10:13:29');

INSERT INTO `oxconfig` (`OXID`, `OXSHOPID`, `OXMODULE`, `OXVARNAME`, `OXVARTYPE`, `OXVARVALUE`, `OXTIMESTAMP`) VALUES
    ('9f1a3b09f9a9b03310448127c127fb33',	1,	'module:oe_graphql_configuration_access',	'iTestConfiguration',	'int',	'999',	'2023-01-31 09:52:22');
