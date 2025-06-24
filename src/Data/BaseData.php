<?php

namespace Blackbaud\Data;

use Blackbaud\Contracts\Data;

abstract class BaseData
{
    /**
     * @template TData of Data
     *
     * @param  array<string, mixed>  $dataOrigin
     * @param  class-string<TData>  $dtoClass
     * @return TData|null
     */
    protected static function convertToData(array $dataOrigin, string $key, string $dtoClass)
    {
        $data = data_get($dataOrigin, $key);

        if (is_array($data)) {
            /** @var TData $dto */
            $dto = $dtoClass::from($data);

            return $dto;
        }

        return null;
    }

    /**
     * @return array<mixed, mixed>
     */
    public function toArray(): array
    {
        return (array) json_decode((string) json_encode($this), true);
    }
}
