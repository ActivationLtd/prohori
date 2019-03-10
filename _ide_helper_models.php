<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * Class Assignment
 *
 * @package App
 * @property int $id
 * @property string|null $uuid
 * @property int|null $tenant_id
 * @property string|null $name
 * @property bool $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Assignment onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Assignment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Assignment withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\User $creator
 * @property-read \App\User $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment query()
 * @property string|null $type
 * @property string|null $note
 * @property int|null $module_id
 * @property int|null $element_id
 * @property string|null $element_uuid
 * @property int|null $assigned_by
 * @property int|null $assigned_to
 * @property int|null $assigned_for_days
 * @property int|null $previous_id
 * @property int|null $next_id
 * @property int|null $is_resolved
 * @property int|null $is_verified
 * @property int|null $is_closed
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Change[] $changes
 * @property-read \App\Upload $latestUpload
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereAssignedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereAssignedForDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereAssignedTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereElementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereElementUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereIsClosed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereIsResolved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereIsVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereModuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereNextId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment wherePreviousId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereUuid($value)
 */
	class Assignment extends \Eloquent {}
}

namespace App{
/**
 * Class Change
 *
 * @package App
 * @property int $id
 * @property string|null $uuid
 * @property int|null $tenant_id
 * @property string|null $name
 * @property bool $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Change onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Change withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Change withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $changeset
 * @property int|null $module_id
 * @property string|null $module_name
 * @property int|null $element_id
 * @property string|null $element_uuid
 * @property string|null $field
 * @property string|null $old
 * @property string|null $new
 * @property string|null $description
 * @property-read \App\User|null $creator
 * @property-read \App\User|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Change newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Change newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Change query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Change whereChangeset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Change whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Change whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Change whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Change whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Change whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Change whereElementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Change whereElementUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Change whereField($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Change whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Change whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Change whereModuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Change whereModuleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Change whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Change whereNew($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Change whereOld($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Change whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Change whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Change whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Change whereUuid($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Change[] $changes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @property-read \App\Upload $latestUpload
 */
	class Change extends \Eloquent {}
}

namespace App{
/**
 * Class Client
 *
 * @package App
 * @property int $id
 * @property string|null $uuid
 * @property int|null $tenant_id
 * @property string|null $name
 * @property bool $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Client onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Client withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Client withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\User $creator
 * @property-read \App\User $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client query()
 * @property string|null $description
 * @property string|null $address1
 * @property string|null $address2
 * @property string|null $city
 * @property string|null $county
 * @property int|null $country_id
 * @property string|null $country_name
 * @property string|null $zip_code
 * @property string|null $phone
 * @property string|null $mobile
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Change[] $changes
 * @property-read \App\Upload $latestUpload
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereCountryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereCounty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereZipCode($value)
 */
	class Client extends \Eloquent {}
}

namespace App{
/**
 * Class Clientlocation
 *
 * @package App
 * @property int $id
 * @property string|null $uuid
 * @property int|null $tenant_id
 * @property string|null $name
 * @property bool $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Clientlocation onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Clientlocation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Clientlocation withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\User $creator
 * @property-read \App\User $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocation query()
 * @property int|null $division_id
 * @property string|null $division_name
 * @property int|null $district_id
 * @property string|null $district_name
 * @property int|null $upazila_id
 * @property string|null $upazila_name
 * @property float|null $latitude
 * @property float|null $longitude
 * @property int|null $client_id
 * @property string|null $client_name
 * @property int|null $operatingarea_id
 * @property string|null $operatingarea_name
 * @property int|null $clientlocationtype_id
 * @property string|null $clientlocationtype_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Change[] $changes
 * @property-read \App\Upload $latestUpload
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocation whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocation whereClientName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocation whereClientlocationtypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocation whereClientlocationtypeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocation whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocation whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocation whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocation whereDistrictName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocation whereDivisionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocation whereDivisionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocation whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocation whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocation whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocation whereOperatingareaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocation whereOperatingareaName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocation whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocation whereUpazilaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocation whereUpazilaName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocation whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocation whereUuid($value)
 */
	class Clientlocation extends \Eloquent {}
}

