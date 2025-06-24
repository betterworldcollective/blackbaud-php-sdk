<?php

namespace Blackbaud\Data\Constituent;

use Blackbaud\Contracts\Data;
use Blackbaud\Data\BaseData;
use Blackbaud\Data\FuzzyDate;
use Blackbaud\Enums\ConstituentType;
use Carbon\CarbonImmutable;

/**
 * @phpstan-import-type AddressDataResponse from Address
 * @phpstan-import-type EmailDataResponse from Email
 * @phpstan-import-type OnlinePresenceDataResponse from OnlinePresence
 * @phpstan-import-type PhoneDataResponse from Phone
 * @phpstan-import-type SpouseDataResponse from Spouse
 *
 * @phpstan-type ConstituentDataResponse array{
 *     id: string,
 *     last: string,
 *     type: string,
 *     age?: int|null,
 *     name?: string,
 *     first?: string|null,
 *     fundraiser_status?: string|null,
 *     gender?: string|null,
 *     lookup_id?: string|null,
 *     middle?: string|null,
 *     preferred_name?: string|null,
 *     title?: string|null,
 *     import_id?: string|null,
 *     former_name?: string|null,
 *     marital_status?: string|null,
 *     suffix?: string|null,
 *     suffix_2?: string|null,
 *     title_2?: string|null,
 *     birthplace?: string|null,
 *     ethnicity?: string|null,
 *     income?: string|null,
 *     religion?: string|null,
 *     industry?: string|null,
 *     receipt_type?: string|null,
 *     target?: string|null,
 *     parent_corporation_name?: string|null,
 *     num_employees?: int|null,
 *     num_subsidiaries?: int|null,
 *     parent_corporation_id?: int|null,
 *     gives_anonymously: bool,
 *     inactive: bool,
 *     is_constituent: bool,
 *     deceased: bool,
 *     is_memorial: bool,
 *     is_solicitor: bool,
 *     no_valid_address: bool,
 *     requests_no_email: bool,
 *     birthdate?: array{y: int, m: int, d: int}|null,
 *     deceased_date?: array{y: int, m: int, d: int}|null,
 *     date_added?: string|null,
 *     date_modified?: string|null,
 *     address?: AddressDataResponse,
 *     spouse?: SpouseDataResponse,
 *     email?: EmailDataResponse,
 *     phone?: PhoneDataResponse,
 *     online_presence?: OnlinePresenceDataResponse
 * }
 */
class Constituent extends BaseData implements Data
{
    public function __construct(
        public string $id,
        public string $last,
        public ConstituentType $type,
        public ?int $age = null,
        public ?string $name = null,
        public ?string $first = null,
        public ?string $fundraiser_status = null,
        public ?string $gender = null,
        public ?string $lookup_id = null,
        public ?string $middle = null,
        public ?string $preferred_name = null,
        public ?string $title = null,
        public ?string $import_id = null,
        public ?string $former_name = null,
        public ?string $marital_status = null,
        public ?string $suffix = null,
        public ?string $suffix_2 = null,
        public ?string $title_2 = null,
        public ?string $birthplace = null,
        public ?string $ethnicity = null,
        public ?string $income = null,
        public ?string $religion = null,
        public ?string $industry = null,
        public ?string $receipt_type = null,
        public ?string $target = null,
        public ?string $parent_corporation_name = null,
        public ?int $num_employees = null,
        public ?int $num_subsidiaries = null,
        public ?int $parent_corporation_id = null,
        public bool $gives_anonymously = false,
        public bool $inactive = false,
        public bool $is_constituent = true,
        public bool $deceased = false,
        public bool $is_memorial = false,
        public bool $is_solicitor = false,
        public bool $no_valid_address = false,
        public bool $requests_no_email = false,
        public ?CarbonImmutable $birthdate = null,
        public ?CarbonImmutable $deceased_date = null,
        public ?CarbonImmutable $date_added = null,
        public ?CarbonImmutable $date_modified = null,
        public ?Address $address = null,
        public ?Spouse $spouse = null,
        public ?Email $email = null,
        public ?Phone $phone = null,
        public ?OnlinePresence $online_presence = null,
    ) {}

    /**
     * @param  ConstituentDataResponse  $data
     */
    public static function from(array $data): Constituent
    {
        /** @var ?string $dateAdded */
        $dateAdded = data_get($data, 'date_added');

        /** @var ?string $dateModified */
        $dateModified = data_get($data, 'date_modified');

        return new self(
            id: $data['id'],
            last: $data['last'],
            type: ConstituentType::from(strtolower($data['type'])),
            age: $data['age'] ?? null,
            name: $data['name'] ?? null,
            first: $data['first'] ?? null,
            fundraiser_status: $data['fundraiser_status'] ?? null,
            gender: $data['gender'] ?? null,
            lookup_id: $data['lookup_id'] ?? null,
            middle: $data['middle'] ?? null,
            preferred_name: $data['preferred_name'] ?? null,
            title: $data['title'] ?? null,
            import_id: $data['import_id'] ?? null,
            former_name: $data['former_name'] ?? null,
            marital_status: $data['marital_status'] ?? null,
            suffix: $data['suffix'] ?? null,
            suffix_2: $data['suffix_2'] ?? null,
            title_2: $data['title_2'] ?? null,
            birthplace: $data['birthplace'] ?? null,
            ethnicity: $data['ethnicity'] ?? null,
            income: $data['income'] ?? null,
            religion: $data['religion'] ?? null,
            industry: $data['industry'] ?? null,
            receipt_type: $data['receipt_type'] ?? null,
            target: $data['target'] ?? null,
            parent_corporation_name: $data['parent_corporation_name'] ?? null,
            num_employees: $data['num_employees'] ?? null,
            num_subsidiaries: $data['num_subsidiaries'] ?? null,
            parent_corporation_id: $data['parent_corporation_id'] ?? null,
            gives_anonymously: $data['gives_anonymously'],
            inactive: $data['inactive'],
            is_constituent: $data['is_constituent'],
            deceased: $data['deceased'],
            is_memorial: $data['is_memorial'],
            is_solicitor: $data['is_solicitor'],
            no_valid_address: $data['no_valid_address'],
            requests_no_email: $data['requests_no_email'],
            birthdate: FuzzyDate::toCarbon($data['birthdate'] ?? null),
            deceased_date: FuzzyDate::toCarbon($data['deceased_date'] ?? null),
            date_added: $dateAdded
                ? CarbonImmutable::parse($dateAdded)
                : null,
            date_modified: $dateModified
                ? CarbonImmutable::parse($dateModified)
                : null,
            address: self::convertToData($data, 'address', Address::class),
            spouse: self::convertToData($data, 'spouse', Spouse::class),
            email: self::convertToData($data, 'email', Email::class),
            phone: self::convertToData($data, 'phone', Phone::class),
            online_presence: self::convertToData($data, 'online_presence', OnlinePresence::class),
        );
    }
}
