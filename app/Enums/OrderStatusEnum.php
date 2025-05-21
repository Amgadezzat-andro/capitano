<?php 
enum OrderStatusEnum:int  {
    case pendding = 1;
    case processing =2;
    case cancel =3;
    case shipped=4;
    case completed =5;
    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}