namespace App{
/**
 * Class Clientlocationtype
 *
 * @package App
 * @property int $id
 * @property string|null $uuid
 * @property int|null $tenant_id
 * @property string|null $name
 * @property bool $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Clientlocationtype onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Clientlocationtype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Clientlocationtype withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\User $creator
 * @property-read \App\User $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocationtype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocationtype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocationtype query()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Change[] $changes
 * @property-read \App\Upload $latestUpload
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocationtype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocationtype whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocationtype whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocationtype whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocationtype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocationtype whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocationtype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocationtype whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocationtype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocationtype whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Clientlocationtype whereUuid($value)
 */
	class Clientlocationtype extends \Eloquent {}
}

namespace App{
/**
 * Class Country
 *
 * @package App
 * @property int $id
 * @property string|null $uuid
 * @property int|null $tenant_id
 * @property string|null $name
 * @property bool $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @method static bool|null restore()
 * @mixin \Eloquent
 * @property string|null $code
 * @property string|null $country_id
 * @property string|null $iso2
 * @property string|null $country_short_name
 * @property string|null $country_long_name
 * @property string|null $iso3
 * @property string|null $numcode
 * @property string|null $un_member
 * @property string|null $calling_code
 * @property string|null $cctld
 * @property-read \App\User|null $creator
 * @property-read \App\User|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereCallingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereCctld($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereCountryLongName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereCountryShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereIso2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereIso3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereNumcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereUnMember($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country query()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Change[] $changes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @property-read \App\Upload $latestUpload
 * @property string|null $currency
 * @property string|null $currency_symbol
 * @property string|null $currency_override
 * @property string|null $currency_override_symbol
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereCurrencyOverride($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereCurrencyOverrideSymbol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereCurrencySymbol($value)
 */
	class Country extends \Eloquent {}
}

namespace App{
/**
 * Class Designation
 *
 * @package App
 * @property int $id
 * @property string|null $uuid
 * @property int|null $tenant_id
 * @property string|null $name
 * @property bool $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Designation onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Designation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Designation withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\User $creator
 * @property-read \App\User $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Designation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Designation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Designation query()
 * @property string|null $code
 * @property string|null $description
 * @property int|null $level
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Change[] $changes
 * @property-read \App\Upload $latestUpload
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Designation whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Designation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Designation whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Designation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Designation whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Designation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Designation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Designation whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Designation whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Designation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Designation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Designation whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Designation whereUuid($value)
 */
	class Designation extends \Eloquent {}
}

namespace App{
/**
 * Class Group
 *
 * @package App
 * @property int $id
 * @property string|null $uuid
 * @property int|null $tenant_id
 * @property string|null $name
 * @property bool $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Group onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Group withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Group withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $title
 * @property array $permissions
 * @property-read \App\User|null $creator
 * @property-read \App\User|null $updater
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group wherePermissions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereUuid($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Change[] $changes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @property-read \App\Upload $latestUpload
 */
	class Group extends \Eloquent {}
}

namespace App{
/**
 * Class Module
 *
 * @package App
 * @property int $id
 * @property string|null $uuid
 * @property int|null $tenant_id
 * @property string|null $name
 * @property bool $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Module onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Module withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Module withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $title
 * @property string|null $description
 * @property int|null $parent_id
 * @property int|null $modulegroup_id
 * @property int|null $level
 * @property int|null $order
 * @property string|null $default_route
 * @property string|null $color_css
 * @property string|null $icon_css
 * @property-read \App\User|null $creator
 * @property-read \App\User|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereColorCss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereDefaultRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereIconCss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereModulegroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Module whereUuid($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Change[] $changes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @property-read \App\Upload $latestUpload
 */
	class Module extends \Eloquent {}
}

