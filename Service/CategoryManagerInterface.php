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

interface CategoryManagerInterface
{
    /**
     * Fetches a list as id => name pair
     * 
     * @return array
     */
    public function fetchList();
    
    /**
     * Fetch all category entities
     * 
     * @param boolean $sort Whether to use sorting by order attribute or not
     * @return array
     */
    public function fetchAll($sort);

    /**
     * Finds category entity by its id
     * 
     * @param string $id Category id
     * @return \Krystal\Stdlib\VirtualEntity|boolean
     */
    public function fetchById($id);

    /**
     * Returns category last id
     * 
     * @return integer
     */
    public function getLastId();

    /**
     * Deletes a category by its id
     * 
     * @param string $id Category id
     * @return boolean
     */
    public function deleteById($id);

    /**
     * Updates a category
     * 
     * @param array $input
     * @return boolean
     */
    public function update(array $input);

    /**
     * Adds a category
     * 
     * @param array $input
     * @return boolean
     */
    public function add(array $input);
}
