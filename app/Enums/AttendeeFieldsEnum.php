<?php

namespace App\Enums;

enum AttendeeFieldsEnum: string
{
    case ID         = "id";
    case EVENT_ID   = "event_id";
    case NAME       = "name";
    case EMAIL      = "email";
    case PHONE      = "phone";
    case CREATED_AT = "created_at";
    case UPDATED_AT = "updated_at";
}
