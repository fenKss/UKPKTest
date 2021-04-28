<?php


namespace App\ENum;

use MyCLabs\Enum\Enum;

/**
 * Class EImageType
 *
 * @method static EQuestionTextType TEXT_TYPE
 * @method static EQuestionTextType IMAGE_TYPE
 * @package App\ENum
 */
class EQuestionTextType extends Enum
{
    public const TEXT_TYPE = 0;
    public const IMAGE_TYPE = 1;
}