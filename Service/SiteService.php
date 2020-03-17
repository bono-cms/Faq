<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Faq\Service;

final class SiteService
{
    /**
     * Faq service
     * 
     * @var \Faq\Service\FaqManager
     */
    private $faqManager;

    /**
     * State initialization
     * 
     * @param \Faq\Service\FaqManager $faqManager
     * @return void
     */
    public function __construct(FaqManager $faqManager)
    {
        $this->faqManager = $faqManager;
    }

    /**
     * Get all FAQs
     * 
     * @param mixed $limit
     * @return array
     */
    public function getAll($limit = null)
    {
        return $this->faqManager->fetchAllPublished(null, $limit);
    }
}
