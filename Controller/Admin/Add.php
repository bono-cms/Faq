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

use Krystal\Stdlib\VirtualEntity;

final class Add extends AbstractFaq
{
    /**
     * Shows adding form
     * 
     * @return string
     */
    public function indexAction()
    {
        $this->loadSharedPlugins();
        $this->loadBreadcrumbs('Add new FAQ');

        $faq = new VirtualEntity();
        $faq->setPublished(true);

        return $this->view->render($this->getTemplatePath(), array(
            'title' => 'Add new FAQ',
            'faq' => $faq
        ));
    }

    /**
     * Adds a FAQ
     * 
     * @return string
     */
    public function addAction()
    {
        $formValidator = $this->getValidator($this->request->getPost('faq'));

        if ($formValidator->isValid()) {
            $faqManager = $this->getFaqManager();

            if ($faqManager->add($this->request->getPost('faq'))) {
                $this->flashBag->set('success', 'A faq has been created successfully');
                return $faqManager->getLastId();
            }

        } else {
            return $formValidator->getErrors();
        }
    }
}