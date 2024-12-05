<?php

use Carbon\Carbon;

function hasDiscount($discount)
{
    // Nếu không có giảm giá, trả về false
    if (is_null($discount)) return false;

    // Nếu ngày hiện tại nằm trong khoảng thời gian giảm giá, trả về true
    if ($discount->start_date <= Carbon::now() && $discount->end_date >= Carbon::now()) {
        return true;
    }

    // Nếu giảm giá đã hết hạn, hoặc chưa bắt đầu, trả về false
    return false;
}

function calculateAmount($amount, $discountPercentage)
{
    // Tính toán giá sau khuyến mãi
    $discountAmount = $amount * ($discountPercentage / 100);
    $finalAmount = $amount - $discountAmount;

    return $finalAmount;
}

function formatAmount($amount)
{
    return number_format($amount, 0, ',', '.');
}
