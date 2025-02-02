<?php

namespace App\Imports;

use App\Models\SgoProduct;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Kiểm tra URL hợp lệ
        $imageUrl = $row['anh_san_pham'];

        $price = preg_replace('/\D/', '', $row['gia']);

        if (empty($imageUrl) || !filter_var($imageUrl, FILTER_VALIDATE_URL)) {
            return null; // Bỏ qua dòng nếu URL không hợp lệ
        }

        try {
            // Tải ảnh từ URL
            $imageContents = file_get_contents($imageUrl);
            $imageName = 'products/' . Str::random(10) . '.' . pathinfo($imageUrl, PATHINFO_EXTENSION);

            // Lưu ảnh vào storage/app/public/products
            Storage::put($imageName, $imageContents);

            $imagePath = $imageName;
        } catch (\Exception $e) {
            $imagePath = null; // Nếu tải ảnh thất bại
        }

        // Lưu thông tin sản phẩm vào cơ sở dữ liệu
        return new SgoProduct([
            'name'         => $row['ten_san_pham'],
            'slug'         => Str::slug($row['ten_san_pham']),
            'image'        => $imagePath,
            'price'        => $price,
            'import_price' => 10,
        ]);
    }
}

// "stt" => 1
// "ten_san_pham" => "Giàn Khoan Đá KSZ100 Khí Nén"
// "gia" => "45.200.000 VND"
// "gia_cu" => "50.000.000 VND"
// "anh_san_pham" => "https://mayxaydunghoangphuc.vn/uploads/source/%E1%BA%A2nh%20GG/gian-khoan-da-ksz100-khi-nen-mayxaydunghoangphuc.jpg"
