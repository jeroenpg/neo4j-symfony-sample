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

use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Type\ListType\ListType;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Scalar\IdType;
use Youshido\GraphQLBundle\Field\AbstractContainerAwareField;

class RelatedPartsField extends AbstractContainerAwareField
{
    public function __construct(array $config = []) {
        $config["args"] = [
            'product_id' =>  new NonNullType(new IdType()),
        ];
        parent::__construct($config);
    }

    public function getType()
    {
        return new ListType(new PartType());
    }

    public function resolve($value, array $args, ResolveInfo $info)
    {
        $em = $this->container->get('neo4j.entity_manager');

        //related products ordered by depth. i.e. returns ... children of children of children of product
        $query = $em->createQuery('MATCH p = (n:Product { id:{id} })-[:PART_OF *1..]-(related_products)
        WITH DISTINCT related_products, length(p) as pathLength
        RETURN related_products AS related_products ORDER BY pathLength');
        $query->setParameter('id', $args['product_id']);

        $result = $query->execute();
        return $result;
    }
}