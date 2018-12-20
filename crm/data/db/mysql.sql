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
(183, '银行账号', 'toa_crm_company5031_130707152058', '0', '', '1', '', '2', 'crm_company', '0', 14, 0, 0),
(182, '开户名称', 'toa_crm_company0773_130707152050', '0', '', '1', '', '2', 'crm_company', '0', 13, 0, 0),
(181, '开户行', 'toa_crm_company8222_130707152032', '0', '', '1', '', '2', 'crm_company', '0', 12, 0, 0),
(180, '企业法人', 'toa_crm_company3983_130707151936', '0', '', '1', '', '2', 'crm_company', '0', 7, 0, 0),
(175, '所属行业', 'toa_crm_company5608_130707151553', '0', '', '5', '旅游/餐饮/娱乐/休闲/购物\r\n|机械设备/通用零部件\r\n|日常服务\r\n|纺织/皮革/服装/鞋帽\r\n|家具/生活用品/食品\r\n|通信/邮政/计算机/网络\r\n|医疗保健/社会福利\r\n|电子电器/仪器仪表\r\n|金融/保险/证券/投资\r\n|交通物流/运输设备\r\n|城建/房产/建材/装潢 \r\n|石油化工/橡胶塑料\r\n|钟表眼镜/工艺品/礼品 \r\n|造纸/纸品/印刷/包装 \r\n|新闻/出版/科研/教育 \r\n|农林牧渔 \r\n|广告/会展/商务办公/咨询业 \r\n|冶金冶炼/金属及非金属制品\r\n|贸易/批发/市场 \r\n|党政机关/社会团体', '2', 'crm_company', '0', 6, 0, 0),
(184, '详细描述', 'toa_crm_company9083_130707152329', '0', '', '2', '', '2', 'crm_company', '0', 999, 0, 0),
(173, '客户状态', 'toa_crm_company3538_130707151232', '0', '', '5', '潜在客户|意向客户|失效客户|己成交客户|VIP客户', '2', 'crm_company', '1', 1, 0, 0),
(179, '注册地址', 'toa_crm_company3337_130707151924', '0', '', '1', '', '2', 'crm_company', '0', 10, 0, 0),
(178, '注册资本', 'toa_crm_company1407_130707151913', '0', '', '1', '', '2', 'crm_company', '0', 8, 0, 0),
(177, '成立时间', 'toa_crm_company0785_130707151846', '3', '', '1', '', '2', 'crm_company', '0', 9, 0, 0),
(176, '公司网站', 'toa_crm_company3616_130707151643', '0', '', '1', '', '2', 'crm_company', '0', 11, 0, 0),
(172, '客户等级', 'toa_crm_company8701_130707151018', '0', '', '3', '一星|二星|三星|四星|五星', '2', 'crm_company', '1', 2, 0, 0),
(171, '客户来源', 'toa_crm_company9793_130707150911', '0', '', '5', '电话来访|朋友介绍|广告推广|独立开发|促销活动|公开招标|互联网|客户介绍|代理商', '2', 'crm_company', '0', 3, 0, 0),
(174, '所属区域', 'toa_crm_company4128_130707151505', '0', '', '1', '', '2', 'crm_company', '0', 5, 0, 0),
(170, '客户类别', 'toa_crm_company8860_130707150634', '0', '', '3', '企业客户|个人客户', '2', 'crm_company', '0', 4, 0, 0),
(152, '产品型号', 'toa_crm_product9202_130707144537', '0', '', '1', '', '2', 'crm_product', '0', 1, 0, 0),
(153, '计量单位', 'toa_crm_product7824_130707144603', '0', '', '5', '台|套|只|个|公斤|斤|吨|箱|米|本|辆', '2', 'crm_product', '1', 2, 0, 0),
(154, '生产厂商', 'toa_crm_product4814_130707144618', '0', '', '1', '', '2', 'crm_product', '0', 4, 0, 0),
(155, '产地', 'toa_crm_product7603_130707144628', '0', '', '1', '', '2', 'crm_product', '0', 3, 0, 0),
(156, '产品图片', 'toa_crm_product6674_130707144638', '1', '', '1', '', '2', 'crm_product', '0', 5, 0, 0),
(157, '详细描述', 'toa_crm_product8295_130707144653', '0', '', '2', '', '2', 'crm_product', '0', 7, 0, 0),
(158, '产品附件', 'toa_crm_product5070_130707144824', '2', '', '1', '', '2', 'crm_product', '0', 6, 0, 0),
(159, '性别', 'toa_crm_contact4876_130707145252', '0', '', '3', '男|女', '2', 'crm_contact', '1', 1, 0, 0),
(160, '生日', 'toa_crm_contact8440_130707145325', '3', '', '1', '', '2', 'crm_contact', '0', 2, 0, 0),
(161, '手机', 'toa_crm_contact9124_130707145346', '0', '', '1', '', '2', 'crm_contact', '1', 4, 0, 0),
(162, '办公电话', 'toa_crm_contact1165_130707145357', '0', '', '1', '', '2', 'crm_contact', '1', 5, 0, 0),
(163, '职务', 'toa_crm_contact8466_130707145412', '0', '', '1', '', '2', 'crm_contact', '1', 3, 0, 0),
(164, '传真', 'toa_crm_contact4245_130707145421', '0', '', '1', '', '2', 'crm_contact', '0', 6, 0, 0),
(165, 'QQ/MSN', 'toa_crm_contact3648_130707145439', '0', '', '1', '', '2', 'crm_contact', '0', 7, 0, 0),
(166, '邮箱', 'toa_crm_contact8837_130707145451', '0', '', '1', '', '2', 'crm_contact', '1', 8, 0, 0),
(167, '邮编', 'toa_crm_contact9436_130707145500', '0', '', '1', '', '2', 'crm_contact', '0', 9, 0, 0),
(168, '地址', 'toa_crm_contact6338_130707145511', '0', '', '1', '', '2', 'crm_contact', '0', 10, 0, 0),
(169, '备注', 'toa_crm_contact9839_130707145550', '0', '', '2', '', '2', 'crm_contact', '0', 11, 0, 0),
(185, '回访目的', 'toa_crm_service5957_130707153242', '0', '', '2', '', '2', 'crm_service', '0', 999, 0, 0),
(186, '回访结果描述', 'toa_crm_service1649_130707153314', '0', '', '2', '', '2', 'crm_service', '0', 999, 0, 0),
(187, '关怀内容', 'toa_crm_care6461_130707153428', '0', '', '2', '', '2', 'crm_care', '0', 3, 0, 0),
(188, '关怀类型', 'toa_crm_care7981_130707153549', '0', '', '5', '节日|生日|店庆活动', '2', 'crm_care', '1', 1, 0, 0),
(189, '关怀方式', 'toa_crm_care9689_130707153623', '0', '', '1', '', '2', 'crm_care', '0', 2, 0, 0),
(190, '备注', 'toa_crm_care4970_130707153630', '0', '', '2', '', '2', 'crm_care', '0', 4, 0, 0),
(191, '投诉类型', 'toa_crm_complaints2557_130707153839', '0', '', '5', '产品投诉|售后投诉|竟见反馈', '2', 'crm_complaints', '1', 999, 0, 0),
(192, '投诉方式', 'toa_crm_complaints8348_130707154007', '0', '', '5', '上门|电话|邮箱|短信|QQ|传真|网站', '2', 'crm_complaints', '0', 999, 0, 0),
(193, '处理状态', 'toa_crm_complaints5024_130707154054', '0', '', '3', '待处理|处理中|己处理', '2', 'crm_complaints', '1', 999, 0, 0),
(194, '紧急状态', 'toa_crm_complaints3652_130707154131', '0', '', '3', '急|不急|非常急', '2', 'crm_complaints', '0', 999, 0, 0),
(195, '投诉内容', 'toa_crm_complaints1143_130707154150', '0', '', '2', '', '2', 'crm_complaints', '0', 999, 0, 0),
(196, '反馈内容', 'toa_crm_complaints1197_130707154201', '0', '', '2', '', '2', 'crm_complaints', '0', 999, 0, 0),
(197, '备注', 'toa_crm_complaints8873_130707154211', '0', '', '2', '', '2', 'crm_complaints', '0', 999, 0, 0),
(198, '备注', 'toa_crm_stock3050_130707154314', '0', '', '2', '', '2', 'crm_stock', '0', 999, 0, 0),
(199, '备注', 'toa_crm_purchase9787_130707154411', '0', '', '2', '', '2', 'crm_purchase', '0', 999, 0, 0),
(200, '备注', 'toa_crm_offer3897_130707154536', '0', '', '2', '', '2', 'crm_offer', '0', 999, 0, 0),
(201, '方案内容', 'toa_crm_program8539_130707154722', '0', '', '2', '', '2', 'crm_program', '0', 3, 0, 0),
(202, '客户反馈', 'toa_crm_program8689_130707154735', '0', '', '2', '', '2', 'crm_program', '0', 4, 0, 0),
(203, '其它备注', 'toa_crm_program2617_130707154751', '0', '', '2', '', '2', 'crm_program', '0', 5, 0, 0),
(204, '方案状态', 'toa_crm_program8897_130707154925', '0', '', '3', '准备中|己提交|未提交', '2', 'crm_program', '1', 1, 0, 0),
(205, '附件上传', 'toa_crm_program8426_130707154948', '2', '', '1', '', '2', 'crm_program', '0', 2, 0, 0),
(206, '合同描述', 'toa_crm_contract5029_130707155031', '0', '', '2', '', '2', 'crm_contract', '0', 999, 0, 0),
(207, '备注', 'toa_crm_order6622_130707155054', '0', '', '2', '', '2', 'crm_order', '0', 999, 0, 0),
(208, '备注', 'toa_crm_price7922_130707155103', '0', '', '2', '', '2', 'crm_price', '0', 999, 0, 0),
(209, '备注', 'toa_crm_payment7787_130707155114', '0', '', '2', '', '2', 'crm_payment', '0', 999, 0, 0),
(210, '银行账号', 'toa_crm_business5031_130707152058', '0', '', '1', '', '2', 'crm_business', '0', 14, 0, 0),
(211, '开户名称', 'toa_crm_business0773_130707152050', '0', '', '1', '', '2', 'crm_business', '0', 13, 0, 0),
(212, '开户行', 'toa_crm_business8222_130707152032', '0', '', '1', '', '2', 'crm_business', '0', 12, 0, 0),
(213, '企业法人', 'toa_crm_business3983_130707151936', '0', '', '1', '', '2', 'crm_business', '0', 7, 0, 0),
(214, '所属行业', 'toa_crm_business5608_130707151553', '0', '', '5', '旅游/餐饮/娱乐/休闲/购物\r\n|机械设备/通用零部件\r\n|日常服务\r\n|纺织/皮革/服装/鞋帽\r\n|家具/生活用品/食品\r\n|通信/邮政/计算机/网络\r\n|医疗保健/社会福利\r\n|电子电器/仪器仪表\r\n|金融/保险/证券/投资\r\n|交通物流/运输设备\r\n|城建/房产/建材/装潢 \r\n|石油化工/橡胶塑料\r\n|钟表眼镜/工艺品/礼品 \r\n|造纸/纸品/印刷/包装 \r\n|新闻/出版/科研/教育 \r\n|农林牧渔 \r\n|广告/会展/商务办公/咨询业 \r\n|冶金冶炼/金属及非金属制品\r\n|贸易/批发/市场 \r\n|党政机关/社会团体', '2', 'crm_business', '0', 6, 0, 0),
(215, '详细描述', 'toa_crm_business9083_130707152329', '0', '', '2', '', '2', 'crm_business', '0', 999, 0, 0),
(216, '代理状态', 'toa_crm_business3538_130707151232', '0', '', '5', '意向代理|正式代理商|核心代理商|暂停合作', '2', 'crm_business', '1', 1, 0, 0),
(217, '注册地址', 'toa_crm_business3337_130707151924', '0', '', '1', '', '2', 'crm_business', '0', 10, 0, 0),
(218, '注册资本', 'toa_crm_business1407_130707151913', '0', '', '1', '', '2', 'crm_business', '0', 8, 0, 0),
(219, '成立时间', 'toa_crm_business0785_130707151846', '3', '', '1', '', '2', 'crm_business', '0', 9, 0, 0),
(220, '公司网站', 'toa_crm_business3616_130707151643', '0', '', '1', '', '2', 'crm_business', '0', 11, 0, 0),
(221, '代理等级', 'toa_crm_business8701_130707151018', '0', '', '5', '普通代理|授权代理商|区域代理|区域代理[买断]|独家[买断]总代理', '2', 'crm_business', '1', 2, 0, 0),
(222, '客户来源', 'toa_crm_business9793_130707150911', '0', '', '5', '电话来访|朋友介绍|广告推广|独立开发|促销活动|公开招标|互联网|客户介绍', '2', 'crm_business', '0', 3, 0, 0),
(223, '代理区域', 'toa_crm_business4128_130707151505', '0', '', '1', '', '2', 'crm_business', '0', 5, 0, 0),
(224, '客户类别', 'toa_crm_business8860_130707150634', '0', '', '3', '企业代理|个人代理', '2', 'crm_business', '1', 4, 0, 0),
(225, '银行账号', 'toa_crm_supplier5031_130707152058', '0', '', '1', '', '2', 'crm_supplier', '0', 14, 0, 0),
(226, '开户名称', 'toa_crm_supplier0773_130707152050', '0', '', '1', '', '2', 'crm_supplier', '0', 13, 0, 0),
(227, '开户行', 'toa_crm_supplier8222_130707152032', '0', '', '1', '', '2', 'crm_supplier', '0', 12, 0, 0),
(228, '企业法人', 'toa_crm_supplier3983_130707151936', '0', '', '1', '', '2', 'crm_supplier', '0', 7, 0, 0),
(229, '所属行业', 'toa_crm_supplier5608_130707151553', '0', '', '5', '旅游/餐饮/娱乐/休闲/购物\r\n|机械设备/通用零部件\r\n|日常服务\r\n|纺织/皮革/服装/鞋帽\r\n|家具/生活用品/食品\r\n|通信/邮政/计算机/网络\r\n|医疗保健/社会福利\r\n|电子电器/仪器仪表\r\n|金融/保险/证券/投资\r\n|交通物流/运输设备\r\n|城建/房产/建材/装潢 \r\n|石油化工/橡胶塑料\r\n|钟表眼镜/工艺品/礼品 \r\n|造纸/纸品/印刷/包装 \r\n|新闻/出版/科研/教育 \r\n|农林牧渔 \r\n|广告/会展/商务办公/咨询业 \r\n|冶金冶炼/金属及非金属制品\r\n|贸易/批发/市场 \r\n|党政机关/社会团体', '2', 'crm_supplier', '0', 6, 0, 0),
(230, '详细描述', 'toa_crm_supplier9083_130707152329', '0', '', '2', '', '2', 'crm_supplier', '0', 999, 0, 0),
(240, '联系人', 'toa_crm_supplier0942_130710181509', '0', '', '1', '', '2', 'crm_supplier', '0', 999, 0, 0),
(232, '注册地址', 'toa_crm_supplier3337_130707151924', '0', '', '1', '', '2', 'crm_supplier', '0', 10, 0, 0),
(233, '注册资本', 'toa_crm_supplier1407_130707151913', '0', '', '1', '', '2', 'crm_supplier', '0', 8, 0, 0),
(234, '成立时间', 'toa_crm_supplier0785_130707151846', '3', '', '1', '', '2', 'crm_supplier', '0', 9, 0, 0),
(235, '公司网站', 'toa_crm_supplier3616_130707151643', '0', '', '1', '', '2', 'crm_supplier', '0', 11, 0, 0),
(236, '等级', 'toa_crm_supplier8701_130707151018', '0', '', '3', '一星|二星|三星|四星|五星', '2', 'crm_supplier', '1', 2, 0, 0),
(237, '来源', 'toa_crm_supplier9793_130707150911', '0', '', '5', '电话来访|朋友介绍|广告推广|独立开发|促销活动|公开招标|互联网|客户介绍|代理商', '2', 'crm_supplier', '1', 3, 0, 0),
(238, '所属区域', 'toa_crm_supplier4128_130707151505', '0', '', '1', '', '2', 'crm_supplier', '0', 5, 0, 0),
(239, '类别', 'toa_crm_supplier8860_130707150634', '0', '', '3', '企业客户|个人客户', '2', 'crm_supplier', '0', 4, 0, 0),
(241, '性别', 'toa_crm_supplier6358_130710181526', '0', '', '3', '男|女', '2', 'crm_supplier', '0', 999, 0, 0),
(242, '职务', 'toa_crm_supplier5588_130710181535', '0', '', '1', '', '2', 'crm_supplier', '0', 999, 0, 0),
(243, '手机', 'toa_crm_supplier3656_130710181543', '0', '', '1', '', '2', 'crm_supplier', '0', 999, 0, 0),
(244, '办公电话', 'toa_crm_supplier8551_130710181551', '0', '', '1', '', '2', 'crm_supplier', '0', 999, 0, 0),
(245, '传真', 'toa_crm_supplier7569_130710181559', '0', '', '1', '', '2', 'crm_supplier', '0', 999, 0, 0),
(246, 'QQ/MSN', 'toa_crm_supplier2366_130710181610', '0', '', '1', '', '2', 'crm_supplier', '0', 999, 0, 0),
(247, '邮箱', 'toa_crm_supplier5022_130710181617', '0', '', '1', '', '2', 'crm_supplier', '0', 999, 0, 0),
(248, '邮编', 'toa_crm_supplier4276_130710181623', '0', '', '1', '', '2', 'crm_supplier', '0', 999, 0, 0),
(249, '地址', 'toa_crm_supplier1241_130710181630', '0', '', '1', '', '2', 'crm_supplier', '0', 999, 0, 0);
INSERT INTO toa_crm_flow (fid, flowname, flownum, flowuser, modid, flowkey, flowkey1, flowkey2, flowkey3) VALUES
(1000, '申请人提交申请', '1', NULL, 'crm_price', '1', '1', '2', '2'),
(1002, '申请人提交申请', '1', NULL, 'crm_offer', '1', '1', '2', '2'),
(1003, '申请人提交申请', '1', NULL, 'crm_program', '1', '1', '2', '2'),
(1004, '申请人提交申请', '1', NULL, 'crm_contract', '1', '1', '2', '2'),
(1005, '申请人提交申请', '1', NULL, 'crm_order', '1', '1', '2', '2'),
(1007, '申请人提交申请', '1', NULL, 'crm_payment', '1', '1', '2', '2'),
(1026, '申请人提交申请', '1', NULL, 'crm_purchase', '1', '1', '2', '2'),
(1011, '负责人审批', '2', '', 'crm_offer', '2', '1', '2', '2'),
(1012, '负责人审批', '2', '', 'crm_program', '2', '1', '2', '2'),
(1013, '部门负责人审批', '2', '', 'crm_contract', '1', '1', '2', '2'),
(1014, '财务负责人审批', '3', '', 'crm_contract', '1', '1', '2', '2'),
(1015, '总经理审批', '4', '', 'crm_contract', '2', '1', '2', '2'),
(1017, '部门负责人审批', '2', '', 'crm_order', '1', '1', '2', '2'),
(1018, '财务负责人审批', '3', '', 'crm_order', '1', '1', '2', '2'),
(1019, '总经理审批', '4', '', 'crm_order', '2', '1', '2', '2'),
(1020, '财务负责人审批', '2', '', 'crm_price', '2', '1', '2', '2'),
(1021, '部门负责人审批', '2', '', 'crm_payment', '1', '1', '2', '2'),
(1022, '财务负责人审批', '3', '', 'crm_payment', '1', '1', '2', '2'),
(1023, '总经理审批', '4', '', 'crm_payment', '1', '1', '2', '2'),
(1024, '付款人支付款项', '5', '', 'crm_payment', '2', '1', '2', '2');
INSERT INTO toa_menu (menuid, menuname, menuurl, fatherid, menutype, menunum, menukey,keytable) VALUES
(49, '产品与库存', 'admin.php?ac=crm_product&fileurl=crm', '7', '0', 5, '0', 'input_product'),
(286, '联系人', 'admin.php?ac=contact&fileurl=crm&type=2', '54', '0', 2, '0', 'crm_contact_2'),
(47, '销售管理', 'admin.php?ac=offer&fileurl=crm', '7', '0', 2, '0', 'input_offer'),
(46, '客户管理', 'admin.php?ac=company&fileurl=crm', '7', '0', 1, '0', 'input_company'),
(50, '采购管理', 'admin.php?ac=purchase&fileurl=crm', '7', '0', 4, '0', 'input_supplier'),
(7, 'CRM系统', 'home.php?mid=7', '0', '0', 3, '1', 'input_crm'),
(54, '代理商管理', 'admin.php?ac=business&fileurl=crm', '7', '0', 6, '0', 'input_business'),
(55, '财务收支', 'admin.php?ac=price&fileurl=crm', '7', '0', 3, '0', 'input_price'),
(156, '表单与流程设置', 'admin.php?ac=form&fileurl=crm', '7', '0', 8, '0', 'input_crmform'),
(157, '联系人', 'admin.php?ac=contact&fileurl=crm', '46', '2', 2, '0', 'crm_contact_1'),
(158, '客户关怀', 'admin.php?ac=care&fileurl=crm', '46', '2', 3, '0', 'crm_care_1'),
(159, '客户投诉', 'admin.php?ac=complaints&fileurl=crm', '46', '2', 5, '0', 'crm_complaints_1'),
(160, '报价单', 'admin.php?ac=offer&fileurl=crm', '47', '2', 1, '0', 'crm_offer'),
(161, '解决方案', 'admin.php?ac=program&fileurl=crm', '47', '2', 2, '0', 'crm_program'),
(162, '订单', 'admin.php?ac=order&fileurl=crm', '47', '2', 4, '0', 'crm_order'),
(163, '产品分类设置', 'admin.php?ac=prod&fileurl=crm&do=class', '49', '0', 1, '0', 'crm_pord_type'),
(164, '产品信息管理', 'admin.php?ac=prod&fileurl=crm', '49', '2', 2, '0', 'crm_product'),
(165, '供应商管理', 'admin.php?ac=supplier&fileurl=crm', '50', '2', 1, '0', 'crm_supplier'),
(166, '采购管理', 'admin.php?ac=purchase&fileurl=crm', '50', '2', 2, '0', 'crm_purchase'),
(287, '代理商投诉', 'admin.php?ac=complaints&fileurl=crm&type=2', '54', '2', 3, '0', 'crm_complaints_2'),
(288, '代理商信息', 'admin.php?ac=business&fileurl=crm', '54', '2', 1, '0', 'crm_business'),
(289, '客户关怀', 'admin.php?ac=care&fileurl=crm&type=2', '54', '0', 4, '0', 'crm_care_2'),
(171, '客户信息', 'admin.php?ac=company&fileurl=crm', '46', '2', 1, '0', 'crm_company'),
(172, '客户回访', 'admin.php?ac=service&fileurl=crm', '46', '2', 4, '0', 'crm_service'),
(173, '合同', 'admin.php?ac=contract&fileurl=crm', '47', '2', 3, '0', 'crm_contract'),
(290, '收款单', 'admin.php?ac=price&fileurl=crm', '55', '2', 1, '0', 'crm_price'),
(285, '库存管理', 'admin.php?ac=stock&fileurl=crm', '49', '2', 3, '0', 'crm_stock'),
(291, '付款单', 'admin.php?ac=payment&fileurl=crm', '55', '2', 2, '0', 'crm_payment'),
(292, '表单设置', 'admin.php?ac=form&fileurl=crm', '156', '0', 1, '0', 'crm_form'),
(293, '流程设置', 'admin.php?ac=flow&fileurl=crm', '156', '0', 2, '0', 'crm_flow'),
(294, '报表与统计', 'admin.php?ac=charts&fileurl=crm', '7', '0', 7, '0', 'crm_charts');
INSERT INTO toa_keytable (id, name, inputname, inputvalue, inputchecked, type, number, fatherid) VALUES
(414, 'CRM系统', 'input_crm', '1', '1', '2', 3, '0'),
(415, '客户管理', 'input_company', '1', '1', '2', 1, '414'),
(416, '销售管理', 'input_offer', '1', '1', '2', 2, '414'),
(417, '财务收支', 'input_price', '1', '1', '2', 3, '414'),
(418, '采购管理', 'input_supplier', '1', '1', '2', 4, '414'),
(419, '产品与库存', 'input_product', '1', '1', '2', 5, '414'),
(420, '代理商管理', 'input_business', '1', '1', '2', 6, '414'),
(421, '表单与流程设置', 'input_crmform', '1', '1', '2', 7, '414'),
(422, '报表与统计', '0', '1', '1', '2', 8, '414'),
(423, '允许', 'crm_charts', '1', '1', '1', 1, '422'),
(424, '拒绝', 'crm_charts', '0', '1', '1', 2, '422'),
(425, '表单管理', 'crm_form', '1', '1', '2', 999, '421'),
(426, '流程管理', 'crm_flow', '1', '1', '2', 999, '421'),
(427, '报价单管理', 'crm_offer', '1', '1', '2', 999, '416'),
(428, '报价单添加', 'crm_offer_add', '1', '1', '2', 999, '416'),
(429, '报价单编辑', 'crm_offer_edit', '1', '1', '2', 999, '416'),
(430, '报价单删除', 'crm_offer_del', '1', '1', '2', 999, '416'),
(431, '解决方案管理', 'crm_program', '1', '1', '2', 999, '416'),
(432, '解决方案添加', 'crm_program_add', '1', '1', '2', 999, '416'),
(433, '解决方案编辑', 'crm_program_edit', '1', '1', '2', 999, '416'),
(434, '解决方案删除', 'crm_program_del', '1', '1', '2', 999, '416'),
(435, '合同管理', 'crm_contract', '1', '1', '2', 999, '416'),
(436, '合同添加', 'crm_contract_add', '1', '1', '2', 999, '416'),
(437, '合同编辑', 'crm_contract_edit', '1', '1', '2', 999, '416'),
(438, '合同删除', 'crm_contract_del', '1', '1', '2', 999, '416'),
(439, '订单管理', 'crm_order', '1', '1', '2', 999, '416'),
(440, '订单添加', 'crm_order_add', '1', '1', '2', 999, '416'),
(441, '订单编辑', 'crm_order_edit', '1', '1', '2', 999, '416'),
(442, '订单删除', 'crm_order_del', '1', '1', '2', 999, '416'),
(443, '代理商管理', 'crm_business', '1', '1', '2', 999, '420'),
(444, '代理商添加', 'crm_business_add', '1', '1', '2', 999, '420'),
(445, '代理商编辑', 'crm_business_edit', '1', '1', '2', 999, '420'),
(446, '代理商删除', 'crm_business_del', '1', '1', '2', 999, '420'),
(447, '联系人管理', 'crm_contact_2', '1', '1', '2', 999, '420'),
(448, '联系人添加', 'crm_contact_add_2', '1', '1', '2', 999, '420'),
(449, '联系人编辑', 'crm_contact_edit_2', '1', '1', '2', 999, '420'),
(450, '联系人删除', 'crm_contact_del_2', '1', '1', '2', 999, '420'),
(451, '客户投诉管理', 'crm_complaints_2', '1', '1', '2', 999, '420'),
(452, '客户投诉添加', 'crm_complaints_add_2', '1', '1', '2', 999, '420'),
(453, '客户投诉编辑', 'crm_complaints_edit_2', '1', '1', '2', 999, '420'),
(454, '客户投诉删除', 'crm_complaints_del_2', '1', '1', '2', 999, '420'),
(455, '客户关怀管理', 'crm_care_2', '1', '1', '2', 999, '420'),
(456, '客户关怀添加', 'crm_care_add_2', '1', '1', '2', 999, '420'),
(457, '客户关怀编辑', 'crm_care_edit_2', '1', '1', '2', 999, '420'),
(458, '客户关怀删除', 'crm_care_del_2', '1', '1', '2', 999, '420'),
(459, '产品类别设置', 'crm_pord_type', '1', '1', '2', 999, '419'),
(460, '产品信息管理', 'crm_product', '1', '1', '2', 999, '419'),
(461, '库存管理', 'crm_stock', '1', '1', '2', 999, '419'),
(462, '供应商管理', 'crm_supplier', '1', '1', '2', 999, '418'),
(463, '供应商添加', 'crm_supplier_add', '1', '1', '2', 999, '418'),
(464, '供应商编辑', 'crm_supplier_edit', '1', '1', '2', 999, '418'),
(465, '供应商删除', 'crm_supplier_del', '1', '1', '2', 999, '418'),
(466, '采购管理', 'crm_purchase', '1', '1', '2', 999, '418'),
(467, '采购添加', 'crm_purchase_add', '1', '1', '2', 999, '418'),
(468, '采购编辑', 'crm_purchase_edit', '1', '1', '2', 999, '418'),
(469, '采购删除', 'crm_purchase_del', '1', '1', '2', 999, '418'),
(470, '收款单管理', 'crm_price', '1', '1', '2', 999, '417'),
(471, '收款单添加', 'crm_price_add', '1', '1', '2', 999, '417'),
(472, '收款单编辑', 'crm_price_edit', '1', '1', '2', 999, '417'),
(473, '收款单删除', 'crm_price_del', '1', '1', '2', 999, '417'),
(474, '付款管理', 'crm_payment', '1', '1', '2', 999, '417'),
(475, '付款添加', 'crm_payment_add', '1', '1', '2', 999, '417'),
(476, '付款编辑', 'crm_payment_edit', '1', '1', '2', 999, '417'),
(477, '付款删除', 'crm_payment_del', '1', '1', '2', 999, '417'),
(478, '客户信息管理', 'crm_company', '1', '1', '2', 999, '415'),
(479, '客户信息添加', 'crm_company_add', '1', '1', '2', 999, '415'),
(480, '客户信息编辑', 'crm_company_edit', '1', '1', '2', 999, '415'),
(481, '客户信息删除', 'crm_company_del', '1', '1', '2', 999, '415'),
(482, '联系人管理', 'crm_contact_1', '1', '1', '2', 999, '415'),
(483, '联系人添加', 'crm_contact_add_1', '1', '1', '2', 999, '415'),
(484, '联系人编辑', 'crm_contact_edit_1', '1', '1', '2', 999, '415'),
(485, '联系人删除', 'crm_contact_del_1', '1', '1', '2', 999, '415'),
(486, '客户关怀管理', 'crm_care_1', '1', '1', '2', 999, '415'),
(487, '客户关怀添加', 'crm_care_add_1', '1', '1', '2', 999, '415'),
(488, '客户关怀编辑', 'crm_care_edit_1', '1', '1', '2', 999, '415'),
(489, '客户关怀删除', 'crm_care_del_1', '1', '1', '2', 999, '415'),
(490, '客户回访管理', 'crm_service', '1', '1', '2', 999, '415'),
(491, '客户回访添加', 'crm_service_add', '1', '1', '2', 999, '415'),
(492, '客户回访编辑', 'crm_service_edit', '1', '1', '2', 999, '415'),
(493, '客户回访删除', 'crm_service_del', '1', '1', '2', 999, '415'),
(494, '客户投诉管理', 'crm_complaints_1', '1', '1', '2', 999, '415'),
(495, '客户投诉添加', 'crm_complaints_add_1', '1', '1', '2', 999, '415'),
(496, '客户投诉编辑', 'crm_complaints_edit_1', '1', '1', '2', 999, '415'),
(497, '客户投诉删除', 'crm_complaints_del_1', '1', '1', '2', 999, '415'),
(498, '报表导出权限', 'input_excel', '1', '1', '2', 999, '414'),
(499, '客户信息', 'crm_company_excel', '1', '1', '2', 999, '498'),
(500, '联系人', 'crm_contact_excel_1', '1', '1', '2', 999, '498'),
(501, '客户关怀', 'crm_care_excel_1', '1', '1', '2', 999, '498'),
(502, '客户回访', 'crm_service_excel', '1', '1', '2', 999, '498'),
(503, '客户投诉', 'crm_complaints_excel_1', '1', '1', '2', 999, '498'),
(504, '报价单', 'crm_offer_excel', '1', '1', '2', 999, '498'),
(505, '解决方案', 'crm_program_excel', '1', '1', '2', 999, '498'),
(506, '合同', 'crm_contract_excel', '1', '1', '2', 999, '498'),
(507, '订单', 'crm_order_excel', '1', '1', '2', 999, '498'),
(508, '收款单', 'crm_price_excel', '1', '1', '2', 999, '498'),
(509, '付款', 'crm_payment_excel', '1', '1', '2', 999, '498'),
(510, '供应商', 'crm_supplier_excel', '1', '1', '2', 999, '498'),
(511, '采购', 'crm_purchase_excel', '1', '1', '2', 999, '498'),
(512, '产品信息', 'crm_product_excel', '1', '1', '2', 999, '498'),
(513, '库存', 'crm_stock_excel', '1', '1', '2', 999, '498'),
(514, '代理商', 'crm_business_excel', '1', '1', '2', 999, '498'),
(515, '联系人[代理商]', 'crm_contact_excel_2', '1', '1', '2', 999, '498'),
(516, '客户投诉[代理商]', 'crm_complaints_excel_2', '1', '1', '2', 999, '498'),
(517, '客户关怀[代理商]', 'crm_care_excel_2', '1', '1', '2', 999, '498');
