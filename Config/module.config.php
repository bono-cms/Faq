<?php

/**
 * Module configuration container
 */

return array(
    'name'  => 'Faq',
    'description' => 'FAQ module allows you to manage set of FAQs on your site',
    'menu' => array(
        'name' => 'Faq',
        'icon' => 'fas fa-question',
        'items' => array(
            array(
                'route' => 'Faq:Admin:Faq@gridAction',
                'name' => 'View all FAQs'
            ),
            array(
                'route' => 'Faq:Admin:Faq@addAction',
                'name' => 'Add new FAQ'
            ),
            array(
                'route' => 'Faq:Admin:Category@addAction',
                'name' => 'Add a category'
            )
        )
    )
);