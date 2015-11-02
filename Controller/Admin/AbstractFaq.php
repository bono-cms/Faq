<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Faq\Controller\Admin;

use Krystal\Validate\Pattern;

abstract class AbstractFaq extends AbstractAdminController
{
    /**
     * Returns configured form validator
     * 
     * @param array $input Raw input data
     * @return \Krystal\Validate\ValidatorChain
     */
    final protected function getValidator(array $input)
    {
        return $this->validatorFactory->build(array(
            'input' => array(
                'source' => $input,
                'definition' => array(
                    'question' => new Pattern\Title(),
                    'answer' => new Pattern\Content()
                )
            )
        ));
    }

    /**
     * Loads breadcrumbs
     * 
     * @param string $title
     * @return void
     */
    final protected function loadBreadcrumbs($title)
    {
        $this->view->getBreadcrumbBag()->addOne('FAQ', 'Faq:Admin:Browser@indexAction')
                                       ->addOne($title);
    }

    /**
     * Loads shared plugins
     * 
     * @return void
     */
    final protected function loadSharedPlugins()
    {
        $this->view->getPluginBag()
                   ->appendScript('@Faq/admin/faq.form.js')
                   ->load($this->getWysiwygPluginName());
    }

    /**
     * Returns template path
     * 
     * @return string
     */
    final protected function getTemplatePath()
    {
        return 'faq.form';
    }
}
