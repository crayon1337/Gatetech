<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Repository\User\UserRepository;

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
        return response()->json($user);
    }
}
