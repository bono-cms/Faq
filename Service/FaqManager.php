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

use Cms\Service\AbstractManager;
use Faq\Storage\FaqMapperInterface;
use Krystal\Stdlib\VirtualEntity;

final class FaqManager extends AbstractManager implements FaqManagerInterface
{
    /**
     * Any compliant faq mapper
     * 
     * @var \Faq\Storage\FaqMapperInterface
     */
    private $faqMapper;

    /**
     * State initialization
     * 
     * @param \Faq\Storage\FaqMapperInterface $faqMapper
     * @return void
     */
    public function __construct(FaqMapperInterface $faqMapper)
    {
        $this->faqMapper = $faqMapper;
    }

    /**
     * {@inheritDoc}
     */
    protected function toEntity(array $faq)
    {
        $entity = new VirtualEntity();
        $entity->setId($faq['id'], VirtualEntity::FILTER_INT)
            ->setCategoryId($faq['category_id'], VirtualEntity::FILTER_INT)
            ->setLangId($faq['lang_id'], VirtualEntity::FILTER_INT)
            ->setQuestion($faq['question'], VirtualEntity::FILTER_HTML)
            ->setAnswer($faq['answer'], VirtualEntity::FILTER_SAFE_TAGS)
            ->setOrder($faq['order'], VirtualEntity::FILTER_INT)
            ->setPublished($faq['published'], VirtualEntity::FILTER_BOOL);

        return $entity;
    }

    /**
     * Update settings
     * 
     * @param array $settings
     * @return boolean
     */
    public function updateSettings(array $settings)
    {
        return $this->faqMapper->updateSettings($settings);
    }

    /**
     * Fetches all entities filtered by pagination
     * 
     * @param integer $page Current page number
     * @param integer $itemsPerPage Per page count
     * @param boolean $published Whether to fetch only published ones
     * @return array
     */
    public function fetchAllByPage($published, $categoryId, $page, $itemsPerPage)
    {
        return $this->prepareResults($this->faqMapper->fetchAllByPage($published, $categoryId, $page, $itemsPerPage));
    }

    /**
     * Fetches all published entities
     * 
     * @param string $categoryId Optional Category ID filter
     * @return array
     */
    public function fetchAllPublished($categoryId = null)
    {
        return $this->prepareResults($this->faqMapper->fetchAllByPage(true, $categoryId, null, null));
    }

    /**
     * Saves a FAQ
     * 
     * @param array $input
     * @return boolean
     */
    private function save(array $input)
    {
        // Safe type-casting
        $input['faq']['order'] = (int) $input['faq']['order'];
        return $this->faqMapper->saveEntity($input['faq'], $input['translation']);
    }

    /**
     * Adds a FAQ
     * 
     * @param array $input Raw form data
     * @return boolean
     */
    public function add(array $input)
    {
        return $this->save($input);
    }

    /**
     * Updates a FAQ
     * 
     * @param array $input Raw form data
     * @return boolean
     */
    public function update(array $input)
    {
        return $this->save($input);
    }

    /**
     * Returns last faq id
     * 
     * @return integer
     */
    public function getLastId()
    {
        return $this->faqMapper->getLastId();
    }

    /**
     * Returns prepared paginator's instance
     * 
     * @return \Krystal\Paginate\Pagination
     */
    public function getPaginator()
    {
        return $this->faqMapper->getPaginator();
    }

    /**
     * Fetches a faq bag by its associated id
     * 
     * @param string $id Faq id
     * @param boolean $withTranslations Whether to fetch translations or not
     * @return boolean|\Krystal\Stdlib\VirtualBag|boolean
     */
    public function fetchById($id, $withTranslations)
    {
        if ($withTranslations == true) {
            return $this->prepareResults($this->faqMapper->fetchById($id, true));
        } else {
            return $this->prepareResult($this->faqMapper->fetchById($id, false));
        }
    }

    /**
     * Deletes a faq by its associated id
     * 
     * @param string $id Faq's id
     * @return boolean
     */
    public function deleteById($id)
    {
        return $this->faqMapper->deleteEntity($id);
    }

    /**
     * Deletes faqs by their associated ids
     * 
     * @param array $ids Array of ids
     * @return boolean
     */
    public function deleteByIds(array $ids)
    {
        return $this->faqMapper->deleteEntity($ids);
    }
}
