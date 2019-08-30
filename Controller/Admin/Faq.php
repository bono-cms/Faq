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
     * Creates a grid
     * 
     * @param integer $page Page number
     * @param string $categoryId Category ID filter
     * @return string
     */
    private function createGrid($page, $categoryId)
    {
        // Append a breadcrumb
        $this->view->getBreadcrumbBag()
                   ->addOne('FAQ');

        // Configure pagination URL
        if ($categoryId !== null) {
            $url = $this->createUrl('Faq:Admin:Faq@categoryAction', array($categoryId), 1);
        } else {
            $url = $this->createUrl('Faq:Admin:Faq@gridAction', array(), 1);
        }

        $paginator = $this->getFaqManager()->getPaginator();
        $paginator->setUrl($url);

        return $this->view->render('browser', array(
            'paginator' => $paginator,
            'faqs' => $this->getFaqManager()->fetchAllByPage(false, $categoryId, $page, $this->getSharedPerPageCount()),
            'categories' => $this->getModuleService('categoryManager')->fetchAll(false),
            'categoryId' => $categoryId
        ));
    }

    /**
     * Creates a form
     * 
     * @param \Krystal\Stdlib\VirtualEntity|array $faq
     * @param string $title
     * @return string
     */
    private function createForm($faq, $title)
    {
        // Load view plugins
        $this->view->getPluginBag()
                   ->load($this->getWysiwygPluginName());

        // Append breadcrumbs
        $this->view->getBreadcrumbBag()->addOne('FAQ', 'Faq:Admin:Faq@gridAction')
                                       ->addOne($title);

        return $this->view->render('faq.form', array(
            'categories' => $this->getModuleService('categoryManager')->fetchList(),
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
        $faq = $this->getFaqManager()->fetchById($id, true);

        if ($faq !== false) {
            $name = $this->getCurrentProperty($faq, 'question');
            return $this->createForm($faq, $this->translator->translate('Edit the FAQ "%s"', $name));
        } else {
            return false;
        }
    }

    /**
     * Filter FAQ items by category
     * 
     * @param string $categoryId Category ID filter
     * @param integer $page Page number
     * @return string
     */
    public function categoryAction($categoryId, $page = 1)
    {
        return $this->createGrid($page, $categoryId);
    }

    /**
     * Renders the grid
     * 
     * @param string $page Current page
     * @return string
     */ 
    public function gridAction($page = 1)
    {
        return $this->createGrid($page, null);
    }

    /**
     * Saves options
     * 
     * @return string
     */
    public function tweakAction()
    {
        if ($this->request->hasPost('published', 'order')) {
            $faqManager = $this->getFaqManager();
            $faqManager->updateSettings($this->request->getPost());

            $this->flashBag->set('success', 'Settings have been save successfully');
            return '1';
        }
    }

    /**
     * Deletes a FAQ by its associated id
     * 
     * @param string $id
     * @return string
     */
    public function deleteAction($id)
    {
        $historyService = $this->getService('Cms', 'historyManager');
        $service = $this->getModuleService('faqManager');

        // Batch removal
        if ($this->request->hasPost('batch')) {
            $ids = array_keys($this->request->getPost('batch'));

            $service->deleteByIds($ids);
            $this->flashBag->set('success', 'Selected elements have been removed successfully');

            $historyService->write('Faq', 'Batch removal of %s faq', count($ids));

        } else {
            $this->flashBag->set('warning', 'You should select at least one element to remove');
        }

        // Single removal
        if (!empty($id)) {
            $faq = $this->getFaqManager()->fetchById($id, false);

            $service->deleteById($id);
            $this->flashBag->set('success', 'Selected element has been removed successfully');

            // Save in history
            $historyService->write('Faq', 'FAQ "%s" has been removed', $faq->getQuestion());
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
        $input = $this->request->getPost();

        $formValidator = $this->createValidator(array(
            'input' => array(
                'source' => $input['faq'],
                'definition' => array(
                    'question' => new Pattern\Title(),
                    'answer' => new Pattern\Content()
                )
            )
        ));

        if (1) {
            $service = $this->getModuleService('faqManager');
            $historyService = $this->getService('Cms', 'historyManager');

            // Current page name
            $name = $this->getCurrentProperty($this->request->getPost('translation'), 'question');

            if (!empty($input['faq']['id'])) {
                if ($service->update($input)) {
                    $this->flashBag->set('success', 'The element has been updated successfully');
                    $historyService->write('Faq', 'FAQ "%s" has been updated', $name);
                    return '1';
                }

            } else {
                if ($service->add($input)) {
                    $this->flashBag->set('success', 'The element has been created successfully');

                    $historyService->write('Faq', 'FAQ "%s" has been added', $name);
                    return $service->getLastId();
                }
            }

        } else {
            return $formValidator->getErrors();
        }
    }
}
