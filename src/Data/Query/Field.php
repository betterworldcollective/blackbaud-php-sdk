<?php

namespace Blackbaud\Data\Query;

use Blackbaud\Contracts\Data;
use Blackbaud\Data\BaseData;

/**
 * @phpstan-type FieldDataResponse array{
 *     id: int,
 *     available_field_name?: string|null,
 *     selected_field_name?: string|null,
 *     unique_id?: string|null,
 *     attribute_type_of_data?: string|null,
 *     value_type?: string|null,
 *     one_to_many?: bool|null,
 *     output_sort_can_add_edit?: bool|null,
 *     criteria_can_add_edit?: bool|null,
 *     execute_by_id_supported?: bool|null,
 *     allowed_filter_operators?: array<string>|null,
 *     summary_value_type?: string|null,
 *     summary_has_available_fields?: bool|null,
 *     summary_has_default_filters?: bool|null
 * }
 */
class Field extends BaseData implements Data
{
    /**
     * @param  array<string>  $allowed_filter_operators
     */
    public function __construct(
        public int $id,
        public ?string $available_field_name = null,
        public ?string $selected_field_name = null,
        public ?string $unique_id = null,
        public ?string $attribute_type_of_data = null,
        public ?string $value_type = null,
        public ?bool $one_to_many = null,
        public ?bool $output_sort_can_add_edit = null,
        public ?bool $criteria_can_add_edit = null,
        public ?bool $execute_by_id_supported = null,
        public ?array $allowed_filter_operators = null,
        public ?string $summary_value_type = null,
        public ?bool $summary_has_available_fields = null,
        public ?bool $summary_has_default_filters = null,
    ) {}

    /**
     * @param  FieldDataResponse  $data
     */
    public static function from(array $data): Field
    {
        return new self(
            id: $data['id'],
            available_field_name: $data['available_field_name'] ?? null,
            selected_field_name: $data['selected_field_name'] ?? null,
            unique_id: $data['unique_id'] ?? null,
            attribute_type_of_data: $data['attribute_type_of_data'] ?? null,
            value_type: $data['value_type'] ?? null,
            one_to_many: $data['one_to_many'] ?? null,
            output_sort_can_add_edit: $data['output_sort_can_add_edit'] ?? null,
            criteria_can_add_edit: $data['criteria_can_add_edit'] ?? null,
            execute_by_id_supported: $data['execute_by_id_supported'] ?? null,
            allowed_filter_operators: $data['allowed_filter_operators'] ?? null,
            summary_value_type: $data['summary_value_type'] ?? null,
            summary_has_available_fields: $data['summary_has_available_fields'] ?? null,
            summary_has_default_filters: $data['summary_has_default_filters'] ?? null,
        );
    }
}
