<?php

namespace Folklore\GraphQL\Support;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type as GraphQLType;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginationCursorType extends ObjectType
{
    public function __construct()
    {
        // See https://laravel.com/api/5.6/Illuminate/Pagination/LengthAwarePaginator.html for more fields.
        parent::__construct([
            'name' => 'PaginationCursor',
            'fields' => [
                'total' => [
                    'type' => GraphQLType::nonNull(GraphQLType::int()),
                    'resolve' => function (LengthAwarePaginator $paginator) {
                        return $paginator->total();
                    },
                ],
                'perPage' => [
                    'type' => GraphQLType::nonNull(GraphQLType::int()),
                    'resolve' => function (LengthAwarePaginator $paginator) {
                        return $paginator->perPage();
                    },
                ],
                'currentPage' => [
                    'type' => GraphQLType::nonNull(GraphQLType::int()),
                    'resolve' => function (LengthAwarePaginator $paginator) {
                        return $paginator->currentPage();
                    },
                ],
                'previousPage' => [
                    'type' => GraphQLType::int(),
                    'resolve' => function (LengthAwarePaginator $paginator) {
                        if($paginator->currentPage() - 1 === 0)
                            return null;

                        return $paginator->currentPage() - 1;
                    },
                ],
                'nextPage' => [
                    'type' => GraphQLType::int(),
                    'resolve' => function (LengthAwarePaginator $paginator) {
                        if($paginator->currentPage() === $paginator->lastPage())
                            return null;

                        return $paginator->currentPage() + 1;
                    },
                ],
                'lastPage' => [
                    'type' => GraphQLType::nonNull(GraphQLType::int()),
                    'resolve' => function (LengthAwarePaginator $paginator) {
                        return $paginator->lastPage();
                    },
                ],
                'hasPages' => [
                    'type' => GraphQLType::nonNull(GraphQLType::boolean()),
                    'resolve' => function (LengthAwarePaginator $paginator) {
                        return $paginator->hasPages();
                    },
                ],
            ],
        ]);
    }
}
