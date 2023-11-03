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
     * @param  Field  $field Field to add.
     * @param  string  $after Attribute name of field to insert after.
     * @return array Array of fields.
     */
    public function addFieldAfter(Field $fieldToInsert, string $after)
    {
        $this->fields = collect($this->fields)->map(function ($field) use ($after, $fieldToInsert) {
            if ($field->attribute === $after) {
                return [$field, $fieldToInsert];
            }

            return $field;
        })->flatten()->toArray();
    }
}
