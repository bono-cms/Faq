<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Faq\Controller;

use Site\Controller\AbstractController;

final class Faq extends AbstractController
{
    /**
     * Shows FAQ page
     * 
     * @param string $id Page id
     * @return string
     */
    public function indexAction($id)
    {
        $pageManager = $this->getService('Pages', 'pageManager');
        $page = $pageManager->fetchById($id);

        if ($page !== false) {
            $this->loadSitePlugins();

            $faqManager = $this->getModuleService('faqManager');

            // Append breadcrumbs no
            $this->view->getBreadcrumbBag()->addOne($page->getName());

            return $this->view->render('faq', array(
                'faqs' => $faqManager->fetchAllPublished(),
                'page' => $page,
                'languages' => $pageManager->getSwitchUrls($id)
            ));

        } else {
            return false;
        }
    }
}
