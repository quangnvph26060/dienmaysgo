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

function hasCustomDiscount($startDate, $endDate, $value)
{
    if ($value <= 0) return false; // Nếu không có giá trị giảm giá, trả về false

    $now = Carbon::now(); // Lấy thời gian hiện tại với giờ, phút, giây

    // Nếu không có ngày bắt đầu và ngày kết thúc => luôn true
    if (!$startDate && !$endDate) return true;

    // Nếu có ngày bắt đầu nhưng không có ngày kết thúc => luôn true
    if ($startDate && !$endDate) return true;

    // Nếu có cả startDate và endDate => Kiểm tra khoảng thời gian chính xác
    if (Carbon::parse($startDate)->lessThanOrEqualTo($now) && Carbon::parse($endDate)->greaterThanOrEqualTo($now)) {
        return true;
    }

    return false;
}


function calculateAmount($amount, $discount, $isPercentage = true)
{
    if ($isPercentage) {
        // Tính toán giảm giá theo phần trăm
        $discountAmount = $amount * ($discount / 100);
        $finalAmount = $amount - $discountAmount;
    } else {
        // Tính toán giảm giá theo số tiền cố định
        $finalAmount = $amount - $discount;
    }

    return $finalAmount;
}

function calculateDiscountPercentage($originalPrice, $discountAmount, $type)
{
    if ($type == 'percentage') return $discountAmount;
    if ($originalPrice == 0) {
        return 0; // Tránh chia cho 0
    }
    $discountPercentage = ($discountAmount / $originalPrice) * 100;
    return $discountPercentage;
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

if (!function_exists('generateRandomString')) {
    function generateRandomString()
    {
        $prefix = "ODR"; // 3 ký tự đầu cố định
        $fourthChar = rand(1, 9); // Ký tự thứ 4 là số lớn hơn 0
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'; // Bảng ký tự cho phần còn lại
        $remainingLength = 7; // Tổng độ dài là 11, trừ 4 ký tự đầu

        $randomString = '';
        for ($i = 0; $i < $remainingLength; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $prefix . $fourthChar . $randomString;
    }
}

function saveImageNew($image, string $inputName, string $directory = 'images')
{
    if ($image) {
        $filename = time() . uniqid() . '.' . $image->getClientOriginalExtension();
        Storage::disk('public')->put($directory . '/' . $filename, file_get_contents($image->getPathName()));
        return $directory . '/' . $filename;
    }

    return null; // Trả về null nếu không có ảnh
}

if (!function_exists('statusColor')) {
    function statusColor($status)
    {
        switch ($status) {
            case 'pending':
                return '<span class="badge bg-warning">Chờ xử lý...</span>';
            case 'confirmed':
                return '<span class="badge bg-primary">Đã xác nhận</span>';
            case 'completed':
                return '<span class="badge bg-success">Đơn hàng đã hoàn thành</span>';
            case 'cancelled':
                return '<span class="badge bg-danger">Đã hủy</span>';
            default:
                return '<span class="badge bg-warning">Chờ xử lý...</span>';
        }
    }
}

if (!function_exists('paymentStatus')) {
    function paymentStatus($status)
    {
        switch ($status) {
            case '0':
                return '<span class="badge bg-danger">Chưa thanh toán...</span>';
            case '1':
                return '<span class="badge bg-success">Đã thanh toán</span>';
            case '2':
                return '<span class="badge bg-warning">Thanh toán đặt cọc</span>';
            default:
                return '<span class="badge bg-danger ">Chưa thanh toán...</span>';
        }
    }
}

if (!function_exists('paymentMethods')) {
    function paymentMethods($method)
    {
        switch ($method) {
            case 'cod':
                return '<span class="badge bg-danger">Thanh toán khi nhận hàng (COD)</span>';
            case 'bacs':
                return '<span class="badge bg-success">Thanh toán chuyển khoản</span>';
            case 'currency':
                return '<span class="badge bg-warning">Thanh toán đặt cọc</span>';
        }
    }
}

if (!function_exists('changeStatus')) {
    function changeStatus($status)
    {
        switch ($status) {
            case 'pending':
                return 'confirmed';
            case 'confirmed':
                return 'completed';
        }
    }
}
function saveImagesWithoutResize($request, string $inputName, string $directory = 'images', $isArray = false)
{
    $paths = [];

    // Kiểm tra xem có file không
    if ($request->hasFile($inputName)) {
        // Lấy tất cả các file hình ảnh
        $images = $request->file($inputName);

        if (!is_array($images)) {
            $images = [$images]; // Đưa vào mảng nếu chỉ có 1 ảnh
        }

        foreach ($images as $key => $image) {
            // Tạo tên file duy nhất
            $filename = time() . uniqid() . '.' . $image->getClientOriginalExtension();

            // Lưu ảnh vào storage
            Storage::disk('public')->putFileAs($directory, $image, $filename);

            // Lưu đường dẫn vào mảng
            $paths[$key] = $directory . '/' . $filename;
        }

        // Trả về danh sách các đường dẫn
        return $isArray ? $paths : $paths[0];
    }

    return null;
}

function formatString($json = null)
{
    if (empty($json))  return null;

    $keywordsArray = json_decode($json, true);

    $keywordsString = implode(', ', array_column($keywordsArray, 'value'));

    return $keywordsString;
}




if (!function_exists('generateRandomNumber')) {
    /**
     * Generate a random number with a specified length
     *
     * @param int $length
     * @return string
     */
    function generateRandomNumber($length = 10)
    {
        // Ensure the length is at least 1
        $length = max(1, (int)$length);

        // Generate the first digit (1-9) to avoid leading zero
        $firstDigit = mt_rand(1, 9);

        // Generate the remaining digits (0-9)
        $remainingDigits = '';
        if ($length > 1) {
            $remainingDigits = substr(str_shuffle(str_repeat('0123456789', $length - 1)), 0, $length - 1);
        }

        return $firstDigit . $remainingDigits;
    }
}

if (!function_exists('formatName')) {
    /**
     * Format a string to uppercase without diacritics
     *
     * @param string $name
     * @return string
     */
    function formatName($name)
    {
        // Loại bỏ dấu bằng hàm Laravel support
        $nameWithoutDiacritics = \Illuminate\Support\Str::ascii($name);

        // Chuyển thành chữ in hoa
        return strtoupper($nameWithoutDiacritics);
    }
}

if (!function_exists('convertToSentenceCase')) {
    function convertToSentenceCase($string)
    {
        $string = mb_strtolower(trim(preg_replace('/\s+/', ' ', $string))); // Chuyển thành chữ thường và loại bỏ khoảng trắng thừa
        return ucfirst($string); // Viết hoa chữ cái đầu tiên
    }
}

if (!function_exists('activeMenu')) {
    function activeMenu($url)
    {
        return request()->routeIs($url) ? 'active' : '';
    }
}
