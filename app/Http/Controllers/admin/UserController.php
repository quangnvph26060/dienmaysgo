<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function getUserInfor($id)
    {
        $page = "Thông tin cá nhân";
        $title = "Thông tin cá nhân";
        try {
            $user = User::findOrFail($id);
            return view('backend.user.detail', compact('user', 'page', 'title'));
        } catch (Exception $e) {
            Log::error('Failed to find this user: ' . $e->getMessage());
            return redirect()->back()->with('Failed to find this user');
        }
    }

    public function updateUserInfor(Request $request, $id)
    {
        try {
            if ($request->hasFile('image')) {
                deleteImage(Auth::user()->image);
            }
            Log::info("Received requet to update user with Id: " . $id);

            $image = saveImage($request, 'image', 'user_images');

            DB::beginTransaction();
            $criteria = $request->all();
            $user = User::findOrFail($id);

            if ($image) {
                $criteria['image'] = $image;
            }

            $user->update($criteria);
            DB::commit();
            session()->flash('success', 'Thay đổi thông tin thành công');
            return redirect()->back();
        } catch (Exception $e) {
            Log::error('Faile to update this user info: ' . $e->getMessage());
            return redirect()->back()->with('Thay đổi thông tin thất bại');
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $userId = Auth::user()->id;
            $currentPassword = $request->password;
            $newPassword = $request->newPassword;
            $confirmPassword = $request->confirmPassword;

            // Tìm người dùng theo ID
            $admin = User::findOrFail($userId);

            // Kiểm tra mật khẩu hiện tại
            if (!Hash::check($currentPassword, $admin->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Mật khẩu hiện tại không đúng!'
                ]);
            }

            // Kiểm tra mật khẩu mới không được trùng với mật khẩu cũ
            if ($newPassword === $currentPassword) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Mật khẩu mới không được trùng mật khẩu cũ!'
                ]);
            }

            // Kiểm tra xác nhận mật khẩu mới
            if ($newPassword !== $confirmPassword) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Xác nhận mật khẩu không đúng!'
                ]);
            }

            // Lưu mật khẩu mới
            $admin->password = Hash::make($newPassword);
            $admin->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Đổi mật khẩu thành công !'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Người dùng không tồn tại!'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Đã xảy ra lỗi, vui lòng thử lại sau!'
            ], 500);
        }
    }
}
