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

use Cms\Controller\Admin\AbstractController;
use Krystal\Stdlib\VirtualEntity;
use Krystal\Validate\Pattern;

final class Category extends AbstractController
{
    /**
     * Creates a form
     * 
     * @param \Krystal\Stdlib\VirtualEntity $category
     * @param string $title
     * @return string
     */
    private function createForm(VirtualEntity $category, $title)
    {
        // Append breadcrumbs
        $this->view->getBreadcrumbBag()->addOne('FAQ', 'Faq:Admin:Faq@gridAction')
                                       ->addOne($title);

        return $this->view->render('category.form', array(
            'category' => $category
        ));
    }

    /**
     * Adds a category
     * 
     * @return string
     */
    public function addAction()
    {
        return $this->createForm(new VirtualEntity(), 'Add a category');
    }

    /**
     * Returns edit page
     * 
     * @param string $id
     * @return string
     */
    public function editAction($id)
    {
        $category = $this->getModuleService('categoryManager')->fetchById($id);

        if ($category !== false) {
            return $this->createForm($category, 'Edit the category');
        } else {
            return false;
        }
    }

    /**
     * Deletes a category by its associated id
     * 
     * @param string $id
     * @return string
     */
    public function deleteAction($id)
    {
        return $this->invokeRemoval('categoryManager', $id);
    }

    /**
     * Persists a category
     * 
     * @return string
     */
    public function saveAction()
    {
        $input = $this->request->getPost('category');

        return $this->invokeSave('categoryManager', $input['id'], $this->request->getPost(), array(
            'input' => array(
                'source' => $input,
                'definition' => array(
                    'name' => new Pattern\Name()
                )
            )
        ));
    }
}
