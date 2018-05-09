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

namespace AppBundle\GraphQL\Category;

use AppBundle\GraphQL\Part\PartType;
use Youshido\GraphQL\Type\ListType\ListType;
use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\IdType;
use Youshido\GraphQL\Type\Scalar\StringType;

class CategoryType extends AbstractObjectType
{

    public function build($config)
    {
        $config
            ->addField('id', new IdType())
            ->addField('name', new StringType())
            ->addField('image', new StringType())
            ->addField('parentCategories', new ListType(new CategoryType()))
            ->addField('childCategories', new ListType(new CategoryType()))
            ->addField('parts', new ListType(new PartType()));
    }

    public function getName()
    {
        return "Category";
    }

}