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
use Krystal\Stdlib\VirtualEntity;
use Cms\Controller\Admin\AbstractController;

final class Faq extends AbstractController
{
    /**
     * Returns FAQ manager
     * 
     * @return \Faq\Service\FaqManager
     */
    private function getFaqManager()
    {
        return $this->getModuleService('faqManager');
    }

    /**
     * Creates a form
     * 
     * @param \Krystal\Stdlib\VirtualEntity $faq
     * @param string $title
     * @return string
     */
    private function createForm(VirtualEntity $faq, $title)
    {
        // Load view plugins
        $this->view->getPluginBag()
                   ->load($this->getWysiwygPluginName());

        // Append breadcrumbs
        $this->view->getBreadcrumbBag()->addOne('FAQ', 'Faq:Admin:Faq@gridAction')
                                       ->addOne($title);

        return $this->view->render('faq.form', array(
            'faq' => $faq
        ));
    }

    /**
     * Renders empty form
     * 
     * @return string
     */
    public function addAction()
    {
        $faq = new VirtualEntity();
        $faq->setPublished(true);

        return $this->createForm($faq, 'Add new FAQ');
    }
    
    /**
     * Renders edit form
     * 
     * @param string $id
     * @return string
     */
    public function editAction($id)
    {
        $faq = $this->getFaqManager()->fetchById($id);

        if ($faq !== false) {
            return $this->createForm($faq, 'Edit the FAQ');
        } else {
            return false;
        }
    }

    /**
     * Renders the grid
     * 
     * @param string $page Current page
     * @return string
     */ 
    public function gridAction($page = 1)
    {
        $this->view->getPluginBag()
                   ->appendScript('@Faq/admin/browser.js');

        $this->view->getBreadcrumbBag()
                   ->addOne('FAQ');

        $paginator = $this->getFaqManager()->getPaginator();
        $paginator->setUrl('/admin/module/faq/page/(:var)');

        return $this->view->render('browser', array(
            'paginator' => $paginator,
            'faqs' => $this->getFaqManager()->fetchAllByPage($page, $this->getSharedPerPageCount(), false)
        ));
    }

    /**
     * Saves options
     * 
     * @return string
     */
    public function tweakAction()
    {
        if ($this->request->hasPost('published', 'order') && $this->request->isAjax()) {
            $published = $this->request->getPost('published');
            $orders = $this->request->getPost('order');

            $faqManager = $this->getFaqManager();

            $faqManager->updatePublished($published);
            $faqManager->updateOrders($orders);

            $this->flashBag->set('success', 'Settings have been save successfully');
            return '1';
        }
    }

    /**
     * Deletes a FAQ by its associated id
     * 
     * @return string
     */
    public function deleteAction()
    {
        return $this->invokeRemoval('faqManager');
    }

    /**
     * Persists a faq
     * 
     * @return string
     */
    public function saveAction()
    {
        $input = $this->request->getPost('faq');

        return $this->invokeSave('faqManager', $input['id'], $input, array(
            'input' => array(
                'source' => $input,
                'definition' => array(
                    'question' => new Pattern\Title(),
                    'answer' => new Pattern\Content()
                )
            )
        ));
    }
}
