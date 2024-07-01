<?php

namespace App\Http\API\V1\Controllers\Auth;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Auth\AuthRepository;
use App\Http\API\V1\Requests\Auth\LoginRequest;
use App\Http\API\V1\Requests\Auth\LogoutRequest;
use App\Http\API\V1\Requests\Auth\RegisterRequest;
use App\Http\API\V1\Requests\Auth\UpdateRequest;
use App\Http\API\V1\Requests\Auth\VerifyOtpRequest;
use App\Http\Resources\Auth\LoginResource;
use App\Http\Resources\User\ProfileResource;
use App\Models\User;
use App\Notifications\EmailVerification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;

/**
 * @group User
 * APIs for User Management
 *
 * @subgroup Auth management
 *
 * @subgroupDescription APIs for login, register and all about auth
 */
class AuthController extends Controller
{
    public function __construct(
        protected AuthRepository $authRepository,
    ) {
        $this->middleware('auth:sanctum')->only(['update', 'profile', 'logout']);
    }

    /**
     * Register
     *
     * This endpoint lets you add a new user
     *
     * @unauthenticated
     *
     * @responseFile storage/responses/auth/register.json
     */
    public function register(RegisterRequest $request): JsonResponse
    {

        $userData = $request->validated();
        $result = $this->authRepository->register($userData);

        return $this->showOne($result, LoginResource::class, __('User registered successfully'));

    }

    /**
     * Login
     *
     * This endpoint lets you log in with specific user
     *
     * @unauthenticated
     *
     * @responseFile storage/responses/auth/login.json
     *
     * @return mixed
     *
     * @throws ValidationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $data = collect($request->validated());
        $authData = $this->authRepository->login($data);

        return $this->showOne($authData, LoginResource::class);

    }

    /**
     * Request email OTP
     *
     * This endpoint lets you send OTP through email
     *
     * @responseFile storage/responses/auth/request_email_otp.json
     */
    public function requestEmailOTP(): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $code = $this->authRepository->generateUserOTP($user);
        Notification::route('mail', $user->email)->notify((new EmailVerification($user, $code)));

        return $this->responseMessage(__('Code is sent successfully'));

    }

    /**
     * Validate email
     *
     * This endpoint lets you verify email using otp code
     *
     * @responseFile storage/responses/auth/verify_email.json
     *
     * @throws ValidationException
     */
    public function verifyEmailOTP(VerifyOtpRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = $this->authRepository->verifyUserEmail($data['otp_code']);
        if ($user) {
            $token = $user->createAuthToken();

            return $this->showOne($token, LoginResource::class, 'Email verified successfully');
        } else {
            throw ValidationException::withMessages([
                'otp_code' => ['Invalid OTP code'],
            ]);
        }
    }

    /**
     * Logout
     *
     * This endpoint lets you log out
     *
     * @queryParam token string required User's token.
     * @queryParam udid string User's device udid.
     *
     * @responseFile storage/responses/auth/logout.json
     */
    public function logout(LogoutRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $this->authRepository->logout($user);

        return $this->responseMessage(__('Successfully logged out'));
    }

    /**
     * Show user's profile
     *
     * This endpoint lets you show user's authenticated profile
     *
     * @responseFile storage/responses/auth/profile.json
     */
    public function profile(): JsonResponse
    {
        return $this->showOne($this->authRepository->profile(), ProfileResource::class);
    }

    /**
     * Update user
     *
     * This endpoint lets you update user's information
     *
     * @responseFile storage/responses/auth/update.json
     *
     * @return mixed
     */
    public function update(UpdateRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $user_data = $request->validated();

        $updatedUser = $this->authRepository->update($user, $user_data);

        return $this->showOne($updatedUser, ProfileResource::class, __('Your information updated successfully'));
    }
}
