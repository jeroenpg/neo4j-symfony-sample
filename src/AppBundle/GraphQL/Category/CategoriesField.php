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

use AppBundle\Entity\Category;
use AppBundle\Entity\Part;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Parser\Ast\ArgumentValue\InputObject;
use Youshido\GraphQL\Type\InputObject\InputObjectType;
use Youshido\GraphQL\Type\ListType\ListType;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Scalar\IdType;
use Youshido\GraphQL\Type\Scalar\IntType;
use Youshido\GraphQL\Type\Scalar\StringType;
use Youshido\GraphQL\Type\Union\UnionType;
use Youshido\GraphQLBundle\Field\AbstractContainerAwareField;

class CategoriesField extends AbstractContainerAwareField
{
    public function __construct(array $config = []) {
        $config["args"] = [
            'category' =>  new IntType()
        ];
        parent::__construct($config);
    }

    public function getType()
    {
        return new ListType(new CategoryType());
    }

    public function resolve($value, array $args, ResolveInfo $info)
    {
        $em = $this->container->get('neo4j.entity_manager');
        $category = $args['category'] ?? null;

        if($category === null) {
            $query = $em->createQuery('MATCH (n:Category) WHERE not( (n)-[:RELATED_TO]->() ) RETURN n ORDER BY n.name');
            $query->addEntityMapping('n', Category::class);
            $result = $query->execute();
        } else {
            $query = $em->createQuery('MATCH (n:Category)-[:RELATED_TO]->(parent:Category) WHERE id(parent) = {id} RETURN n ORDER BY n.name');
            $query->setParameter('id', $category);
            $query->addEntityMapping('n', Category::class);
            $result = $query->execute();
        }

        return $result;
    }
}