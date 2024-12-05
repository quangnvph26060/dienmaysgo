<?php

use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Filesystem\FilesystemAdapter;
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

function saveImages($request, string $inputName, string $directory = 'images', $width = 150, $height = 150, $isArray = false)
{
    $paths = [];

    // Kiểm tra xem có file không
    if ($request->hasFile($inputName)) {
        // Lấy tất cả các file hình ảnh
        $images = $request->file($inputName);

        if (!is_array($images)) {
            $images = [$images]; // Đưa vào mảng nếu chỉ có 1 ảnh
        }

        // Tạo instance của ImageManager
        $manager = new ImageManager(new Driver());

        foreach ($images as $key => $image) {
            // Đọc hình ảnh từ đường dẫn thực
            $img = $manager->read($image->getPathName());

            // Thay đổi kích thước
            $img->resize($width, $height);

            // Tạo tên file duy nhất
            $filename = time() . uniqid() . '.' . $image->getClientOriginalExtension();

            // Lưu hình ảnh đã được thay đổi kích thước vào storage
            Storage::disk('public')->put($directory . '/' . $filename, $img->encode());

            // Lưu đường dẫn vào mảng
            $paths[$key] = $directory . '/' . $filename;
        }

        // Trả về danh sách các đường dẫn
        return $isArray ? $paths : $paths[0];
    }

    return null;
}


function saveImage($request, string $inputName, string $directory = 'images')
{
    if ($request->hasFile($inputName)) {
        $image = $request->file($inputName);
        $filename = time() . uniqid() . '.' . $image->getClientOriginalExtension();
        Storage::disk('public')->put($directory . '/' . $filename, file_get_contents($image->getPathName()));
        return $directory . '/' . $filename;
    }
}

function showImage($path, $default = 'image-default.jpg')
{
    /** @var FilesystemAdapter $storage */
    $storage = Storage::disk('public');

    if ($path && Storage::exists($path)) {
        return $storage->url($path);
    }

    return asset('backend/assets/img/' . $default);
}

function deleteImage($path)
{
    if ($path && Storage::disk('public')->exists($path)) {
        Storage::disk('public')->delete($path);
    }
}
