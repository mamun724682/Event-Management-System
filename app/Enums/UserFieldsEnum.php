<?php

namespace App\Enums;

enum UserFieldsEnum: string
{
    case ID         = "id";
    case NAME       = "name";
    case EMAIL      = "email";
    case PASSWORD   = "password";
    case CREATED_AT = "created_at";
    case UPDATED_AT = "updated_at";

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