namespace App{
/**
 * Class Modulegroup
 *
 * @package App
 * @property int $id
 * @property string|null $uuid
 * @property int|null $tenant_id
 * @property string|null $name
 * @property bool $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Modulegroup onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Modulegroup withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modulegroup withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $title
 * @property string|null $description
 * @property int|null $parent_id
 * @property int|null $level
 * @property int|null $order
 * @property string|null $default_route
 * @property string|null $color_css
 * @property string|null $icon_css
 * @property-read \App\User|null $creator
 * @property-read \App\User|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modulegroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modulegroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modulegroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modulegroup whereColorCss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modulegroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modulegroup whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modulegroup whereDefaultRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modulegroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modulegroup whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modulegroup whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modulegroup whereIconCss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modulegroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modulegroup whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modulegroup whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modulegroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modulegroup whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modulegroup whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modulegroup whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modulegroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modulegroup whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modulegroup whereUuid($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Change[] $changes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @property-read \App\Upload $latestUpload
 */
	class Modulegroup extends \Eloquent {}
}

namespace App{
/**
 * Class Operatingarea
 *
 * @package App
 * @property int $id
 * @property string|null $uuid
 * @property int|null $tenant_id
 * @property string|null $name
 * @property bool $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Operatingarea onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Operatingarea withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Operatingarea withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\User $creator
 * @property-read \App\User $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operatingarea newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operatingarea newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operatingarea query()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Change[] $changes
 * @property-read \App\Upload $latestUpload
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operatingarea whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operatingarea whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operatingarea whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operatingarea whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operatingarea whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operatingarea whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operatingarea whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operatingarea whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operatingarea whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operatingarea whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operatingarea whereUuid($value)
 */
	class Operatingarea extends \Eloquent {}
}

namespace App{
/**
 * Class Report
 *
 * @package App
 * @property int $id
 * @property string|null $uuid
 * @property int|null $tenant_id
 * @property string|null $name
 * @property bool $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Report onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Report withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Report withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\User $creator
 * @property-read \App\User $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report query()
 * @property string|null $code
 * @property string|null $title
 * @property string|null $description
 * @property string|null $parameters
 * @property string|null $type
 * @property string|null $version
 * @property int|null $module_id
 * @property int|null $is_module_default
 * @property string|null $tags
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Change[] $changes
 * @property-read \App\Upload $latestUpload
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereIsModuleDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereModuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereParameters($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereVersion($value)
 */
	class Report extends \Eloquent {}
}

namespace App{
/**
 * Class Setting
 *
 * @package App
 * @property int $id
 * @property string|null $uuid
 * @property int|null $tenant_id
 * @property string|null $name
 * @property bool $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Setting onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Setting withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Setting withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\User $creator
 * @property-read \App\User $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting query()
 * @property string|null $title
 * @property string|null $type
 * @property string|null $description
 * @property string|null $value
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereValue($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Change[] $changes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @property-read \App\Upload $latestUpload
 */
	class Setting extends \Eloquent {}
}

namespace App{
/**
 * Class Statusupdate
 *
 * @package App
 * @property int $id
 * @property string|null $uuid
 * @property int|null $tenant_id
 * @property string|null $name
 * @property bool $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Statusupdate onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Statusupdate withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Statusupdate withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\User $creator
 * @property-read \App\User $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate query()
 * @property string|null $type
 * @property string|null $note
 * @property int|null $module_id
 * @property int|null $element_id
 * @property string|null $element_uuid
 * @property string|null $status
 * @property int|null $previous_id
 * @property string|null $previous_status
 * @property int|null $next_id
 * @property string|null $next_status
 * @property int|null $diff_secs
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Change[] $changes
 * @property-read \App\Upload $latestUpload
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereDiffSecs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereElementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereElementUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereModuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereNextId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereNextStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate wherePreviousId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate wherePreviousStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Statusupdate whereUuid($value)
 */
	class Statusupdate extends \Eloquent {}
}

