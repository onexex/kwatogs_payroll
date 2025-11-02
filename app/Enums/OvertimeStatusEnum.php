<?php 

namespace App\Enums;

use App\Traits\EnumToArray;

enum OvertimeStatusEnum: string
{
    use EnumToArray;

    case FORAPPROVAL = 'FOR APPROVAL';

    case CANCELED = 'CANCELED';

    case APPROVED = 'APPROVED';

    case DISAPPROVED = 'DISAPPROVED';
}