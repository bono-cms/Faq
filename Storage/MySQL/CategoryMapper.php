<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Faq\Storage\MySQL;

use Cms\Storage\MySQL\AbstractMapper;
use Faq\Storage\CategoryMapperInterface;
use Krystal\Db\Sql\RawSqlFragment;

final class CategoryMapper extends AbstractMapper implements CategoryMapperInterface
{
    /**
     * {@inheritDoc}
     */
    public static function getTableName()
    {
        return self::getWithPrefix('bono_module_faq_categories');
    }

    /**
     * Adds a new category
     * 
     * @param array $data
     * @return boolean
     */
    public function insert(array $data)
    {
        return $this->persist($this->getWithLang($data));
    }

    /**
     * Updates a category
     * 
     * @param array $data
     * @return boolean
     */
    public function update(array $data)
    {
        return $this->persist($data);
    }

    /**
     * Deletes a category by its associated id
     * 
     * @param string $id
     * @return boolean
     */
    public function deleteById($id)
    {
        return $this->deleteByPk($id);
    }

    /**
     * Find category data by its associated id
     * 
     * @param string $id
     * @return array
     */
    public function fetchById($id)
    {
        return $this->findByPk($id);
    }

    /**
     * Fetch all categories
     * 
     * @param boolean $sort Whether to use sorting by order attribute or not
     * @return array
     */
    public function fetchAll($sort)
    {
        $db = $this->db->select('*')
                       ->from(self::getTableName())
                       ->whereEquals('lang_id', $this->getLangId());

        if ($sort === true) {
            $db->orderBy(new RawSqlFragment('`order`, CASE WHEN `order` = 0 THEN `id` END DESC'));
        } else {
            $db->orderBy('id')
               ->desc();
        }

        return $db->queryAll();
    }
}