namespace App{
/**
 * Class Task
 *
 * @package App
 * @property int $id
 * @property string|null $uuid
 * @property int|null $tenant_id
 * @property string|null $name
 * @property bool $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Task onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Task withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Task withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\User $creator
 * @property-read \App\User $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task query()
 * @property string|null $name_ext
 * @property int|null $parent_id
 * @property int|null $priority
 * @property int|null $seq
 * @property int|null $client_id
 * @property string|null $client_name
 * @property int|null $clientlocation_id
 * @property string|null $clientlocation_name
 * @property int|null $clientlocationtype_id
 * @property string|null $clientlocationtype_name
 * @property int|null $division_id
 * @property string|null $division_name
 * @property int|null $district_id
 * @property string|null $district_name
 * @property int|null $upazila_id
 * @property string|null $upazila_name
 * @property string|null $description
 * @property int|null $tasktype_id
 * @property string|null $tasktype_name
 * @property int|null $assignment_id
 * @property int|null $assigned_to
 * @property array|null $watchers
 * @property string|null $status
 * @property string|null $previous_status
 * @property string|null $due_date
 * @property string|null $days_open
 * @property int|null $is_closed
 * @property int|null $closed_by
 * @property string|null $closing_note
 * @property int|null $is_resolved
 * @property int|null $resolved_by
 * @property string|null $resolve_note
 * @property int|null $is_verified
 * @property int|null $verified_by
 * @property string|null $verify_note
 * @property int|null $is_flagged
 * @property int|null $flagged_by
 * @property string|null $flag_note
 * @property string|null $tags
 * @property-read \App\User|null $assignee
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Assignment[] $assignments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Change[] $changes
 * @property-read \App\Assignment $latestAssignment
 * @property-read \App\Upload $latestUpload
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereAssignedTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereAssignmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereClientName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereClientlocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereClientlocationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereClientlocationtypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereClientlocationtypeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereClosedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereClosingNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereDaysOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereDistrictName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereDivisionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereDivisionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereFlagNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereFlaggedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereIsClosed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereIsFlagged($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereIsResolved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereIsVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereNameExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task wherePreviousStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereResolveNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereResolvedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereSeq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereTasktypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereTasktypeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereUpazilaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereUpazilaName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereVerifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereVerifyNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereWatchers($value)
 */
	class Task extends \Eloquent {}
}

namespace App{
/**
 * Class Tasktype
 *
 * @package App
 * @property int $id
 * @property string|null $uuid
 * @property int|null $tenant_id
 * @property string|null $name
 * @property bool $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Tasktype onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Tasktype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Tasktype withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\User $creator
 * @property-read \App\User $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tasktype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tasktype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tasktype query()
 * @property int|null $parent_id
 * @property int|null $sla_days
 * @property int|null $sla_hours
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Change[] $changes
 * @property-read \App\Upload $latestUpload
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tasktype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tasktype whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tasktype whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tasktype whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tasktype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tasktype whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tasktype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tasktype whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tasktype whereSlaDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tasktype whereSlaHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tasktype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tasktype whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tasktype whereUuid($value)
 */
	class Tasktype extends \Eloquent {}
}

