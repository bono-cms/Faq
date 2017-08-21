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
     * Update published state by its associated FAQ's id
     * 
     * @param integer $id
     * @param string $published Either 0 or 1
     * @return boolean
     */
    public function updatePublishedById($id, $published);

    /**
     * Update an order by its associated FAQ id
     * 
     * @param string $id
     * @param integer $order New sort order
     * @return boolean
     */
    public function updateOrderById($id, $order);

    /**
     * Fetches all FAQs filtered by pagination
     * 
     * @param boolean $published Whether to filter by published records
     * @param string $categoryId Optional category id
     * @param integer $page Current page number
     * @param integer $itemsPerPage Per page count
     * @return \Krystal\Db\Sql\Db
     */
    public function fetchAllByPage($published, $categoryId = null, $page = null, $itemsPerPage = null);

    /**
     * Inserts a record
     * 
     * @param array $data
     * @return boolean
     */
    public function insert(array $data);

    /**
     * Updates a record
     * 
     * @param array $data
     * @return boolean
     */
    public function update(array $data);

    /**
     * Delete all items by associated category ID
     * 
     * @param string $categoryId
     * @return boolean
     */
    public function deleteAllByCategoryId($categoryId);

    /**
     * Deletes a FAQ by its associated id
     * 
     * @param string $id
     * @return boolean
     */
    public function deleteById($id);

    /**
     * Fetches FAQ's data by its associated id
     * 
     * @param string $id FAQ's id
     * @param boolean $withTranslations Whether to fetch translations or not
     * @return array
     */
    public function fetchById($id, $withTranslations);
}
