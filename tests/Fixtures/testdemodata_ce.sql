SET @@session.sql_mode = '';

REPLACE INTO `oxuser` (`OXID`, `OXACTIVE`, `OXRIGHTS`, `OXSHOPID`, `OXUSERNAME`, `OXPASSWORD`, `OXPASSSALT`, `OXCUSTNR`, `OXUSTID`, `OXUSTIDSTATUS`, `OXCOMPANY`, `OXFNAME`, `OXLNAME`, `OXSTREET`, `OXSTREETNR`, `OXADDINFO`, `OXCITY`, `OXCOUNTRYID`, `OXSTATEID`, `OXZIP`, `OXFON`, `OXFAX`, `OXSAL`, `OXBONI`, `OXCREATE`, `OXREGISTER`, `OXPRIVFON`, `OXMOBFON`, `OXBIRTHDATE`, `OXURL`, `OXWRONGLOGINS`, `OXUPDATEKEY`, `OXUPDATEEXP`, `OXPOINTS`, `OXTIMESTAMP`) VALUES
('4d7a345d24356293cc79b426e6d2c2a6',	1,	'malladmin',	1,	'noreply@oxid-esales.com',	'$2y$10$2JhjaEzBWE1/CbPtgW8CDuXw0pRllIhd50PjFNWsSmGXbh7lrOty6',	'',	1,	'',	0,	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	0,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'',	'',	'0000-00-00',	'',	0,	'',	0,	0,	'2023-09-13 14:33:18'),
('01ba0f60-bd8e-4c01-bcf6-aa457bcb',	1,	'user',	1,	'JanvierJaimesVelasquez@cuvox.de',	'$2y$10$xHmv1FlZeE655s8FlZK47ekriYyj81dpq0lrYxVIFLGH2YzovWTXq',	'',	2,	'',	0,	'Omni Realty',	'Janvier',	'Jaimes',	'Wilkinson Street',	'2215',	'',	'Springfield',	'8f241f11096877ac0.98748826',	'',	'37172',	'615-384-2150',	'',	'MR',	1000,	'2023-03-15 08:53:42',	'2023-03-15 08:53:42',	'',	'',	'1998-06-17',	'',	0,	'',	0,	0,	'2023-03-15 08:55:52');

REPLACE INTO `oxgroups` (`OXID`, `OXRRID`, `OXACTIVE`, `OXTITLE`, `OXTITLE_1`, `OXTITLE_2`, `OXTITLE_3`, `OXTIMESTAMP`) VALUES
('oxidadmin',	9,	1,	'Shop-Admin',	'Store Administrator',	'',	'',	'2023-04-26 10:13:29'),
('oxidcustomer',	14,	1,	'Kunde',	'Customer',	'',	'',	'2023-04-26 10:13:29');

REPLACE INTO `oxobject2group` (`OXID`, `OXSHOPID`, `OXOBJECTID`, `OXGROUPSID`, `OXTIMESTAMP`) VALUES
('d687174433046c8b3b9bf114c3aa0830',	1,	'4d7a345d24356293cc79b426e6d2c2a6',	'oxidadmin',	'2023-09-27 14:40:01'),
('d687174433046c8b3b9bf114c3aa0831',	1,	'01ba0f60-bd8e-4c01-bcf6-aa457bcb',	'oxidcustomer',	'2023-09-27 14:40:01');

REPLACE INTO `oxconfig` (`OXID`, `OXSHOPID`, `OXMODULE`, `OXVARNAME`, `OXVARTYPE`, `OXVARVALUE`, `OXTIMESTAMP`) VALUES
('_intSetting',	1,	'theme:awesomeTheme',	'intSetting',	'num',	'123',	'2023-10-13 08:26:19'),
('_floatSetting',	1,	'theme:awesomeTheme',	'floatSetting',	'num',	'1.23',	'2023-10-13 08:26:19'),
('_boolSetting',	1,	'theme:awesomeTheme',	'boolSetting',	'bool',	'',	'2023-10-13 08:26:19'),
('_stringSetting',	1,	'theme:awesomeTheme',	'stringSetting',	'str',	'default',	'2023-10-13 08:26:19'),
('_selectSetting',	1,	'theme:awesomeTheme',	'selectSetting',	'select',	'selectString',	'2023-10-13 08:26:19'),
('_arraySetting',	1,	'theme:awesomeTheme',	'arraySetting',	'arr',	'a:4:{i:0;s:2:"10";i:1;s:2:"20";i:2;s:2:"50";i:3;s:3:"100";}',	'2023-10-13 08:26:19'),
('_aarraySetting',	1,	'theme:awesomeTheme',	'aarraySetting',	'aarr',	'a:3:{s:5:"first";s:2:"10";s:6:"second";s:2:"20";s:5:"third";s:2:"50";}',	'2023-10-13 08:26:19');
