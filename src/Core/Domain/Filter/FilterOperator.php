<?php

namespace App\Core\Domain\Filter;

interface FilterOperator
{
    public const CUSTOM_EXPRESSION = 'customExpression';
    public const EMPTY = '';
    public const EQUALS = 'eq';
    public const NOT_EQUALS = 'neq';
    public const LIKE = 'like';
    public const GREATER_THAN = 'gt';
    public const LESS_THAN = 'lt';
    public const IN = 'in';
    public const NULL = 'null';
    public const NOT_NULL = 'notNull';
    public const AVAILABLES = [
        self::EQUALS,
        self::LIKE,
        self::GREATER_THAN,
        self::LESS_THAN,
        self::NULL,
        self::IN,
        self::NOT_NULL,
        self::NOT_EQUALS,
        self::EMPTY,
        self::CUSTOM_EXPRESSION
    ];
}
