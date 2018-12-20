DROP TABLE IF EXISTS toa_crm_business;
CREATE TABLE toa_crm_business (
  id int(11) NOT NULL AUTO_INCREMENT,
  number varchar(64) DEFAULT NULL,
  title varchar(255) DEFAULT NULL,
  user varchar(16) DEFAULT NULL,
  bid varchar(16) DEFAULT NULL,
  price varchar(16) DEFAULT NULL,
  username varchar(32) DEFAULT NULL,
  password varchar(32) DEFAULT NULL,
  type varchar(2) DEFAULT NULL,
  date datetime DEFAULT NULL,
  uid varchar(16) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS toa_crm_care;
CREATE TABLE toa_crm_care (
  id int(10) NOT NULL AUTO_INCREMENT,
  title varchar(64) DEFAULT NULL,
  cid varchar(16) DEFAULT NULL,
  number varchar(64) DEFAULT NULL,
  user varchar(16) DEFAULT NULL,
  smsdate varchar(16) DEFAULT NULL,
  type varchar(2) DEFAULT NULL,
  date datetime DEFAULT NULL,
  uid varchar(16) DEFAULT NULL,
  type2 varchar(2) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS toa_crm_company;
CREATE TABLE toa_crm_company (
  id int(10) NOT NULL AUTO_INCREMENT,
  number varchar(64) DEFAULT NULL,
  title varchar(255) DEFAULT NULL,
  user varchar(16) DEFAULT NULL,
  bid varchar(16) DEFAULT NULL,
  date datetime DEFAULT NULL,
  uid varchar(16) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS toa_crm_complaints;
CREATE TABLE toa_crm_complaints (
  id int(10) NOT NULL AUTO_INCREMENT,
  title varchar(255) DEFAULT NULL,
  cid varchar(16) DEFAULT NULL,
  number varchar(64) DEFAULT NULL,
  user varchar(16) DEFAULT NULL,
  comdate varchar(16) DEFAULT NULL,
  type varchar(2) DEFAULT NULL,
  date datetime DEFAULT NULL,
  uid varchar(16) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS toa_crm_contact;
CREATE TABLE toa_crm_contact (
  id int(10) NOT NULL AUTO_INCREMENT,
  name varchar(64) DEFAULT NULL,
  cid varchar(16) DEFAULT NULL,
  type varchar(2) DEFAULT NULL,
  date datetime DEFAULT NULL,
  uid varchar(16) DEFAULT NULL,
  type1 varchar(2) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS toa_crm_contract;
CREATE TABLE toa_crm_contract (
  id int(11) NOT NULL AUTO_INCREMENT,
  number varchar(64) DEFAULT NULL,
  cid varchar(16) DEFAULT NULL,
  title varchar(255) DEFAULT NULL,
  cname varchar(255) DEFAULT NULL,
  price varchar(16) DEFAULT NULL,
  oid varchar(16) DEFAULT NULL,
  date datetime DEFAULT NULL,
  uid varchar(16) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS toa_crm_db;
CREATE TABLE toa_crm_db (
  did int(11) NOT NULL AUTO_INCREMENT,
  inputname varchar(64) DEFAULT NULL,
  content text,
  type varchar(32) DEFAULT NULL,
  viewid varchar(16) DEFAULT NULL,
  formid varchar(16) DEFAULT NULL,
  PRIMARY KEY (did)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS toa_crm_flow;
CREATE TABLE toa_crm_flow (
  fid int(11) NOT NULL AUTO_INCREMENT,
  flowname varchar(64) DEFAULT NULL,
  flownum varchar(2) DEFAULT NULL,
  flowuser varchar(128) DEFAULT NULL,
  modid varchar(32) DEFAULT NULL,
  flowkey varchar(2) DEFAULT NULL,
  flowkey1 varchar(2) DEFAULT NULL,
  flowkey2 varchar(2) DEFAULT NULL,
  flowkey3 varchar(2) DEFAULT NULL,
  PRIMARY KEY (fid)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS toa_crm_form;
CREATE TABLE toa_crm_form (
  fid int(11) NOT NULL AUTO_INCREMENT,
  formname varchar(128) DEFAULT NULL,
  inputname varchar(64) DEFAULT NULL,
  type varchar(2) DEFAULT NULL,
  inputvalue varchar(128) DEFAULT NULL,
  inputtype varchar(2) DEFAULT NULL,
  inputvaluenum text,
  confirmation varchar(2) DEFAULT NULL,
  type1 varchar(32) DEFAULT NULL,
  type2 varchar(2) DEFAULT NULL,
  inputnumber int(11) DEFAULT NULL,
  w int(11) DEFAULT NULL,
  h int(11) DEFAULT NULL,
  PRIMARY KEY (fid)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS toa_crm_log;
CREATE TABLE toa_crm_log (
  id int(11) NOT NULL AUTO_INCREMENT,
  viewid varchar(16) DEFAULT NULL,
  uid varchar(16) DEFAULT NULL,
  content2 text,
  content1 text,
  type varchar(2) DEFAULT NULL,
  date datetime DEFAULT NULL,
  title varchar(128) DEFAULT NULL,
  modid varchar(64) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS toa_crm_offer;
CREATE TABLE toa_crm_offer (
  id int(11) NOT NULL AUTO_INCREMENT,
  number varchar(64) DEFAULT NULL,
  cid varchar(16) DEFAULT NULL,
  price varchar(16) DEFAULT NULL,
  title varchar(255) DEFAULT NULL,
  cname varchar(255) DEFAULT NULL,
  date datetime DEFAULT NULL,
  uid varchar(16) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS toa_crm_order;
CREATE TABLE toa_crm_order (
  id int(11) NOT NULL AUTO_INCREMENT,
  number varchar(64) DEFAULT NULL,
  cid varchar(16) DEFAULT NULL,
  title varchar(255) DEFAULT NULL,
  cname varchar(255) DEFAULT NULL,
  price varchar(16) DEFAULT NULL,
  oid varchar(16) DEFAULT NULL,
  date datetime DEFAULT NULL,
  uid varchar(16) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS toa_crm_payment;
CREATE TABLE toa_crm_payment (
  id int(11) NOT NULL AUTO_INCREMENT,
  number varchar(64) DEFAULT NULL,
  sid varchar(16) DEFAULT NULL,
  perid varchar(16) DEFAULT NULL,
  price varchar(16) DEFAULT NULL,
  title varchar(255) DEFAULT NULL,
  sname varchar(255) DEFAULT NULL,
  date datetime DEFAULT NULL,
  uid varchar(16) DEFAULT NULL,
  user varchar(16) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS toa_crm_personnel;
CREATE TABLE toa_crm_personnel (
  perid int(11) NOT NULL AUTO_INCREMENT,
  name varchar(32) DEFAULT NULL,
  uid varchar(16) DEFAULT NULL,
  designationdate datetime DEFAULT NULL,
  approvaldate datetime DEFAULT NULL,
  lnstructions varchar(255) DEFAULT NULL,
  pertype varchar(2) DEFAULT NULL,
  viewid varchar(16) DEFAULT NULL,
  modid varchar(32) DEFAULT NULL,
  flowid varchar(16) DEFAULT NULL,
  appkey varchar(2) DEFAULT NULL,
  appkey1 varchar(2) DEFAULT NULL,
  PRIMARY KEY (perid)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS toa_crm_personnel_log;
CREATE TABLE toa_crm_personnel_log (
  lid int(11) NOT NULL AUTO_INCREMENT,
  name varchar(32) DEFAULT NULL,
  uid varchar(16) DEFAULT NULL,
  approvaldate datetime DEFAULT NULL,
  lnstructions varchar(255) DEFAULT NULL,
  pertype varchar(2) DEFAULT NULL,
  perid varchar(16) DEFAULT NULL,
  viewid varchar(16) DEFAULT NULL,
  modid varchar(32) DEFAULT NULL,
  PRIMARY KEY (lid)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS toa_crm_pord_type;
CREATE TABLE toa_crm_pord_type (
  id int(10) NOT NULL AUTO_INCREMENT,
  title varchar(255) DEFAULT NULL,
  father varchar(16) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS toa_crm_price;
CREATE TABLE toa_crm_price (
  id int(11) NOT NULL AUTO_INCREMENT,
  number varchar(64) DEFAULT NULL,
  cid varchar(16) DEFAULT NULL,
  user varchar(16) DEFAULT NULL,
  price varchar(16) DEFAULT NULL,
  title varchar(255) DEFAULT NULL,
  type varchar(2) DEFAULT NULL,
  viewid varchar(16) DEFAULT NULL,
  cname varchar(255) DEFAULT NULL,
  date datetime DEFAULT NULL,
  uid varchar(16) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS toa_crm_product;
CREATE TABLE toa_crm_product (
  id int(10) NOT NULL AUTO_INCREMENT,
  number varchar(255) DEFAULT NULL,
  title varchar(255) DEFAULT NULL,
  price varchar(255) DEFAULT NULL,
  type varchar(255) DEFAULT NULL,
  date datetime DEFAULT NULL,
  uid varchar(10) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS toa_crm_prod_view;
CREATE TABLE toa_crm_prod_view (
  id int(11) NOT NULL AUTO_INCREMENT,
  pid varchar(16) DEFAULT NULL,
  price varchar(16) DEFAULT NULL,
  number varchar(16) DEFAULT NULL,
  unit varchar(16) DEFAULT NULL,
  viewid varchar(255) DEFAULT NULL,
  type varchar(2) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS toa_crm_program;
CREATE TABLE toa_crm_program (
  id int(11) NOT NULL AUTO_INCREMENT,
  number varchar(64) DEFAULT NULL,
  cid varchar(16) DEFAULT NULL,
  title varchar(255) DEFAULT NULL,
  cname varchar(255) DEFAULT NULL,
  date datetime DEFAULT NULL,
  uid varchar(16) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS toa_crm_purchase;
CREATE TABLE toa_crm_purchase (
  id int(11) NOT NULL AUTO_INCREMENT,
  number varchar(64) DEFAULT NULL,
  user varchar(16) DEFAULT NULL,
  pricenum varchar(16) DEFAULT NULL,
  sid varchar(16) DEFAULT NULL,
  title varchar(255) DEFAULT NULL,
  sname varchar(255) DEFAULT NULL,
  date datetime DEFAULT NULL,
  uid varchar(16) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS toa_crm_service;
CREATE TABLE toa_crm_service (
  id int(10) NOT NULL AUTO_INCREMENT,
  cid varchar(16) DEFAULT NULL,
  startdate varchar(16) DEFAULT NULL,
  enddate varchar(16) DEFAULT NULL,
  user varchar(16) DEFAULT NULL,
  number varchar(64) DEFAULT NULL,
  date datetime DEFAULT NULL,
  uid varchar(16) DEFAULT NULL,
  title varchar(255) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS toa_crm_stock;
CREATE TABLE toa_crm_stock (
  id int(11) NOT NULL AUTO_INCREMENT,
  stocknum varchar(32) DEFAULT NULL,
  pid varchar(16) DEFAULT NULL,
  unit varchar(32) DEFAULT NULL,
  type varchar(2) DEFAULT NULL,
  number varchar(64) DEFAULT NULL,
  date datetime DEFAULT NULL,
  uid varchar(16) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS toa_crm_supplier;
CREATE TABLE toa_crm_supplier (
  id int(11) NOT NULL AUTO_INCREMENT,
  user varchar(16) DEFAULT NULL,
  title varchar(255) DEFAULT NULL,
  number varchar(64) DEFAULT NULL,
  date datetime DEFAULT NULL,
  uid varchar(16) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

INSERT INTO toa_crm_form (fid, formname, inputname, type, inputvalue, inputtype, inputvaluenum, confirmation, type1, type2, inputnumber, w, h) VALUES
(183, '�����˺�', 'toa_crm_company5031_130707152058', '0', '', '1', '', '2', 'crm_company', '0', 14, 0, 0),
(182, '��������', 'toa_crm_company0773_130707152050', '0', '', '1', '', '2', 'crm_company', '0', 13, 0, 0),
(181, '������', 'toa_crm_company8222_130707152032', '0', '', '1', '', '2', 'crm_company', '0', 12, 0, 0),
(180, '��ҵ����', 'toa_crm_company3983_130707151936', '0', '', '1', '', '2', 'crm_company', '0', 7, 0, 0),
(175, '������ҵ', 'toa_crm_company5608_130707151553', '0', '', '5', '����/����/����/����/����\r\n|��е�豸/ͨ���㲿��\r\n|�ճ�����\r\n|��֯/Ƥ��/��װ/Ьñ\r\n|�Ҿ�/������Ʒ/ʳƷ\r\n|ͨ��/����/�����/����\r\n|ҽ�Ʊ���/��ḣ��\r\n|���ӵ���/�����Ǳ�\r\n|����/����/֤ȯ/Ͷ��\r\n|��ͨ����/�����豸\r\n|�ǽ�/����/����/װ�� \r\n|ʯ�ͻ���/������\r\n|�ӱ��۾�/����Ʒ/��Ʒ \r\n|��ֽ/ֽƷ/ӡˢ/��װ \r\n|����/����/����/���� \r\n|ũ������ \r\n|���/��չ/����칫/��ѯҵ \r\n|ұ��ұ��/�������ǽ�����Ʒ\r\n|ó��/����/�г� \r\n|��������/�������', '2', 'crm_company', '0', 6, 0, 0),
(184, '��ϸ����', 'toa_crm_company9083_130707152329', '0', '', '2', '', '2', 'crm_company', '0', 999, 0, 0),
(173, '�ͻ�״̬', 'toa_crm_company3538_130707151232', '0', '', '5', 'Ǳ�ڿͻ�|����ͻ�|ʧЧ�ͻ�|���ɽ��ͻ�|VIP�ͻ�', '2', 'crm_company', '1', 1, 0, 0),
(179, 'ע���ַ', 'toa_crm_company3337_130707151924', '0', '', '1', '', '2', 'crm_company', '0', 10, 0, 0),
(178, 'ע���ʱ�', 'toa_crm_company1407_130707151913', '0', '', '1', '', '2', 'crm_company', '0', 8, 0, 0),
(177, '����ʱ��', 'toa_crm_company0785_130707151846', '3', '', '1', '', '2', 'crm_company', '0', 9, 0, 0),
(176, '��˾��վ', 'toa_crm_company3616_130707151643', '0', '', '1', '', '2', 'crm_company', '0', 11, 0, 0),
(172, '�ͻ��ȼ�', 'toa_crm_company8701_130707151018', '0', '', '3', 'һ��|����|����|����|����', '2', 'crm_company', '1', 2, 0, 0),
(171, '�ͻ���Դ', 'toa_crm_company9793_130707150911', '0', '', '5', '�绰����|���ѽ���|����ƹ�|��������|�����|�����б�|������|�ͻ�����|������', '2', 'crm_company', '0', 3, 0, 0),
(174, '��������', 'toa_crm_company4128_130707151505', '0', '', '1', '', '2', 'crm_company', '0', 5, 0, 0),
(170, '�ͻ����', 'toa_crm_company8860_130707150634', '0', '', '3', '��ҵ�ͻ�|���˿ͻ�', '2', 'crm_company', '0', 4, 0, 0),
(152, '��Ʒ�ͺ�', 'toa_crm_product9202_130707144537', '0', '', '1', '', '2', 'crm_product', '0', 1, 0, 0),
(153, '������λ', 'toa_crm_product7824_130707144603', '0', '', '5', '̨|��|ֻ|��|����|��|��|��|��|��|��', '2', 'crm_product', '1', 2, 0, 0),
(154, '��������', 'toa_crm_product4814_130707144618', '0', '', '1', '', '2', 'crm_product', '0', 4, 0, 0),
(155, '����', 'toa_crm_product7603_130707144628', '0', '', '1', '', '2', 'crm_product', '0', 3, 0, 0),
(156, '��ƷͼƬ', 'toa_crm_product6674_130707144638', '1', '', '1', '', '2', 'crm_product', '0', 5, 0, 0),
(157, '��ϸ����', 'toa_crm_product8295_130707144653', '0', '', '2', '', '2', 'crm_product', '0', 7, 0, 0),
(158, '��Ʒ����', 'toa_crm_product5070_130707144824', '2', '', '1', '', '2', 'crm_product', '0', 6, 0, 0),
(159, '�Ա�', 'toa_crm_contact4876_130707145252', '0', '', '3', '��|Ů', '2', 'crm_contact', '1', 1, 0, 0),
(160, '����', 'toa_crm_contact8440_130707145325', '3', '', '1', '', '2', 'crm_contact', '0', 2, 0, 0),
(161, '�ֻ�', 'toa_crm_contact9124_130707145346', '0', '', '1', '', '2', 'crm_contact', '1', 4, 0, 0),
(162, '�칫�绰', 'toa_crm_contact1165_130707145357', '0', '', '1', '', '2', 'crm_contact', '1', 5, 0, 0),
(163, 'ְ��', 'toa_crm_contact8466_130707145412', '0', '', '1', '', '2', 'crm_contact', '1', 3, 0, 0),
(164, '����', 'toa_crm_contact4245_130707145421', '0', '', '1', '', '2', 'crm_contact', '0', 6, 0, 0),
(165, 'QQ/MSN', 'toa_crm_contact3648_130707145439', '0', '', '1', '', '2', 'crm_contact', '0', 7, 0, 0),
(166, '����', 'toa_crm_contact8837_130707145451', '0', '', '1', '', '2', 'crm_contact', '1', 8, 0, 0),
(167, '�ʱ�', 'toa_crm_contact9436_130707145500', '0', '', '1', '', '2', 'crm_contact', '0', 9, 0, 0),
(168, '��ַ', 'toa_crm_contact6338_130707145511', '0', '', '1', '', '2', 'crm_contact', '0', 10, 0, 0),
(169, '��ע', 'toa_crm_contact9839_130707145550', '0', '', '2', '', '2', 'crm_contact', '0', 11, 0, 0),
(185, '�ط�Ŀ��', 'toa_crm_service5957_130707153242', '0', '', '2', '', '2', 'crm_service', '0', 999, 0, 0),
(186, '�طý������', 'toa_crm_service1649_130707153314', '0', '', '2', '', '2', 'crm_service', '0', 999, 0, 0),
(187, '�ػ�����', 'toa_crm_care6461_130707153428', '0', '', '2', '', '2', 'crm_care', '0', 3, 0, 0),
(188, '�ػ�����', 'toa_crm_care7981_130707153549', '0', '', '5', '����|����|����', '2', 'crm_care', '1', 1, 0, 0),
(189, '�ػ���ʽ', 'toa_crm_care9689_130707153623', '0', '', '1', '', '2', 'crm_care', '0', 2, 0, 0),
(190, '��ע', 'toa_crm_care4970_130707153630', '0', '', '2', '', '2', 'crm_care', '0', 4, 0, 0),
(191, 'Ͷ������', 'toa_crm_complaints2557_130707153839', '0', '', '5', '��ƷͶ��|�ۺ�Ͷ��|��������', '2', 'crm_complaints', '1', 999, 0, 0),
(192, 'Ͷ�߷�ʽ', 'toa_crm_complaints8348_130707154007', '0', '', '5', '����|�绰|����|����|QQ|����|��վ', '2', 'crm_complaints', '0', 999, 0, 0),
(193, '����״̬', 'toa_crm_complaints5024_130707154054', '0', '', '3', '������|������|������', '2', 'crm_complaints', '1', 999, 0, 0),
(194, '����״̬', 'toa_crm_complaints3652_130707154131', '0', '', '3', '��|����|�ǳ���', '2', 'crm_complaints', '0', 999, 0, 0),
(195, 'Ͷ������', 'toa_crm_complaints1143_130707154150', '0', '', '2', '', '2', 'crm_complaints', '0', 999, 0, 0),
(196, '��������', 'toa_crm_complaints1197_130707154201', '0', '', '2', '', '2', 'crm_complaints', '0', 999, 0, 0),
(197, '��ע', 'toa_crm_complaints8873_130707154211', '0', '', '2', '', '2', 'crm_complaints', '0', 999, 0, 0),
(198, '��ע', 'toa_crm_stock3050_130707154314', '0', '', '2', '', '2', 'crm_stock', '0', 999, 0, 0),
(199, '��ע', 'toa_crm_purchase9787_130707154411', '0', '', '2', '', '2', 'crm_purchase', '0', 999, 0, 0),
(200, '��ע', 'toa_crm_offer3897_130707154536', '0', '', '2', '', '2', 'crm_offer', '0', 999, 0, 0),
(201, '��������', 'toa_crm_program8539_130707154722', '0', '', '2', '', '2', 'crm_program', '0', 3, 0, 0),
(202, '�ͻ�����', 'toa_crm_program8689_130707154735', '0', '', '2', '', '2', 'crm_program', '0', 4, 0, 0),
(203, '������ע', 'toa_crm_program2617_130707154751', '0', '', '2', '', '2', 'crm_program', '0', 5, 0, 0),
(204, '����״̬', 'toa_crm_program8897_130707154925', '0', '', '3', '׼����|���ύ|δ�ύ', '2', 'crm_program', '1', 1, 0, 0),
(205, '�����ϴ�', 'toa_crm_program8426_130707154948', '2', '', '1', '', '2', 'crm_program', '0', 2, 0, 0),
(206, '��ͬ����', 'toa_crm_contract5029_130707155031', '0', '', '2', '', '2', 'crm_contract', '0', 999, 0, 0),
(207, '��ע', 'toa_crm_order6622_130707155054', '0', '', '2', '', '2', 'crm_order', '0', 999, 0, 0),
(208, '��ע', 'toa_crm_price7922_130707155103', '0', '', '2', '', '2', 'crm_price', '0', 999, 0, 0),
(209, '��ע', 'toa_crm_payment7787_130707155114', '0', '', '2', '', '2', 'crm_payment', '0', 999, 0, 0),
(210, '�����˺�', 'toa_crm_business5031_130707152058', '0', '', '1', '', '2', 'crm_business', '0', 14, 0, 0),
(211, '��������', 'toa_crm_business0773_130707152050', '0', '', '1', '', '2', 'crm_business', '0', 13, 0, 0),
(212, '������', 'toa_crm_business8222_130707152032', '0', '', '1', '', '2', 'crm_business', '0', 12, 0, 0),
(213, '��ҵ����', 'toa_crm_business3983_130707151936', '0', '', '1', '', '2', 'crm_business', '0', 7, 0, 0),
(214, '������ҵ', 'toa_crm_business5608_130707151553', '0', '', '5', '����/����/����/����/����\r\n|��е�豸/ͨ���㲿��\r\n|�ճ�����\r\n|��֯/Ƥ��/��װ/Ьñ\r\n|�Ҿ�/������Ʒ/ʳƷ\r\n|ͨ��/����/�����/����\r\n|ҽ�Ʊ���/��ḣ��\r\n|���ӵ���/�����Ǳ�\r\n|����/����/֤ȯ/Ͷ��\r\n|��ͨ����/�����豸\r\n|�ǽ�/����/����/װ�� \r\n|ʯ�ͻ���/������\r\n|�ӱ��۾�/����Ʒ/��Ʒ \r\n|��ֽ/ֽƷ/ӡˢ/��װ \r\n|����/����/����/���� \r\n|ũ������ \r\n|���/��չ/����칫/��ѯҵ \r\n|ұ��ұ��/�������ǽ�����Ʒ\r\n|ó��/����/�г� \r\n|��������/�������', '2', 'crm_business', '0', 6, 0, 0),
(215, '��ϸ����', 'toa_crm_business9083_130707152329', '0', '', '2', '', '2', 'crm_business', '0', 999, 0, 0),
(216, '����״̬', 'toa_crm_business3538_130707151232', '0', '', '5', '�������|��ʽ������|���Ĵ�����|��ͣ����', '2', 'crm_business', '1', 1, 0, 0),
(217, 'ע���ַ', 'toa_crm_business3337_130707151924', '0', '', '1', '', '2', 'crm_business', '0', 10, 0, 0),
(218, 'ע���ʱ�', 'toa_crm_business1407_130707151913', '0', '', '1', '', '2', 'crm_business', '0', 8, 0, 0),
(219, '����ʱ��', 'toa_crm_business0785_130707151846', '3', '', '1', '', '2', 'crm_business', '0', 9, 0, 0),
(220, '��˾��վ', 'toa_crm_business3616_130707151643', '0', '', '1', '', '2', 'crm_business', '0', 11, 0, 0),
(221, '����ȼ�', 'toa_crm_business8701_130707151018', '0', '', '5', '��ͨ����|��Ȩ������|�������|�������[���]|����[���]�ܴ���', '2', 'crm_business', '1', 2, 0, 0),
(222, '�ͻ���Դ', 'toa_crm_business9793_130707150911', '0', '', '5', '�绰����|���ѽ���|����ƹ�|��������|�����|�����б�|������|�ͻ�����', '2', 'crm_business', '0', 3, 0, 0),
(223, '��������', 'toa_crm_business4128_130707151505', '0', '', '1', '', '2', 'crm_business', '0', 5, 0, 0),
(224, '�ͻ����', 'toa_crm_business8860_130707150634', '0', '', '3', '��ҵ����|���˴���', '2', 'crm_business', '1', 4, 0, 0),
(225, '�����˺�', 'toa_crm_supplier5031_130707152058', '0', '', '1', '', '2', 'crm_supplier', '0', 14, 0, 0),
(226, '��������', 'toa_crm_supplier0773_130707152050', '0', '', '1', '', '2', 'crm_supplier', '0', 13, 0, 0),
(227, '������', 'toa_crm_supplier8222_130707152032', '0', '', '1', '', '2', 'crm_supplier', '0', 12, 0, 0),
(228, '��ҵ����', 'toa_crm_supplier3983_130707151936', '0', '', '1', '', '2', 'crm_supplier', '0', 7, 0, 0),
(229, '������ҵ', 'toa_crm_supplier5608_130707151553', '0', '', '5', '����/����/����/����/����\r\n|��е�豸/ͨ���㲿��\r\n|�ճ�����\r\n|��֯/Ƥ��/��װ/Ьñ\r\n|�Ҿ�/������Ʒ/ʳƷ\r\n|ͨ��/����/�����/����\r\n|ҽ�Ʊ���/��ḣ��\r\n|���ӵ���/�����Ǳ�\r\n|����/����/֤ȯ/Ͷ��\r\n|��ͨ����/�����豸\r\n|�ǽ�/����/����/װ�� \r\n|ʯ�ͻ���/������\r\n|�ӱ��۾�/����Ʒ/��Ʒ \r\n|��ֽ/ֽƷ/ӡˢ/��װ \r\n|����/����/����/���� \r\n|ũ������ \r\n|���/��չ/����칫/��ѯҵ \r\n|ұ��ұ��/�������ǽ�����Ʒ\r\n|ó��/����/�г� \r\n|��������/�������', '2', 'crm_supplier', '0', 6, 0, 0),
(230, '��ϸ����', 'toa_crm_supplier9083_130707152329', '0', '', '2', '', '2', 'crm_supplier', '0', 999, 0, 0),
(240, '��ϵ��', 'toa_crm_supplier0942_130710181509', '0', '', '1', '', '2', 'crm_supplier', '0', 999, 0, 0),
(232, 'ע���ַ', 'toa_crm_supplier3337_130707151924', '0', '', '1', '', '2', 'crm_supplier', '0', 10, 0, 0),
(233, 'ע���ʱ�', 'toa_crm_supplier1407_130707151913', '0', '', '1', '', '2', 'crm_supplier', '0', 8, 0, 0),
(234, '����ʱ��', 'toa_crm_supplier0785_130707151846', '3', '', '1', '', '2', 'crm_supplier', '0', 9, 0, 0),
(235, '��˾��վ', 'toa_crm_supplier3616_130707151643', '0', '', '1', '', '2', 'crm_supplier', '0', 11, 0, 0),
(236, '�ȼ�', 'toa_crm_supplier8701_130707151018', '0', '', '3', 'һ��|����|����|����|����', '2', 'crm_supplier', '1', 2, 0, 0),
(237, '��Դ', 'toa_crm_supplier9793_130707150911', '0', '', '5', '�绰����|���ѽ���|����ƹ�|��������|�����|�����б�|������|�ͻ�����|������', '2', 'crm_supplier', '1', 3, 0, 0),
(238, '��������', 'toa_crm_supplier4128_130707151505', '0', '', '1', '', '2', 'crm_supplier', '0', 5, 0, 0),
(239, '���', 'toa_crm_supplier8860_130707150634', '0', '', '3', '��ҵ�ͻ�|���˿ͻ�', '2', 'crm_supplier', '0', 4, 0, 0),
(241, '�Ա�', 'toa_crm_supplier6358_130710181526', '0', '', '3', '��|Ů', '2', 'crm_supplier', '0', 999, 0, 0),
(242, 'ְ��', 'toa_crm_supplier5588_130710181535', '0', '', '1', '', '2', 'crm_supplier', '0', 999, 0, 0),
(243, '�ֻ�', 'toa_crm_supplier3656_130710181543', '0', '', '1', '', '2', 'crm_supplier', '0', 999, 0, 0),
(244, '�칫�绰', 'toa_crm_supplier8551_130710181551', '0', '', '1', '', '2', 'crm_supplier', '0', 999, 0, 0),
(245, '����', 'toa_crm_supplier7569_130710181559', '0', '', '1', '', '2', 'crm_supplier', '0', 999, 0, 0),
(246, 'QQ/MSN', 'toa_crm_supplier2366_130710181610', '0', '', '1', '', '2', 'crm_supplier', '0', 999, 0, 0),
(247, '����', 'toa_crm_supplier5022_130710181617', '0', '', '1', '', '2', 'crm_supplier', '0', 999, 0, 0),
(248, '�ʱ�', 'toa_crm_supplier4276_130710181623', '0', '', '1', '', '2', 'crm_supplier', '0', 999, 0, 0),
(249, '��ַ', 'toa_crm_supplier1241_130710181630', '0', '', '1', '', '2', 'crm_supplier', '0', 999, 0, 0);
INSERT INTO toa_crm_flow (fid, flowname, flownum, flowuser, modid, flowkey, flowkey1, flowkey2, flowkey3) VALUES
(1000, '�������ύ����', '1', NULL, 'crm_price', '1', '1', '2', '2'),
(1002, '�������ύ����', '1', NULL, 'crm_offer', '1', '1', '2', '2'),
(1003, '�������ύ����', '1', NULL, 'crm_program', '1', '1', '2', '2'),
(1004, '�������ύ����', '1', NULL, 'crm_contract', '1', '1', '2', '2'),
(1005, '�������ύ����', '1', NULL, 'crm_order', '1', '1', '2', '2'),
(1007, '�������ύ����', '1', NULL, 'crm_payment', '1', '1', '2', '2'),
(1026, '�������ύ����', '1', NULL, 'crm_purchase', '1', '1', '2', '2'),
(1011, '����������', '2', '', 'crm_offer', '2', '1', '2', '2'),
(1012, '����������', '2', '', 'crm_program', '2', '1', '2', '2'),
(1013, '���Ÿ���������', '2', '', 'crm_contract', '1', '1', '2', '2'),
(1014, '������������', '3', '', 'crm_contract', '1', '1', '2', '2'),
(1015, '�ܾ�������', '4', '', 'crm_contract', '2', '1', '2', '2'),
(1017, '���Ÿ���������', '2', '', 'crm_order', '1', '1', '2', '2'),
(1018, '������������', '3', '', 'crm_order', '1', '1', '2', '2'),
(1019, '�ܾ�������', '4', '', 'crm_order', '2', '1', '2', '2'),
(1020, '������������', '2', '', 'crm_price', '2', '1', '2', '2'),
(1021, '���Ÿ���������', '2', '', 'crm_payment', '1', '1', '2', '2'),
(1022, '������������', '3', '', 'crm_payment', '1', '1', '2', '2'),
(1023, '�ܾ�������', '4', '', 'crm_payment', '1', '1', '2', '2'),
(1024, '������֧������', '5', '', 'crm_payment', '2', '1', '2', '2');
INSERT INTO toa_menu (menuid, menuname, menuurl, fatherid, menutype, menunum, menukey,keytable) VALUES
(49, '��Ʒ����', 'admin.php?ac=crm_product&fileurl=crm', '7', '0', 5, '0', 'input_product'),
(286, '��ϵ��', 'admin.php?ac=contact&fileurl=crm&type=2', '54', '0', 2, '0', 'crm_contact_2'),
(47, '���۹���', 'admin.php?ac=offer&fileurl=crm', '7', '0', 2, '0', 'input_offer'),
(46, '�ͻ�����', 'admin.php?ac=company&fileurl=crm', '7', '0', 1, '0', 'input_company'),
(50, '�ɹ�����', 'admin.php?ac=purchase&fileurl=crm', '7', '0', 4, '0', 'input_supplier'),
(7, 'CRMϵͳ', 'home.php?mid=7', '0', '0', 3, '1', 'input_crm'),
(54, '�����̹���', 'admin.php?ac=business&fileurl=crm', '7', '0', 6, '0', 'input_business'),
(55, '������֧', 'admin.php?ac=price&fileurl=crm', '7', '0', 3, '0', 'input_price'),
(156, '������������', 'admin.php?ac=form&fileurl=crm', '7', '0', 8, '0', 'input_crmform'),
(157, '��ϵ��', 'admin.php?ac=contact&fileurl=crm', '46', '2', 2, '0', 'crm_contact_1'),
(158, '�ͻ��ػ�', 'admin.php?ac=care&fileurl=crm', '46', '2', 3, '0', 'crm_care_1'),
(159, '�ͻ�Ͷ��', 'admin.php?ac=complaints&fileurl=crm', '46', '2', 5, '0', 'crm_complaints_1'),
(160, '���۵�', 'admin.php?ac=offer&fileurl=crm', '47', '2', 1, '0', 'crm_offer'),
(161, '�������', 'admin.php?ac=program&fileurl=crm', '47', '2', 2, '0', 'crm_program'),
(162, '����', 'admin.php?ac=order&fileurl=crm', '47', '2', 4, '0', 'crm_order'),
(163, '��Ʒ��������', 'admin.php?ac=prod&fileurl=crm&do=class', '49', '0', 1, '0', 'crm_pord_type'),
(164, '��Ʒ��Ϣ����', 'admin.php?ac=prod&fileurl=crm', '49', '2', 2, '0', 'crm_product'),
(165, '��Ӧ�̹���', 'admin.php?ac=supplier&fileurl=crm', '50', '2', 1, '0', 'crm_supplier'),
(166, '�ɹ�����', 'admin.php?ac=purchase&fileurl=crm', '50', '2', 2, '0', 'crm_purchase'),
(287, '������Ͷ��', 'admin.php?ac=complaints&fileurl=crm&type=2', '54', '2', 3, '0', 'crm_complaints_2'),
(288, '��������Ϣ', 'admin.php?ac=business&fileurl=crm', '54', '2', 1, '0', 'crm_business'),
(289, '�ͻ��ػ�', 'admin.php?ac=care&fileurl=crm&type=2', '54', '0', 4, '0', 'crm_care_2'),
(171, '�ͻ���Ϣ', 'admin.php?ac=company&fileurl=crm', '46', '2', 1, '0', 'crm_company'),
(172, '�ͻ��ط�', 'admin.php?ac=service&fileurl=crm', '46', '2', 4, '0', 'crm_service'),
(173, '��ͬ', 'admin.php?ac=contract&fileurl=crm', '47', '2', 3, '0', 'crm_contract'),
(290, '�տ', 'admin.php?ac=price&fileurl=crm', '55', '2', 1, '0', 'crm_price'),
(285, '������', 'admin.php?ac=stock&fileurl=crm', '49', '2', 3, '0', 'crm_stock'),
(291, '���', 'admin.php?ac=payment&fileurl=crm', '55', '2', 2, '0', 'crm_payment'),
(292, '������', 'admin.php?ac=form&fileurl=crm', '156', '0', 1, '0', 'crm_form'),
(293, '��������', 'admin.php?ac=flow&fileurl=crm', '156', '0', 2, '0', 'crm_flow'),
(294, '������ͳ��', 'admin.php?ac=charts&fileurl=crm', '7', '0', 7, '0', 'crm_charts');
INSERT INTO toa_keytable (id, name, inputname, inputvalue, inputchecked, type, number, fatherid) VALUES
(414, 'CRMϵͳ', 'input_crm', '1', '1', '2', 3, '0'),
(415, '�ͻ�����', 'input_company', '1', '1', '2', 1, '414'),
(416, '���۹���', 'input_offer', '1', '1', '2', 2, '414'),
(417, '������֧', 'input_price', '1', '1', '2', 3, '414'),
(418, '�ɹ�����', 'input_supplier', '1', '1', '2', 4, '414'),
(419, '��Ʒ����', 'input_product', '1', '1', '2', 5, '414'),
(420, '�����̹���', 'input_business', '1', '1', '2', 6, '414'),
(421, '������������', 'input_crmform', '1', '1', '2', 7, '414'),
(422, '������ͳ��', '0', '1', '1', '2', 8, '414'),
(423, '����', 'crm_charts', '1', '1', '1', 1, '422'),
(424, '�ܾ�', 'crm_charts', '0', '1', '1', 2, '422'),
(425, '������', 'crm_form', '1', '1', '2', 999, '421'),
(426, '���̹���', 'crm_flow', '1', '1', '2', 999, '421'),
(427, '���۵�����', 'crm_offer', '1', '1', '2', 999, '416'),
(428, '���۵����', 'crm_offer_add', '1', '1', '2', 999, '416'),
(429, '���۵��༭', 'crm_offer_edit', '1', '1', '2', 999, '416'),
(430, '���۵�ɾ��', 'crm_offer_del', '1', '1', '2', 999, '416'),
(431, '�����������', 'crm_program', '1', '1', '2', 999, '416'),
(432, '����������', 'crm_program_add', '1', '1', '2', 999, '416'),
(433, '��������༭', 'crm_program_edit', '1', '1', '2', 999, '416'),
(434, '�������ɾ��', 'crm_program_del', '1', '1', '2', 999, '416'),
(435, '��ͬ����', 'crm_contract', '1', '1', '2', 999, '416'),
(436, '��ͬ���', 'crm_contract_add', '1', '1', '2', 999, '416'),
(437, '��ͬ�༭', 'crm_contract_edit', '1', '1', '2', 999, '416'),
(438, '��ͬɾ��', 'crm_contract_del', '1', '1', '2', 999, '416'),
(439, '��������', 'crm_order', '1', '1', '2', 999, '416'),
(440, '�������', 'crm_order_add', '1', '1', '2', 999, '416'),
(441, '�����༭', 'crm_order_edit', '1', '1', '2', 999, '416'),
(442, '����ɾ��', 'crm_order_del', '1', '1', '2', 999, '416'),
(443, '�����̹���', 'crm_business', '1', '1', '2', 999, '420'),
(444, '���������', 'crm_business_add', '1', '1', '2', 999, '420'),
(445, '�����̱༭', 'crm_business_edit', '1', '1', '2', 999, '420'),
(446, '������ɾ��', 'crm_business_del', '1', '1', '2', 999, '420'),
(447, '��ϵ�˹���', 'crm_contact_2', '1', '1', '2', 999, '420'),
(448, '��ϵ�����', 'crm_contact_add_2', '1', '1', '2', 999, '420'),
(449, '��ϵ�˱༭', 'crm_contact_edit_2', '1', '1', '2', 999, '420'),
(450, '��ϵ��ɾ��', 'crm_contact_del_2', '1', '1', '2', 999, '420'),
(451, '�ͻ�Ͷ�߹���', 'crm_complaints_2', '1', '1', '2', 999, '420'),
(452, '�ͻ�Ͷ�����', 'crm_complaints_add_2', '1', '1', '2', 999, '420'),
(453, '�ͻ�Ͷ�߱༭', 'crm_complaints_edit_2', '1', '1', '2', 999, '420'),
(454, '�ͻ�Ͷ��ɾ��', 'crm_complaints_del_2', '1', '1', '2', 999, '420'),
(455, '�ͻ��ػ�����', 'crm_care_2', '1', '1', '2', 999, '420'),
(456, '�ͻ��ػ����', 'crm_care_add_2', '1', '1', '2', 999, '420'),
(457, '�ͻ��ػ��༭', 'crm_care_edit_2', '1', '1', '2', 999, '420'),
(458, '�ͻ��ػ�ɾ��', 'crm_care_del_2', '1', '1', '2', 999, '420'),
(459, '��Ʒ�������', 'crm_pord_type', '1', '1', '2', 999, '419'),
(460, '��Ʒ��Ϣ����', 'crm_product', '1', '1', '2', 999, '419'),
(461, '������', 'crm_stock', '1', '1', '2', 999, '419'),
(462, '��Ӧ�̹���', 'crm_supplier', '1', '1', '2', 999, '418'),
(463, '��Ӧ�����', 'crm_supplier_add', '1', '1', '2', 999, '418'),
(464, '��Ӧ�̱༭', 'crm_supplier_edit', '1', '1', '2', 999, '418'),
(465, '��Ӧ��ɾ��', 'crm_supplier_del', '1', '1', '2', 999, '418'),
(466, '�ɹ�����', 'crm_purchase', '1', '1', '2', 999, '418'),
(467, '�ɹ����', 'crm_purchase_add', '1', '1', '2', 999, '418'),
(468, '�ɹ��༭', 'crm_purchase_edit', '1', '1', '2', 999, '418'),
(469, '�ɹ�ɾ��', 'crm_purchase_del', '1', '1', '2', 999, '418'),
(470, '�տ����', 'crm_price', '1', '1', '2', 999, '417'),
(471, '�տ���', 'crm_price_add', '1', '1', '2', 999, '417'),
(472, '�տ�༭', 'crm_price_edit', '1', '1', '2', 999, '417'),
(473, '�տɾ��', 'crm_price_del', '1', '1', '2', 999, '417'),
(474, '�������', 'crm_payment', '1', '1', '2', 999, '417'),
(475, '�������', 'crm_payment_add', '1', '1', '2', 999, '417'),
(476, '����༭', 'crm_payment_edit', '1', '1', '2', 999, '417'),
(477, '����ɾ��', 'crm_payment_del', '1', '1', '2', 999, '417'),
(478, '�ͻ���Ϣ����', 'crm_company', '1', '1', '2', 999, '415'),
(479, '�ͻ���Ϣ���', 'crm_company_add', '1', '1', '2', 999, '415'),
(480, '�ͻ���Ϣ�༭', 'crm_company_edit', '1', '1', '2', 999, '415'),
(481, '�ͻ���Ϣɾ��', 'crm_company_del', '1', '1', '2', 999, '415'),
(482, '��ϵ�˹���', 'crm_contact_1', '1', '1', '2', 999, '415'),
(483, '��ϵ�����', 'crm_contact_add_1', '1', '1', '2', 999, '415'),
(484, '��ϵ�˱༭', 'crm_contact_edit_1', '1', '1', '2', 999, '415'),
(485, '��ϵ��ɾ��', 'crm_contact_del_1', '1', '1', '2', 999, '415'),
(486, '�ͻ��ػ�����', 'crm_care_1', '1', '1', '2', 999, '415'),
(487, '�ͻ��ػ����', 'crm_care_add_1', '1', '1', '2', 999, '415'),
(488, '�ͻ��ػ��༭', 'crm_care_edit_1', '1', '1', '2', 999, '415'),
(489, '�ͻ��ػ�ɾ��', 'crm_care_del_1', '1', '1', '2', 999, '415'),
(490, '�ͻ��طù���', 'crm_service', '1', '1', '2', 999, '415'),
(491, '�ͻ��ط����', 'crm_service_add', '1', '1', '2', 999, '415'),
(492, '�ͻ��طñ༭', 'crm_service_edit', '1', '1', '2', 999, '415'),
(493, '�ͻ��ط�ɾ��', 'crm_service_del', '1', '1', '2', 999, '415'),
(494, '�ͻ�Ͷ�߹���', 'crm_complaints_1', '1', '1', '2', 999, '415'),
(495, '�ͻ�Ͷ�����', 'crm_complaints_add_1', '1', '1', '2', 999, '415'),
(496, '�ͻ�Ͷ�߱༭', 'crm_complaints_edit_1', '1', '1', '2', 999, '415'),
(497, '�ͻ�Ͷ��ɾ��', 'crm_complaints_del_1', '1', '1', '2', 999, '415'),
(498, '������Ȩ��', 'input_excel', '1', '1', '2', 999, '414'),
(499, '�ͻ���Ϣ', 'crm_company_excel', '1', '1', '2', 999, '498'),
(500, '��ϵ��', 'crm_contact_excel_1', '1', '1', '2', 999, '498'),
(501, '�ͻ��ػ�', 'crm_care_excel_1', '1', '1', '2', 999, '498'),
(502, '�ͻ��ط�', 'crm_service_excel', '1', '1', '2', 999, '498'),
(503, '�ͻ�Ͷ��', 'crm_complaints_excel_1', '1', '1', '2', 999, '498'),
(504, '���۵�', 'crm_offer_excel', '1', '1', '2', 999, '498'),
(505, '�������', 'crm_program_excel', '1', '1', '2', 999, '498'),
(506, '��ͬ', 'crm_contract_excel', '1', '1', '2', 999, '498'),
(507, '����', 'crm_order_excel', '1', '1', '2', 999, '498'),
(508, '�տ', 'crm_price_excel', '1', '1', '2', 999, '498'),
(509, '����', 'crm_payment_excel', '1', '1', '2', 999, '498'),
(510, '��Ӧ��', 'crm_supplier_excel', '1', '1', '2', 999, '498'),
(511, '�ɹ�', 'crm_purchase_excel', '1', '1', '2', 999, '498'),
(512, '��Ʒ��Ϣ', 'crm_product_excel', '1', '1', '2', 999, '498'),
(513, '���', 'crm_stock_excel', '1', '1', '2', 999, '498'),
(514, '������', 'crm_business_excel', '1', '1', '2', 999, '498'),
(515, '��ϵ��[������]', 'crm_contact_excel_2', '1', '1', '2', 999, '498'),
(516, '�ͻ�Ͷ��[������]', 'crm_complaints_excel_2', '1', '1', '2', 999, '498'),
(517, '�ͻ��ػ�[������]', 'crm_care_excel_2', '1', '1', '2', 999, '498');
