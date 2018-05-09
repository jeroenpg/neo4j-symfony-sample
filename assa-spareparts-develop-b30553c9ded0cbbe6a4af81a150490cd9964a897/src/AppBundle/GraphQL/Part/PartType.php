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

namespace AppBundle\GraphQL\Part;

use Youshido\GraphQL\Type\ListType\ListType;
use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\IdType;
use Youshido\GraphQL\Type\Scalar\StringType;

class PartType extends AbstractObjectType
{

    public function build($config)
    {
        $config
            ->addField('id', new IdType())
            ->addField('article', new StringType())
            ->addField('unit', new StringType())
            ->addField('name', new StringType())
            ->addField('image', new StringType())
            ->addField('description', new StringType())
            ->addField('tag1', new StringType())
            ->addField('tag2', new StringType())
            ->addField('tag3', new StringType())
            ->addField('tag4', new StringType())
            ->addField('relatedParts', new ListType(new PartType()));
    }

    public function getName()
    {
        return "Part";
    }

}