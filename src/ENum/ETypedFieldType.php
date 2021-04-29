<?php


namespace App\ENum;

use MyCLabs\Enum\Enum;

/**
 * Class ETypedFieldType
 *
 * @method static ETypedFieldType TEXT_TYPE
 * @method static ETypedFieldType IMAGE_TYPE
 * @package App\ENum
 */
class ETypedFieldType extends Enum
{
    public const TEXT_TYPE = 0;
    public const IMAGE_TYPE = 1;
}