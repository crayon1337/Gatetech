<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Repository\User\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $userRepository;

    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param RegisterRequest $request
     * @return mixed
     */
    public function register(RegisterRequest $request)
    {
        // Validate the data
        $data = $request->validated();

        // Encrypt the password
        $data['password'] = bcrypt($data['password']);

        // Create the user
        $user = $this->userRepository->create($data);

        // Return user data to the endpoint
        return response()->json([
            'message' => 'You have been registered successfully',
            'user'    => $user
        ]);
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        // Make sure the request has the required parameters
        $data = $request->validated();

        // Attempt to login

        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $auth = Auth::user();

            $token = $auth->createToken('LaravelSanctumAuth')->plainTextToken;

            return response()->json([
                'message' => 'Welcome back!',
                'token' => $token
            ]);
        } else {
            return response()->json([
                'message' => 'Something went wrong. Please double check your email & password'
            ]);
        }
    }
}
