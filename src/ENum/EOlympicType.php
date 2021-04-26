<?php


namespace App\ENum;


use MyCLabs\Enum\Enum;

/**
 * Class EOlympicType
 *
 * @method static EOlympicType COLLEGE_TYPE
 * @method static EOlympicType CITY_TYPE
 * @method static EOlympicType REGION_TYPE
 * @method static EOlympicType COUNTRY_TYPE
 * @method static EOlympicType WORLD_TYPE
 *
 * @package App\ENum
 */
class EOlympicType extends Enum
{
    public const COLLEGE_TYPE = 0;
    public const CITY_TYPE = 1;
    public const REGION_TYPE = 2;
    public const COUNTRY_TYPE = 3;
    public const WORLD_TYPE = 4;
}