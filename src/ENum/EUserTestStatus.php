<?php


namespace App\ENum;

/**
 * Class EUserTestStatus
 *
 * @method static EUserTestStatus WAITING_PAY_TYPE
 * @method static EUserTestStatus PAID_TYPE
 * @method static EUserTestStatus STARTED_TYPE
 * @method static EUserTestStatus WAITING_END_TYPE
 * @method static EUserTestStatus FINISHED_TYPE
 * @package App\ENum
 */
class EUserTestStatus
{
    public const WAITING_PAY_TYPE = 0;
    public const PAID_TYPE = 1;
    public const STARTED_TYPE = 2;
    public const WAITING_END_TYPE = 3;
    public const FINISHED_TYPE = 4;
}