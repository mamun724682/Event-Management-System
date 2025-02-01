<?php

namespace App\Enums;

enum AttendeeFiltersEnum: string
{
    case ID         = "id";
    case USER_ID    = "user_id";
    case EVENT_ID   = "event_id";
    case NAME       = "name";
    case EMAIL      = "email";
    case PHONE      = "phone";
    case CREATED_AT = "created_at";

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
