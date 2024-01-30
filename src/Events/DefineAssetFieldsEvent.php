<?php

namespace Creode\LaravelNovaAssets\Events;

use Illuminate\Foundation\Bus\Dispatchable;
use Laravel\Nova\Fields\Field;

class DefineAssetFieldsEvent
{
    use Dispatchable;

    /**
     * Array of Nova Fields.
     *
     * @param  Field[]  $fields
     */
    public function __construct(public array $fields = [])
    {
    }

    /**
     * Allows you to add a field to the array after a specific one.
     *
     * @param  string  $after  Attribute name of field to insert after.
     * @param  Field  $field  Field to add.
     * @return array Array of fields.
     */
    public function addFieldAfter(string $after, Field $fieldToInsert)
    {
        $this->fields = collect($this->fields)->map(function ($field) use ($after, $fieldToInsert) {
            if ($field->attribute === $after) {
                return [$field, $fieldToInsert];
            }

            return $field;
        })->flatten()->toArray();
    }
}
