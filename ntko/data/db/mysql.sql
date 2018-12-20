DROP TABLE IF EXISTS toa_ntkohtmlfile;
CREATE TABLE toa_ntkohtmlfile (
  id mediumint(10) NOT NULL AUTO_INCREMENT,
  filename varchar(256) DEFAULT NULL,
  filepath varchar(256) DEFAULT NULL,
  filesize varchar(10) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS toa_ntkoofficefile;
CREATE TABLE toa_ntkoofficefile (
  id mediumint(10) NOT NULL AUTO_INCREMENT,
  filename varchar(256) DEFAULT NULL,
  filesize mediumint(10) DEFAULT NULL,
  otherdata varchar(128) DEFAULT NULL,
  filetype varchar(64) DEFAULT NULL,
  filenamedisk varchar(256) DEFAULT NULL,
  attachfilenamedisk varchar(256) DEFAULT NULL,
  attachfiledescribe varchar(256) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS toa_ntkopdffile;
CREATE TABLE toa_ntkopdffile (
  id mediumint(10) NOT NULL AUTO_INCREMENT,
  pdffilename varchar(256) DEFAULT NULL,
  pdffilepath varchar(256) DEFAULT NULL,
  filesize varchar(256) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;
INSERT INTO toa_menu (menuid, menuname, menuurl, fatherid, menutype, menunum, menukey,keytable) VALUES
(235, '印鉴管理', 'admin.php?ac=seal&fileurl=member', '57', '2', 5, '0', ''),
(236, '红头文件管理', 'admin.php?ac=hongtou&fileurl=member', '57', '2', 999, '0', '');
INSERT INTO toa_ntkoofficefile (id, filename, filesize, otherdata, filetype, filenamedisk, attachfilenamedisk, attachfiledescribe) VALUES
(5, 'Tscx178888.doc', 54784, '', 'Word.Document', 'Tscx178888.doc', '', ''),
(4, 'Tscx118892.xls', 17920, '', 'Excel.Sheet', 'Tscx118892.xls', '', ''),
(3, 'Tscx128893.xls', 19968, '', 'Excel.Sheet', 'Tscx128893.xls', '', ''),
(2, 'Tscx128894.xls', 18944, '', 'Excel.Sheet', 'Tscx128894.xls', '', ''),
(1, 'Tscx198900.xls', 17920, '', 'Excel.Sheet', 'Tscx198900.xls', '', '');
INSERT INTO toa_fileoffice (id, number, fileid, filetype, officetype, officeid, filename, fileaddr, uid, date) VALUES
(1, 'Tscx198900', '1', '1', '50', NULL, 'Tscx198900.xls', NULL, '1', '2015-02-22 16:35:59'),
(2, 'Tscx128894', '2', '1', '50', NULL, 'Tscx128894.xls', NULL, '1', '2015-02-22 16:35:59'),
(3, 'Tscx128893', '3', '1', '50', NULL, 'Tscx128893.xls', NULL, '1', '2015-02-22 16:45:16'),
(4, 'Tscx118892', '4', '1', '50', NULL, 'Tscx118892.xls', NULL, '1', '2015-02-22 16:48:22'),
(5, 'Tscx178888', '5', '1', '50', NULL, 'Tscx178888.doc', NULL, '1', '2015-02-22 16:49:25');
