<?php

namespace App\Http\Controllers\Frontends\Auth;

use App\Http\Controllers\Controller;
use App\Models\SgoOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login()
    {
        return view('frontends.pages.login');
    }

    public function authenticate(Request $request)
    {
        $creadentials = Validator::make(
            $request->all(),
            [
                'email' => 'required|exists:users,email|email',
                'password' => 'required'
            ],
            __('request.messages'),
            [
                'email' => 'Email',
                'password' => 'Mật khẩu'
            ]
        );

        if ($creadentials->fails()) {
            return response()->json(
                [
                    'status_code' => 422,
                    'error' => $creadentials->errors()->first(),
                ]
            );
        }

        $creadentials = $creadentials->validated();

        if (auth()->attempt($creadentials)) {

            $account = $request->user();

            if ($account->role_id == 1) {
                auth()->logout();
                return response()->json(['status_code' => 400, 'message' => 'Tài khoản Admin không thể truy cập!']);
            }

            $intendedUrl = session('url.intended', route('home'));
            return response()->json([
                'message' => 'Đăng nhập thành công!',
                'redirect' => $intendedUrl,
                'status_code' => 200
            ]);
        }

        return response()->json(['message' => 'Email hoặc mật khẩu không chính xác!'], 401);
    }

    public function register(Request $request)
    {
        $creadentials = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required'
            ],
            __('request.messages'),

            [
                'name' => 'Tên',
                'email' => 'Email',
                'password' => 'Mật khẩu'
            ]
        );

        if ($creadentials->fails()) {
            return response()->json([
                'message' => $creadentials->errors()->first(),
                'status' => false
            ]);
        }

        $creadentials = $creadentials->validated();

        $creadentials['password'] = Hash::make($creadentials['password']);

        $account = User::create($creadentials);

        auth()->login($account);

        $intendedUrl = session('url.intended', route('home'));
        return response()->json([
            'message' => 'Đăng ký thành công!',
            'redirect' => $intendedUrl,
            'status' => true
        ]);
    }

    public function logout()
    {
        auth()->logout();

        session()->flush();

        return redirect(route('home'));
    }

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle()
    {
        try {
            $google_user = Socialite::driver('google')->user();

            $user = User::where('google_id', $google_user->getId())->first();

            if (!$user) {
                $new_user = User::create([
                    'name' => $google_user->getName(),
                    'email' => $google_user->getEmail(),
                    'google_id' => $google_user->getId(),
                    'password' => Hash::make($google_user->getEmail()),
                ]);

                auth()->login($new_user);
            } else {
                auth()->login($user);
            }
            return redirect()->intended('/');
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            dd('something went wrong' . $e->getMessage());
        }
    }

    public function profile()
    {
        // /**
        //  * @var User $user
        //  */
        // $user = User::with(['orders' => function ($q) {
        //     $q->latest();
        // }])->findOrFail(auth()->id());
        $orders = SgoOrder::query()->with('user')->latest()->where('user_id', auth()->id())->paginate(5);

        return view('frontends.pages.profile', compact('orders'));
    }

    public function handleChangeInfo(Request $request)
    {
        $credentials = Validator::make(
            $request->toArray(),
            [
                'name' => 'required|max:50|min:3',
                'phone' => 'nullable|regex:/^0[0-9]{9}$/', // Sử dụng regex cho số điện thoại
                'email' => 'required|email|unique:users,email,' . auth()->id(),
                'address' => 'nullable|max:100|min:3'
            ],
            __('request.messages'),
            [
                'name' => 'Tên',
                'email' => 'Email',
                'phone' => 'Số điện thoại',
                'address' => 'Địa điểm'
            ]
        );

        if ($credentials->fails()) {
            return response()->json([
                'success' => false,
                'message' => $credentials->errors()->first(),
            ]);
        }

        $user = User::findOrFail(auth()->id());

        $user->update($credentials->validated());

        // auth()->setUser($user);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thông tin thành công!',
            'username' => $user->name
        ]);
    }

    public function handleChangePassword(Request $request)
    {
        $credentials = Validator::make(
            $request->toArray(),
            [
                'current_password' => ['required', 'string'],
                'password' => ['required', 'string', 'min:6'],
                'confirm_password' => 'required|same:password'
            ],
            __('request.messages'),
            [
                'current_password' => 'Mật khẩu cũ',
                'password' => 'Mật khẩu mới'
            ]
        );

        if ($credentials->fails()) {
            return response()->json([
                'success' => false,
                'message' => $credentials->errors()->first(),
            ]);
        }

        $user = auth()->user();

        $credentials = $credentials->validated();

        if (!Hash::check($credentials['current_password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Mật khẩu cũ không đúng.',
            ]);
        }

        /**
         * @var User $user
         */

        $user->update([
            'password' => Hash::make($credentials['password']),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đổi mật khẩu thành công.',
        ]);
    }
}
