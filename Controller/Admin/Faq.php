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
                   ->appendScript('@Faq/admin/faq.form.js')
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
        // Batch removal
        if ($this->request->hasPost('toDelete')) {
            $this->getFaqManager()->deleteByIds(array_keys($this->request->getPost('toDelete')));
            $this->flashBag->set('success', 'Selected FAQS have been removed successfully');
            
        } else {
            $this->flashBag->set('warning', 'You should select at least one FAQ to remove');
        }

        // Single removal
        if ($this->request->hasPost('id') && $this->request->isAjax()) {
            $id = $this->request->getPost('id');

            if ($this->getFaqManager()->deleteById($id)) {
                $this->flashBag->set('success', 'The FAQ has been removed successfully');
            }
        }

        return '1';
    }
    
    /**
     * Persists a faq
     * 
     * @return string
     */
    public function saveAction()
    {
        $input = $this->request->getPost('faq');

        $formValidator = $this->validatorFactory->build(array(
            'input' => array(
                'source' => $input,
                'definition' => array(
                    'question' => new Pattern\Title(),
                    'answer' => new Pattern\Content()
                )
            )
        ));

        if ($formValidator->isValid()) {
            $faqManager = $this->getFaqManager();

            if ($input['id']) {
                if ($faqManager->update($input)) {
                    $this->flashBag->set('success', 'The FAQ has been updated successfully');
                    return '1';
                }

            } else {
                if ($faqManager->add($input)) {
                    $this->flashBag->set('success', 'A faq has been created successfully');
                    return $faqManager->getLastId();
                }
            }
        } else {
            return $formValidator->getErrors();
        }
    }
}
