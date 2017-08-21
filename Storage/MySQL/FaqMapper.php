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
use Faq\Storage\FaqMapperInterface;
use Krystal\Db\Sql\RawSqlFragment;

final class FaqMapper extends AbstractMapper implements FaqMapperInterface
{
    /**
     * {@inheritDoc}
     */
    public static function getTableName()
    {
        return self::getWithPrefix('bono_module_faq');
    }

    /**
     * {@inheritDoc}
     */
    public static function getTranslationTable()
    {
        return FaqTranslationMapper::getTableName();
    }

    /**
     * Returns shared columns to be selected
     * 
     * @return array
     */
    private function getColumns()
    {
        return array(
            self::getFullColumnName('id'),
            self::getFullColumnName('category_id'),
            self::getFullColumnName('published'),
            self::getFullColumnName('order'),
            FaqTranslationMapper::getFullColumnName('lang_id'),
            FaqTranslationMapper::getFullColumnName('question'),
            FaqTranslationMapper::getFullColumnName('answer')
        );
    }

    /**
     * Fetches question name by its associated id
     * 
     * @param string $id FAQ id
     * @return string
     */
    public function fetchQuestionById($id)
    {
        return $this->findColumnByPk($id, 'question');
    }

    /**
     * Update published state by its associated FAQ id
     * 
     * @param integer $id
     * @param string $published Either 0 or 1
     * @return boolean
     */
    public function updatePublishedById($id, $published)
    {
        return $this->updateColumnByPk($id, 'published', $published);
    }

    /**
     * Update an order by record's associated id
     * 
     * @param string $id
     * @param integer $order New sort order
     * @return boolean
     */
    public function updateOrderById($id, $order)
    {
        return $this->updateColumnByPk($id, 'order', $order);
    }

    /**
     * Fetches all FAQs filtered by pagination
     * 
     * @param boolean $published Whether to filter by published records
     * @param string $categoryId Optional category id
     * @param integer $page Current page number
     * @param integer $itemsPerPage Per page count
     * @return \Krystal\Db\Sql\Db
     */
    public function fetchAllByPage($published, $categoryId = null, $page = null, $itemsPerPage = null)
    {
        $db = $this->createEntitySelect($this->getColumns())
                   ->whereEquals(FaqTranslationMapper::getFullColumnName('lang_id'), $this->getLangId());

        if (!is_null($categoryId)) {
            $db->andWhereEquals(self::getFullColumnName('category_id'), $categoryId);
        }

        if ($published === true) {
            $db->andWhereEquals(self::getFullColumnName('published'), '1')
               ->orderBy(new RawSqlFragment(sprintf('`order`, CASE WHEN `order` = 0 THEN %s END DESC', self::getFullColumnName('id'))));
        } else {
            $db->orderBy(self::getFullColumnName('id'))
               ->desc();
        }

        // Optional pagination
        if ($page !== null && $itemsPerPage !== null) {
            $db->paginate($page, $itemsPerPage);
        }

        return $db->queryAll();
    }

    /**
     * Delete all items by associated category ID
     * 
     * @param string $categoryId
     * @return boolean
     */
    public function deleteAllByCategoryId($categoryId)
    {
        return $this->deleteByColumn('category_id', $categoryId);
    }

    /**
     * Fetches FAQ's data by its associated id
     * 
     * @param string $id FAQ's id
     * @param boolean $withTranslations Whether to fetch translations or not
     * @return array
     */
    public function fetchById($id, $withTranslations)
    {
        return $this->findEntity($this->getColumns(), $id, $withTranslations);
    }
}
