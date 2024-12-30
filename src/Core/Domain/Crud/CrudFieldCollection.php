<?php

namespace App\Core\Domain\Crud;

use Ramsey\Collection\AbstractCollection;

final class CrudFieldCollection extends AbstractCollection
{
    public static function fromArray(array $fields) : self
    {
        $collection = new self();

        /** @var CrudField $field */
        foreach($fields as $field){
            $collection->add(new CrudField(
                name: $field->name,
                value: $field->value
            ));
        }

        return $collection;
    }

    public function getType(): string
    {
        return CrudField::class;
    }
}