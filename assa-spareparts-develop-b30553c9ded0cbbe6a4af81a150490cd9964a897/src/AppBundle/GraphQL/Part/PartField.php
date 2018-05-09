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
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Scalar\IntType;
use Youshido\GraphQLBundle\Field\AbstractContainerAwareField;

class PartField extends AbstractContainerAwareField
{
    public function __construct(array $config = []) {
        $config["args"] = [
            'part_id' =>  new NonNullType(new IntType()),
        ];
        parent::__construct($config);
    }

    public function getType()
    {
        return new PartType();
    }

    public function resolve($value, array $args, ResolveInfo $info)
    {
        $em = $this->container->get('neo4j.entity_manager');

        // get a single part
        $query = $em->createQuery('MATCH (n:Part) WHERE id(n) = {id} RETURN n');
        $query->setParameter('id', $args['part_id']);
        $query->addEntityMapping('n', Part::class);
        [ $part ] = $query->execute();

        // get the related parts
        // Wanted to put this in one query i.e. RETURN n{.*, relatedParts: collect(c)} but couldn't hydrate in symfony anymore. :(
        $query = $em->createQuery('
            MATCH (n)
            WHERE id(n) = {id}
            OPTIONAL MATCH path=(n)-[*1..]-(c:Part)
            WITH c, n
            ORDER BY length(path)
            RETURN c
            LIMIT 20
        ');
        $query->setParameter('id', $args['part_id']);
        $query->addEntityMapping('c', Part::class);
        $relatedParts = $query->execute();
        $part->setRelatedParts($relatedParts);

        return $part;
    }
}