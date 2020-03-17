<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Faq\Storage;

interface FaqMapperInterface
{
    /**
     * Fetches question name by its associated id
     * 
     * @param string $id
     * @return string
     */
    public function fetchQuestionById($id);

    /**
     * Update settings
     * 
     * @param array $settings
     * @return boolean
     */
    public function updateSettings(array $settings);

    /**
     * Fetches all FAQs filtered by pagination
     * 
     * @param boolean $published Whether to filter by published records
     * @param string $categoryId Optional category id
     * @param integer $page Current page number
     * @param integer $limit Per page count
     * @return \Krystal\Db\Sql\Db
     */
    public function fetchAllByPage($published, $categoryId = null, $page = null, $limit = null);

    /**
     * Delete all items by associated category ID
     * 
     * @param string $categoryId
     * @return boolean
     */
    public function deleteAllByCategoryId($categoryId);

    /**
     * Fetches FAQ's data by its associated id
     * 
     * @param string $id FAQ's id
     * @param boolean $withTranslations Whether to fetch translations or not
     * @return array
     */
    public function fetchById($id, $withTranslations);
}
