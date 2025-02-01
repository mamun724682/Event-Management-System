<?php

namespace App\Enums;

enum EventFieldsEnum: string
{
    case ID              = "id";
    case USER_ID         = "user_id";
    case NAME            = "name";
    case SLUG            = "slug";
    case DATE            = "date";
    case LOCATION        = "location";
    case CAPACITY        = "capacity";
    case TOTAL_ATTENDEES = "total_attendees";
    case DESCRIPTION     = "description";
    case CREATED_AT      = "created_at";
    case UPDATED_AT      = "updated_at";
}
