<?php

namespace Blackbaud\Data\CustomField;

use Blackbaud\Contracts\Data;
use Blackbaud\Data\BaseData;
use Blackbaud\Enums\CustomFieldCategoryType;

/**
 * @phpstan-type CustomFieldCategoryDetailResponseData array{
 *     name: string,
 *     type: string,
 *     code_table_id?: string|null,
 *     one_per_record?: bool|null
 * }
 */
class CustomFieldCategoryDetail extends BaseData implements Data
{
    public function __construct(
        public string $name,
        public CustomFieldCategoryType $type,
        public ?string $code_table_id = null,
        public ?bool $one_per_record = null,
    ) {}

    /**
     * @param  CustomFieldCategoryDetailResponseData  $data
     */
    public static function from(array $data): CustomFieldCategoryDetail
    {
        return new self(
            name: $data['name'],
            type: CustomFieldCategoryType::from($data['type']),
            code_table_id: $data['code_table_id'] ?? null,
            one_per_record: $data['one_per_record'] ?? null,
        );
    }
}
