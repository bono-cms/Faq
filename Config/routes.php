<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

return array(
	
	'/module/faq' => array(
		'controller' => 'Faq@indexAction'
	),
	
	'/admin/module/faq' => array(
		'controller' => 'Admin:Browser@indexAction',
	),
	
	'/admin/module/faq/page/(:var)' => array(
		'controller' => 'Admin:Browser@indexAction',
	),
	
	'/admin/module/faq/delete.ajax' => array(
		'controller' => 'Admin:Browser@deleteAction',
		'disallow' => array('guest')
	),
	
	'/admin/module/faq/delete-selected.ajax' => array(
		'controller' => 'Admin:Browser@deleteSelectedAction',
		'disallow' => array('guest')
	),
	
	'/admin/module/faq/save.ajax' => array(
		'controller' => 'Admin:Browser@saveAction',
		'disallow' => array('guest')
	),
	
	'/admin/module/faq/add' => array(
		'controller' => 'Admin:Add@indexAction'
	),
	
	'/admin/module/faq/add.ajax' => array(
		'controller' => 'Admin:Add@addAction',
		'disallow' => array('guest')
	),
	
	'/admin/module/faq/edit/(:var)'	=> array(
		'controller' => 'Admin:Edit@indexAction'
	),
	
	'/admin/module/faq/edit.ajax' => array(
		'controller' => 'Admin:Edit@updateAction',
		'disallow' => array('guest')
	),
);