namespace App{
/**
 * Class Upload
 *
 * @package App
 * @property int $id
 * @property string|null $uuid
 * @property int|null $tenant_id
 * @property string|null $name
 * @property bool $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Upload onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Upload withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Upload withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\User $creator
 * @property-read \App\User $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload query()
 * @property string|null $type
 * @property string|null $path
 * @property int|null $order
 * @property string|null $ext
 * @property int|null $bytes
 * @property string|null $description
 * @property int|null $module_id
 * @property int|null $element_id
 * @property string|null $element_uuid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereBytes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereElementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereElementUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereModuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereUuid($value)
 * @property-read mixed $dir
 * @property-read bool $url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Change[] $changes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @property-read \App\Upload $latestUpload
 */
	class Upload extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string|null $uuid
 * @property int|null $tenant_id
 * @property string|null $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property bool $email_confirmed
 * @property string|null $email_confirmed_at
 * @property string|null $email_confirmation_code
 * @property string|null $access_token
 * @property string|null $access_token_generated_at
 * @property string|null $api_token
 * @property string|null $api_token_generated_at
 * @property bool $tenant_editable
 * @property string|null $permissions
 * @property string|null $  groups
 * @property string|null $group_ids_csv
 * @property string|null $group_titles_csv
 * @property bool $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[]
 *                $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccessTokenGeneratedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereApiTokenGeneratedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailConfirmationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGroupIdsCsv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGroupTitlesCsv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGroups($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePermissions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTenantEditable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUuid($value)
 * @mixin \Eloquent
 * @property int|null $partner_id
 * @property string|null $partner_name
 * @property int|null $charity_id
 * @property string|null $charity_name
 * @property string|null $name_initial
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $full_name
 * @property string|null $gender
 * @property string|null $avatar_url
 * @property string|null $profile_pic_url
 * @property string|null $device_token
 * @property string|null $address1
 * @property string|null $address2
 * @property string|null $city
 * @property string|null $county
 * @property int|null $country_id
 * @property string|null $country_name
 * @property string|null $zip_code
 * @property string|null $phone
 * @property string|null $mobile
 * @property int|null $notification_count
 * @property \Carbon\Carbon|string|null $first_login_at
 * @property \Carbon\Carbon|string|null $last_login_at
 * @property float|null $total_earnings
 * @property float|null $total_donations
 * @property int|null $recommendation_count
 * @property int|null $purchase_count
 * @property string|null $next_billing_at
 * @property string|null $share_code
 * @property string|null $paypal_email
 * @property string|null $payment_settings
 * @property string|null $account_holder_name
 * @property string|null $account_number
 * @property string|null $account_type
 * @property string|null $account_country
 * @property string|null $account_city
 * @property string|null $account_state
 * @property string|null $account_post_code
 * @property string|null $account_first_line
 * @property string|null $sort_code
 * @property string|null $abartn
 * @property string|null $iban
 * @property string|null $swift
 * @property string|null $auth_token
 * @property string|null $device_name
 * @property string|null $current_app_version
 * @property string|null $transferwise_account_id
 * @property string|null $session_secret
 * @property-read \App\User|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Group[] $groups
 * @property-read \App\User|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAbartn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccountCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccountCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccountFirstLine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccountHolderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccountPostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccountState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAuthToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAvatarUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCharityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCharityName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCountryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCounty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCurrentAppVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeviceName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeviceToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFirstLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereNameInitial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereNextBillingAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereNotificationCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePartnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePartnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePaymentSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePaypalEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereProfilePicUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePurchaseCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRecommendationCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSessionSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereShareCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSortCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSwift($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTotalDonations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTotalEarnings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTransferwiseAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereZipCode($value)
 * @property string|null $email_verified_at
 * @property string|null $partner_uuid
 * @property string|null $charity_uuid
 * @property mixed $currency
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Change[] $changes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCharityUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePartnerUuid($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Aiddeclaration[] $aiddeclarations
 * @property-read \App\Charity|null $charity
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Charityselection[] $charityselctions
 * @property-read \App\Country|null $country
 * @property-read \App\Aiddeclaration $currentAiddeclaration
 * @property-read \App\Charityselection $currentCharityselction
 * @property-read \App\Upload $latestUpload
 * @property-read \App\Partner|null $partner
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCurrency($value)
 * @property string|null $social_account_id
 * @property string|null $social_account_type
 * @property int|null $gift_aid_checked
 * @property-read \App\Charityselection $currentCharityselection
 * @property-read mixed $avatar
 * @property-read \App\Invoice $lastInvoice
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGiftAidChecked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSocialAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSocialAccountType($value)
 * @property string|null $email_verification_code
 * @property array|null $group_ids
 * @property int|null $designation_id
 * @property string|null $designation_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDesignationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDesignationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerificationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGroupIds($value)
 */
	class User extends \Eloquent {}
}

