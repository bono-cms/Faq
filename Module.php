<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Faq;

use Cms\AbstractCmsModule;
use Faq\Service\FaqManager;
use Faq\Service\CategoryManager;

final class Module extends AbstractCmsModule
{
    /**
     * {@inheritDoc}
     */
    public function getServiceProviders()
    {
        // Build mappers
        $faqMapper = $this->getMapper('/Faq/Storage/MySQL/FaqMapper');
        $categoryMapper = $this->getMapper('/Faq/Storage/MySQL/CategoryMapper');

        return array(
            'faqManager' => new FaqManager($faqMapper),
            'categoryManager' => new CategoryManager($categoryMapper, $faqMapper)
        );
    }
}
