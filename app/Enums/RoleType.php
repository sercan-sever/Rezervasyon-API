<?php

namespace App\Enums;

use App\Traits\EnumValues;
use Illuminate\Support\Collection;

enum RoleType: string
{
    use EnumValues;

    case SUPER_ADMIN = 'super-admin';
    case ADMIN      = 'admin';
    case CUSTOMER   = 'customer';


    /**
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'Süper Admin',
            self::ADMIN => 'Yönetici',
            self::CUSTOMER => 'Müşteri',
            default => '',
        };
    }


    /**
     * @return string
     */
    public static function getByAdminRole(): string
    {
        return self::SUPER_ADMIN->value . '|' . self::ADMIN->value;
    }

    /**
     * @return string
     */
    public static function getByUsersRole(): string
    {
        return self::CUSTOMER->value;
    }

    /**
     * @return string
     */
    public static function getRoleValue(Collection|array $roles): string
    {
        if (empty($roles[0]) || !is_string($roles[0])) return '';

        return match ($roles[0]) {
            self::SUPER_ADMIN->value => self::SUPER_ADMIN->value,
            self::ADMIN->value => self::ADMIN->value,
            self::CUSTOMER->value => self::CUSTOMER->value,
            default => '',
        };
    }

    /**
     * @return string
     */
    public static function getRoleName(Collection|array|null $roles): string
    {
        if (empty($roles[0]) || !is_string($roles[0])) return '';

        return match ($roles[0]) {
            self::SUPER_ADMIN->value => self::SUPER_ADMIN->label(),
            self::ADMIN->value => self::ADMIN->label(),
            self::CUSTOMER->value => self::CUSTOMER->label(),
            default => '',
        };
    }
}
