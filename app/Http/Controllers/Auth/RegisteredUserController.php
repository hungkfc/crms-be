<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Http\JsonResponse; 

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        // // 1. Validation (Giữ nguyên)
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
        //     'password' => ['required', 'confirmed', Rules\Password::defaults()],
        // ]);

        // // 2. Tạo User (Giữ nguyên)
        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        // ]);

        // event(new Registered($user));

        // // 3. LOẠI BỎ logic Session và Redirect đã được xử lý ở đây

        // // 4. THÊM logic API Token (Sanctum)
        
        // // Tạo token cho người dùng mới
        // $token = $user->createToken('auth_token')->plainTextToken; 

        // // Trả về phản hồi JSON với mã 201 Created (chuẩn cho POST/tạo mới)
        // return response()->json([
        //     'message' => 'Registration successful.',
        //     'user' => $user, // Tùy chọn: trả về thông tin user
        //     'token' => $token,
        // ], 201);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;
   
        return $this->sendResponse($success, 'User register successfully.');
    }
}