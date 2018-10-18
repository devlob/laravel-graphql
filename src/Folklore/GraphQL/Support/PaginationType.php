<?php

namespace Folklore\GraphQL\Support;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type as GraphQLType;
use GraphQL;

class PaginationType extends ObjectType
{
    public function __construct($type)
    {
        parent::__construct([
            'name' => $type . 'Pagination',
            'fields' => [
                'items' => [
                    'type' => GraphQLType::listOf(GraphQL::type($type)),
                    'resolve' => function ($paginator) {
                        if (isset($paginator['items']))
                            return $paginator['items']->getCollection();

                        return $paginator->getCollection();
                    },
                ],

                'data' => [
                    'type' => GraphQL::type($type),
                    'resolve' => function ($paginator) {
                        if (isset($paginator['data']))
                            return $paginator['data'];
                    },
                ],

                'cursor' => [
                    'type' => GraphQLType::nonNull(GraphQL::type('PaginationCursor')),
                    'resolve' => function ($paginator) {
                        if (isset($paginator['items']))
                            return $paginator['items'];

                        return $paginator;
                    },
                ],
            ],
        ]);
    }
}
