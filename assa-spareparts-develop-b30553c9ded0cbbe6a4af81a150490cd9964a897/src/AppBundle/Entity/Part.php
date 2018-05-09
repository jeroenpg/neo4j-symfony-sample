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
 * @OGM\Node(label="Part")
 */
class Part
{
    /** @OGM\GraphId() */
    protected $id;

    /** @OGM\Property(type="string") */
    protected $article;

    /** @OGM\Property(type="string") */
    protected $name;

    /** @OGM\Property(type="string") */
    protected $description;

    /** @OGM\Property(type="string") */
    protected $unit;

    /** @OGM\Property(type="string") */
    protected $tag1;
    /** @OGM\Property(type="string") */
    protected $tag2;
    /** @OGM\Property(type="string") */
    protected $tag3;
    /** @OGM\Property(type="string") */
    protected $tag4;

    /**
     * @var Part[]|Collection
     *
     * @OGM\Relationship(type="CATEGORIZED_BY", direction="INCOMING", collection=true, mappedBy="parts", targetEntity="Category")
     */
    protected $categories;

    /** @OGM\Property(type="string") */
    protected $image;

    protected $relatedParts;

    public function __construct($article, $name, $description, $unit, $tag1, $tag2, $tag3, $tag4, $image)
    {
        $this->article = $article;
        $this->name = $name;
        $this->description = $description;
        $this->unit = $unit;
        $this->tag1 = $tag1;
        $this->tag2 = $tag2;
        $this->tag3 = $tag3;
        $this->tag4 = $tag4;
        $this->image = $image;
        $this->categories = new Collection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param mixed $article
     */
    public function setArticle($article)
    {
        $this->article = $article;
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

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param mixed $unit
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
    }

    public function addCategory($category) {
        $this->categories[] = $category;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTag1()
    {
        return $this->tag1;
    }

    /**
     * @param mixed $tag1
     */
    public function setTag1($tag1)
    {
        $this->tag1 = $tag1;
    }

    /**
     * @return mixed
     */
    public function getTag2()
    {
        return $this->tag2;
    }

    /**
     * @param mixed $tag2
     */
    public function setTag2($tag2)
    {
        $this->tag2 = $tag2;
    }

    /**
     * @return mixed
     */
    public function getTag3()
    {
        return $this->tag3;
    }

    /**
     * @param mixed $tag3
     */
    public function setTag3($tag3)
    {
        $this->tag3 = $tag3;
    }

    /**
     * @return mixed
     */
    public function getTag4()
    {
        return $this->tag4;
    }

    /**
     * @param mixed $tag4
     */
    public function setTag4($tag4)
    {
        $this->tag4 = $tag4;
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

    /**
     * @return mixed
     */
    public function getRelatedParts()
    {
        return $this->relatedParts;
    }

    /**
     * @param mixed $relatedParts
     */
    public function setRelatedParts($relatedParts)
    {
        $this->relatedParts = $relatedParts;
    }



}