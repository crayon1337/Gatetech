<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Repository\User\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
                'tokenType' => 'Bearer',
                'token' => $token,
                'user' => $auth,
            ]);
        } else
            return response()->json([
                'message' => 'Something went wrong. Please double check your email & password'
            ], 401);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function makeAdmin(Request $request, $id): JsonResponse
    {
        if(!$request->user()->isAdmin)
            return response()->json(['message' => 'You have to be an administrator to perform this action'], 403);

        $user = $this->userRepository->findOrFail($id);

        $user->update([
            'isAdmin' => true,
        ]);

        return response()->json(['message' => 'Successfully changed the role of the user to be an administrator']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        // Get the user from the request
        $user = $request->user();

        // Delete user tokens
        $user->tokens()->delete();

        // Return successful message with status code: 200
        return response()->json(['message' => 'Successfully logged out! See you later...']);
    }

    /**
     * @param UserUpdateRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function updateUserInfo(UserUpdateRequest $request, $id): JsonResponse
    {
        // Validate the data
        $data = $request->validated();

        // Find the user to edit
        $user = $this->userRepository->findOrFail($id);

        // Update user information data
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
        ]);

        // If the password has been set then update it.
        if(isset($data['password'])) {
            $user->password = bcrypt($data['password']);
            $user->save();
        }

        // Return successful response
        return response()->json(['message' => 'Your profile has been updated...']);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function refreshUserInfo(Request $request)
    {
        return $request->user();
    }
}
