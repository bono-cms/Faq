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
            self::column('id'),
            self::column('category_id'),
            self::column('published'),
            self::column('order'),
            FaqTranslationMapper::column('lang_id'),
            FaqTranslationMapper::column('question'),
            FaqTranslationMapper::column('answer')
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
     * Update settings
     * 
     * @param array $settings
     * @return boolean
     */
    public function updateSettings(array $settings)
    {
        return $this->updateColumns($settings, array('order', 'published'));
    }

    /**
     * Fetches all FAQs filtered by pagination
     * 
     * @param boolean $published Whether to filter by published records
     * @param string $categoryId Optional category id
     * @param integer $page Current page number
     * @param integer $itemsPerPage Per page count
     * @return array
     */
    public function fetchAllByPage($published, $categoryId = null, $page = null, $itemsPerPage = null)
    {
        $db = $this->createEntitySelect($this->getColumns())
                   ->whereEquals(FaqTranslationMapper::column('lang_id'), $this->getLangId());

        if (!is_null($categoryId)) {
            $db->andWhereEquals(self::column('category_id'), $categoryId);
        }

        if ($published === true) {
            $db->andWhereEquals(self::column('published'), '1')
               ->orderBy(new RawSqlFragment(sprintf('`order`, CASE WHEN `order` = 0 THEN %s END DESC', self::column('id'))));
        } else {
            $db->orderBy(self::column('id'))
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
