<?php
//宏控件为下拉式，显示最新100条数据
//title:控件名称；table:表名；name:下拉显示名称;value:值；order:排序id

if (!defined('IN_TOA')) {exit('Access Denied!');}

$_CACHE['magnificent'] = array (
  'toa_auto' => 
  array (
  	'mod' => 'toa_auto',
    'title' => '用车管理',
	'table' => 'auto',
    'name' => 'number',
    'value' => 'number',
	'order' => 'id',
  ),
  'toa_blog' => 
  array (
  	'mod' => 'toa_blog',
    'title' => '工作日志',
	'table' => 'blog',
    'name' => 'title',
    'value' => 'title',
	'order' => 'id',
  ),
  'toa_plan' => 
  array (
  	'mod' => 'toa_plan',
    'title' => '工作计划',
	'table' => 'plan',
    'name' => 'title',
    'value' => 'title',
	'order' => 'id',
  ),
  'toa_duty' => 
  array (
  	'mod' => 'toa_duty',
    'title' => '任务管理',
	'table' => 'duty',
    'name' => 'title',
    'value' => 'title',
	'order' => 'id',
  ),
  'toa_crm_company' => 
  array (
  	'mod' => 'toa_crm_company',
    'title' => '客户信息',
	'table' => 'crm_company',
    'name' => 'title',
    'value' => 'title',
	'order' => 'id',
  ),
  'toa_book' => 
  array (
  	'mod' => 'toa_book',
    'title' => '图书管理',
	'table' => 'book',
    'name' => 'bookname',
    'value' => 'bookname',
	'order' => 'id',
  ),
  'toa_property' => 
  array (
  	'mod' => 'toa_property',
    'title' => '资产管理',
	'table' => 'property',
    'name' => 'name',
    'value' => 'name',
	'order' => 'id',
  ),
  'toa_office_goods' => 
  array (
  	'mod' => 'toa_office_goods',
    'title' => '办公用品',
	'table' => 'office_goods',
    'name' => 'title',
    'value' => 'title',
	'order' => 'id',
  ),
  'toa_conference' => 
  array (
  	'mod' => 'toa_conference',
    'title' => '会议管理',
	'table' => 'conference',
    'name' => 'title',
    'value' => 'title',
	'order' => 'id',
  ),
  'toa_file' => 
  array (
  	'mod' => 'toa_file',
    'title' => '档案管理',
	'table' => 'file',
    'name' => 'filename',
    'value' => 'filename',
	'order' => 'id',
  ),
);

?>