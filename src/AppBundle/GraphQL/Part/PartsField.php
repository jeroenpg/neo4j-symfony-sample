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

use AppBundle\Entity\Part;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Type\ListType\ListType;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Scalar\StringType;
use Youshido\GraphQLBundle\Field\AbstractContainerAwareField;

class PartsField extends AbstractContainerAwareField
{
    public function __construct(array $config = []) {
        $config["args"] = [
            'terms' =>  new StringType(),
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
        $terms = $args['terms'] ?? null;

        if(!$terms) {
            $result = $em->getRepository(Part::class)->findBy([], null, 100);

            // same query but without OGM
            // $query = $em->createQuery('MATCH p = (n:Product) RETURN n LIMIT 100');
            // $query->addEntityMapping('n', Product::class);
        } else {
            $escapedTerms = addslashes(strtolower($terms));
            $query = $em->createQuery('
                CALL ga.es.queryNode(\'{\"from\": 0, \"size\": 100, \"query\":{\"multi_match\":{\"type\":\"cross_fields\", \"operator\":\"and\", \"query\":\"'.$escapedTerms.'\", \"fields\":[\"name\",\"article\",\"tag1\",\"tag2\",\"tag3\",\"tag4\"]}}}\') 
                YIELD node,score 
                RETURN node 
                ORDER BY score DESC
            ');
            $query
                ->addEntityMapping('node', Part::class);
            $result = $query->execute();
        }

        return $result;
    }
}