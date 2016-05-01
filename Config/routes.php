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
        'controller' => 'Admin:Faq@gridAction',
    ),
    
    '/admin/module/faq/page/(:var)' => array(
        'controller' => 'Admin:Faq@gridAction',
    ),
    
    '/admin/module/faq/delete/(:var)' => array(
        'controller' => 'Admin:Faq@deleteAction',
        'disallow' => array('guest')
    ),
    
    '/admin/module/faq/tweak' => array(
        'controller' => 'Admin:Faq@tweakAction',
        'disallow' => array('guest')
    ),
    
    '/admin/module/faq/add' => array(
        'controller' => 'Admin:Faq@addAction'
    ),
    
    '/admin/module/faq/edit/(:var)' => array(
        'controller' => 'Admin:Faq@editAction'
    ),
    
    '/admin/module/faq/save' => array(
        'controller' => 'Admin:Faq@saveAction',
        'disallow' => array('guest')
    )
);
