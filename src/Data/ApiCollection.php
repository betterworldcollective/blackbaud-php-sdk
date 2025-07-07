<?php

namespace Blackbaud\Data;

/**
 * @template T of BaseData
 */
class ApiCollection
{
    /**
     * @var array<T>
     */
    public array $value = [];

    /**
     * @param  array<array<string, array<string, float>|bool|string|null>>  $data
     * @param  class-string<T>  $dataClass
     */
    public function __construct(
        array $data,
        string $dataClass,
        public ?int $count = null,
        public ?string $nextLink = null,
    ) {
        $this->value = array_map(
            function (array $item) use ($dataClass): BaseData {
                /** @var T $dto */
                $dto = $dataClass::from($item);

                return $dto;
            },
            $data
        );
    }

    /**
     * @template TData of BaseData
     *
     * @param  array<array<string, array<string, float>|bool|string|null>>  $data
     * @param  class-string<TData>  $dataClass
     * @return ApiCollection<TData>
     */
    public static function from(array $data, string $dataClass, ?int $count = null, ?string $nextLink = null): self
    {
        return new self($data, $dataClass, $count, $nextLink);
    }
}
