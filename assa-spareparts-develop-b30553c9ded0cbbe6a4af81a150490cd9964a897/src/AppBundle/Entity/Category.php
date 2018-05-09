<?php
/**
 *         _             __        __ _
 *   /\/\ (_) ___ __ _  / _\ ___  / _| |___      ____ _ _ __ ___
 *  /    \| |/ __/ _` | \ \ / _ \| |_| __\ \ /\ / / _` | '__/ _ \
 * / /\/\ \ | (_| (_| | _\ \ (_) |  _| |_ \ V  V / (_| | | |  __/
 * \/    \/_|\___\__,_| \__/\___/|_|  \__| \_/\_/ \__,_|_|  \___|
 * ----------------------------------------------
 * Copyright (c) 2017, Mica Software
 * All rights reserved.
 * ----------------------------------------------
 *
 * Created at: 09/12/2017
 * Created by: jeroen
 */

namespace AppBundle\Entity;

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;

/**
 * @OGM\Node(label="Category")
 */
class Category
{
    /**
     * @var int
     *
     * @OGM\GraphId()
     */
    protected $id;

    /** @OGM\Property(type="string") */
    protected $name;

    /**
     * @var Category[]|Collection
     *
     * @OGM\Relationship(type="RELATED_TO", direction="OUTGOING", collection=true, mappedBy="parentCategories", targetEntity="Category")
     */
    protected $parentCategories;

    /**
     * @var Category[]|Collection
     *
     * @OGM\Relationship(type="RELATED_TO", direction="INCOMING", collection=true, mappedBy="childCategories", targetEntity="Category")
     */
    protected $childCategories;

    /**
     * @var Part[]|Collection
     *
     * @OGM\Relationship(type="CATEGORIZED_BY", direction="OUTGOING", collection=true, mappedBy="categories", targetEntity="Part")
     */
    protected $parts;

    /** @OGM\Property(type="string") */
    protected $image;

    public function __construct($name, $image)
    {
        $this->name = $name;
        $this->image = $image;
        $this->parentCategories = new Collection();
        $this->childCategories = new Collection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function addPart($part) {
        $this->parts[] = $part;
        return $this;
    }


    public function addChildCategory($category) {
        $this->childCategories[] = $category;
        return $this;
    }

    public function addParentCategory($category) {
        $this->parentCategories[] = $category;
        return $this;
    }

    /**
     * @return Category[]|Collection
     */
    public function getParentCategories()
    {
        return $this->parentCategories;
    }

    /**
     * @return Category[]|Collection
     */
    public function getChildCategories()
    {
        return $this->childCategories;
    }

    /**
     * @return Part[]|Collection
     */
    public function getParts()
    {
        return $this->parts;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }
}