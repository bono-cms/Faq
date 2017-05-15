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

use Faq\Storage\CategoryMapperInterface;
use Cms\Service\AbstractManager;
use Krystal\Stdlib\VirtualEntity;
use Krystal\Stdlib\ArrayUtils;

final class CategoryManager extends AbstractManager implements CategoryManagerInterface
{
    /**
     * Any compliant category mapper
     * 
     * @var \Faq\Storage\CategoryMapperInterface
     */
    private $categoryMapper;

    /**
     * State initialization
     * 
     * @param \Faq\Storage\CategoryMapperInterface $categoryMapper
     * @return void
     */
    public function __construct(CategoryMapperInterface $categoryMapper)
    {
        $this->categoryMapper = $categoryMapper;
    }

    /**
     * {@inheritDoc}
     */
    protected function toEntity(array $row)
    {
        $entity = new VirtualEntity();
        $entity->setId($row['id'], VirtualEntity::FILTER_INT)
               ->setName($row['name'], VirtualEntity::FILTER_TAGS)
               ->setOrder($row['order'], VirtualEntity::FILTER_INT);

        return $entity;
    }

    /**
     * Fetches a list as id => name pair
     * 
     * @return array
     */
    public function fetchList()
    {
        $data = $this->categoryMapper->fetchAll(false);
        return ArrayUtils::arrayList($data, 'id', 'name');
    }

    /**
     * Fetch all category entities
     * 
     * @param boolean $sort Whether to use sorting by order attribute or not
     * @return array
     */
    public function fetchAll($sort)
    {
        return $this->prepareResults($this->categoryMapper->fetchAll($sort));
    }

    /**
     * Finds category entity by its id
     * 
     * @param string $id Category id
     * @return \Krystal\Stdlib\VirtualEntity|boolean
     */
    public function fetchById($id)
    {
        return $this->prepareResult($this->categoryMapper->fetchById($id));
    }

    /**
     * Returns category last id
     * 
     * @return integer
     */
    public function getLastId()
    {
        return $this->categoryMapper->getLastId();
    }

    /**
     * Deletes a category by its id
     * 
     * @param string $id Category id
     * @return boolean
     */
    public function deleteById($id)
    {
        return $this->categoryMapper->deleteById($id);
    }

    /**
     * Updates a category
     * 
     * @param array $input
     * @return boolean
     */
    public function update(array $input)
    {
        $input['order'] = (int) $input['order'];

        return $this->categoryMapper->update($input);
    }

    /**
     * Adds a category
     * 
     * @param array $input
     * @return boolean
     */
    public function add(array $input)
    {
        $input['order'] = (int) $input['order'];

        return $this->categoryMapper->insert($input);
    }
}
