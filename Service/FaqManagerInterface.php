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

use Krystal\Stdlib\VirtualEntity;

interface FaqManagerInterface
{
    /**
     * Update settings
     * 
     * @param array $settings
     * @return boolean
     */
    public function updateSettings(array $settings);

    /**
     * Fetches all entities filtered by pagination
     * 
     * @param boolean $published Whether to filter by published records
     * @param string $categoryId Optional category id
     * @param integer $page Current page number
     * @param integer $itemsPerPage Per page count
     * @return array
     */
    public function fetchAllByPage($published, $categoryId, $page, $itemsPerPage);

    /**
     * Fetches all published entities
     * 
     * @param string $categoryId Optional category id
     * @return array
     */
    public function fetchAllPublished($categoryId = null);

    /**
     * Adds a FAQ
     * 
     * @param array $input Raw form data
     * @return boolean
     */
    public function add(array $input);

    /**
     * Updates a FAQ
     * 
     * @param array $input Raw form data
     * @return boolean
     */
    public function update(array $input);

    /**
     * Returns last faq id
     * 
     * @return integer
     */
    public function getLastId();

    /**
     * Returns prepared paginator's instance
     * 
     * @return \Krystal\Paginate\Pagination
     */
    public function getPaginator();

    /**
     * Fetches a faq bag by its associated id
     * 
     * @param string $id Faq id
     * @param boolean $withTranslations Whether to fetch translations or not
     * @return boolean|\Krystal\Stdlib\VirtualBag|boolean
     */
    public function fetchById($id, $withTranslations);

    /**
     * Deletes a faq by its associated id
     * 
     * @param string $id Faq id
     * @return boolean
     */
    public function deleteById($id);

    /**
     * Deletes faqs by their associated ids
     * 
     * @param array $ids Array of ids
     * @return boolean
     */
    public function deleteByIds(array $ids);
}
