<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use League\CommonMark\CommonMarkConverter;

class BulkActionController extends Controller
{

    protected $apiKey;
    protected $url;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
        $this->url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key={$this->apiKey}";
    }

    public function deleteItems(Request $request)
    {
        $validatedData = $request->validate([
            'model' => 'required|string',
            'ids' => 'required|array',
        ]);

        $modelClass = 'App\\Models\\' . $validatedData['model'];

        // Kiểm tra xem class có tồn tại hay không
        if (!class_exists($modelClass)) {
            return response()->json(['message' => 'Model không hợp lệ.'], 400);
        }

        try {
            // Thực hiện xóa các bản ghi dựa trên ID
            $modelClass::whereIn($request->input('column'), $validatedData['ids'])->delete();

            return response()->json(['message' => 'Xóa thành công!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
        }
    }

    public function changeOrder(Request $request)
    {
        $order = $request->input('order');
        $model = 'App\\Models\\' . $request->input('model'); // Tạo namespace model

        if (!class_exists($model)) {
            return response()->json(['error' => 'Model không tồn tại'], 400);
        }

        foreach ($order as $index => $id) {
            $model::where('id', $id)->update(['location' => $index + 1]);
        }

        logInfo(Cache::has('home_data') ? '1' : '2');
        logInfo(Cache::has('categories') ? '3' : '3');

        Cache::forget('home_data');
        Cache::forget('categories');

        return response()->json(['status' => 'success']);
    }

    public function generatePrompt($prompt)
    {
        if (!$prompt) {
            return response()->json(["error" => "Prompt không được để trống!"], 400);
        }

        $response = Http::post($this->url, [
            "contents" => [
                [
                    "parts" => [
                        ["text" => $prompt]
                    ]
                ]
            ]
        ]);

        if ($response->failed()) {
            return response()->json(["error" => "Lỗi khi gọi API Gemini!", "details" => $response->body()], $response->status());
        }

        $data = $response->json();

        // Kiểm tra dữ liệu trả về
        if (!isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            return response()->json(["error" => "Không có kết quả từ API!"], 200);
        }

        // Lấy nội dung Markdown từ Gemini
        $markdownText = $data['candidates'][0]['content']['parts'][0]['text'];

        // Chuyển Markdown thành HTML
        $converter = new CommonMarkConverter();
        $htmlContent = $converter->convert($markdownText)->getContent(); // Fix lỗi trả về object

        if (request()->ajax()) {
            return response()->json([
                "html" => $htmlContent // Trả về HTML đúng
            ]);
        }

        return $htmlContent;
    }

    public function askGemini(Request $request)
    {
        return $this->generatePrompt($request->prompt);
    }
}
