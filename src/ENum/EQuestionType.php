<?php


namespace App\ENum;


use MyCLabs\Enum\Enum;

/**
 * Class EQuestionType
 * @method static EQuestionType RADIO_TYPE
 * @method static EQuestionType SELECT_TYPE
 *
 * @package App\ENum
 */
class EQuestionType extends Enum
{
    public const RADIO_TYPE = 'radio';
    public const SELECT_TYPE = 'select';
}