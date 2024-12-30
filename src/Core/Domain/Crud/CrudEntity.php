<?php

namespace App\Core\Domain\Crud;

use App\Core\Domain\Aggregate\AggregateRoot;
use App\Core\Domain\Crud\Exception\CrudPropertyNotFound;

abstract class CrudEntity extends AggregateRoot
{
    public function partialUpdate(CrudFieldCollection $fields): void
    {
        /** @var CrudField $field */
        foreach ($fields as $field) {
            $fieldName = $field->name;

            if (!property_exists($this, $fieldName)) {
                throw new CrudPropertyNotFound(self::class, $fieldName);
            }

            $this->$fieldName = $field->value;
        }
    }
}