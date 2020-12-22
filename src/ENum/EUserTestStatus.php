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
    public const WAITING_PAY_TYPE = 'waiting_pay';
    public const PAID_TYPE = 'paid';
    public const STARTED_TYPE = 'started';
    public const WAITING_END_TYPE = 'waiting_end';
    public const FINISHED_TYPE = 'finished';
}