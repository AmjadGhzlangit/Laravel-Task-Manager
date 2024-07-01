<?php

namespace App\Http\API\V1\Repositories\Auth;

use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\NewAccessToken;

class AuthRepository extends BaseRepository
{
    use ApiResponse;

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function profile(): User
    {
        /** @var User $user */
        $user = auth()->user();

        return $user;
    }

    public function register($data): NewAccessToken
    {
        $user = User::create($data);
        if (isset($data['udid'])) {
            $udid = $data['udid'];
            $this->registerDevice($udid, $data['fcm_token'], $user);
        }

        return $user->createAuthToken();
    }

    /**
     * @throws ValidationException
     */
    public function login($data): array|NewAccessToken
    {
        $user = null;
        if ($data['email']) {
            $user = User::where('email', $data->get('email'))->first();
        }

        if (! Hash::check($data->get('password'), $user->password)) {
            throw ValidationException::withMessages([
                'password' => [__('The provided credentials are incorrect.')],
            ]);
        }
        $udid = $data->get('udid');
        if (! is_null($udid)) {
            $this->registerDevice($udid, $data->get('fcm_token'), $user);
        }

        return $user->createAuthToken();
    }

    public function registerDevice($udid = null, $fcm_token = null, $user = null): JsonResponse
    {
        if (is_null($user)) {
            $user = auth()->user();
        }

        $user->devices()->updateOrCreate(
            ['udid' => $udid],
            ['fcm_token' => $fcm_token]);

        return $this->responseMessage(__('Device is registered successfully'));
    }

    public function unregisterDevice($udid = null, $user = null): void
    {
        if (is_null($user)) {
            $user = auth()->user();
        }
        if (! is_null($udid)) {
            $user->devices()->where('udid', $udid)->delete();
        }
    }

    public function logout(User $user): bool
    {
        return $user->tokens()->delete() > 0;
    }

    public function generateUserOTP(User $user): string
    {
        $code = Str::uuid();
        $user->email_token = $code;
        $user->save();

        return $code;
    }

    public function verifyUserEmail(string $code): ?User
    {
        $user = User::whereEmailToken($code)->first();

        if ($user && ($user->hasVerifiedEmail() || $user->email_token === $code)) {
            $user->markEmailAsVerified();

            return $user;
        }

        return null;
    }

    protected function respondWithToken(NewAccessToken $token, $user = null): array
    {
        return [
            'token_type' => 'bearer',
            'access_token' => $token->plainTextToken,
            'access_expires_at' => $token->accessToken->expires_at,
            'user' => $user,
        ];
    }
}
