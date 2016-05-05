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
    
    '/%s/module/faq' => array(
        'controller' => 'Admin:Faq@gridAction',
    ),
    
    '/%s/module/faq/page/(:var)' => array(
        'controller' => 'Admin:Faq@gridAction',
    ),
    
    '/%s/module/faq/delete/(:var)' => array(
        'controller' => 'Admin:Faq@deleteAction',
        'disallow' => array('guest')
    ),
    
    '/%s/module/faq/tweak' => array(
        'controller' => 'Admin:Faq@tweakAction',
        'disallow' => array('guest')
    ),
    
    '/%s/module/faq/add' => array(
        'controller' => 'Admin:Faq@addAction'
    ),
    
    '/%s/module/faq/edit/(:var)' => array(
        'controller' => 'Admin:Faq@editAction'
    ),
    
    '/%s/module/faq/save' => array(
        'controller' => 'Admin:Faq@saveAction',
        'disallow' => array('guest')
    )
);
