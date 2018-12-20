DROP TABLE IF EXISTS toa_recemail;
CREATE TABLE toa_recemail (
  id int(11) NOT NULL AUTO_INCREMENT,
  subject varchar(255) DEFAULT NULL,
  receuser varchar(16) DEFAULT NULL,
  user varchar(16) DEFAULT NULL,
  appendix text,
  content text,
  type varchar(2) DEFAULT NULL,
  typeid varchar(16) DEFAULT NULL,
  date datetime DEFAULT NULL,
  sendid varchar(16) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS toa_sendmail;
CREATE TABLE toa_sendmail (
  id int(11) NOT NULL AUTO_INCREMENT,
  subject varchar(255) DEFAULT NULL,
  receuser text,
  ccuser text,
  bssuser text,
  webuser text,
  user varchar(16) DEFAULT NULL,
  appendix text,
  content text,
  type varchar(2) DEFAULT NULL,
  date datetime DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS toa_popmail;
CREATE TABLE toa_popmail (
  id int(11) NOT NULL AUTO_INCREMENT,
  pop3 varchar(32) DEFAULT NULL,
  smtp varchar(32) DEFAULT NULL,
  pop3num varchar(16) DEFAULT NULL,
  smtpnum varchar(16) DEFAULT NULL,
  username varchar(32) DEFAULT NULL,
  password varchar(32) DEFAULT NULL,
  mail varchar(64) DEFAULT NULL,
  type varchar(2) DEFAULT NULL,
  uid varchar(16) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS toa_mailsignature;
CREATE TABLE toa_mailsignature (
  id int(11) NOT NULL AUTO_INCREMENT,
  content text,
  uid varchar(16) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS toa_emailtype;
CREATE TABLE toa_emailtype (
  id int(11) NOT NULL AUTO_INCREMENT,
  title varchar(32) DEFAULT NULL,
  number int(11) DEFAULT NULL,
  uid varchar(16) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO toa_menu (menuid, menuname, menuurl, fatherid, menutype, menunum, menukey, keytable) VALUES
(303, 'ÄÚ²¿ÓÊ¼þ', 'admin.php?ac=email&fileurl=email', '3', '0', 2, '0', NULL);