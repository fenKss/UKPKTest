<?php


namespace App\ENum;


use MyCLabs\Enum\Enum;

/**
 * Class EOlympType
 * @method static EOlympType COLLEGE_TYPE
 * @method static EOlympType CITY_TYPE
 * @method static EOlympType REGION_TYPE
 * @method static EOlympType COUNTRY_TYPE
 * @method static EOlympType WORLD_TYPE
 *
 * @package App\ENum
 */
class EOlympType extends Enum
{
    public const COLLEGE_TYPE = 'college';
    public const CITY_TYPE = 'city';
    public const REGION_TYPE = 'region';
    public const COUNTRY_TYPE = 'country';
    public const WORLD_TYPE = 'world';
}