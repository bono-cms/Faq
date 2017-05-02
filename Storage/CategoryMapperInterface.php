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

interface CategoryMapperInterface
{
    /**
     * Adds a new category
     * 
     * @param array $data
     * @return boolean
     */
    public function insert(array $data);

    /**
     * Updates a category
     * 
     * @param array $data
     * @return boolean
     */
    public function update(array $data);

    /**
     * Deletes a category by its associated id
     * 
     * @param string $id
     * @return boolean
     */
    public function deleteById($id);

    /**
     * Find category data by its associated id
     * 
     * @param string $id
     * @return array
     */
    public function fetchById($id);
    
    /**
     * Fetch all categories
     * 
     * @param boolean $sort Whether to use sorting by order attribute or not
     * @return array
     */
    public function fetchAll($sort);
}
