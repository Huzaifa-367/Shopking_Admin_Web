<?php

use App\Enums\OrderStatus;

return [
    OrderStatus::PENDING    => 'زیر التواء',
    OrderStatus::CONFIRMED  => 'تصدیق شدہ',
    OrderStatus::ON_THE_WAY => 'راہ میں ہے',
    OrderStatus::DELIVERED  => 'سپرد کر دیا گیا',
    OrderStatus::CANCELED   => 'منسوخ کر دیا گیا',
    OrderStatus::REJECTED   => 'مسترد',
];
