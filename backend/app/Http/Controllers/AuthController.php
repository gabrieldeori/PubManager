<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Helpers\Response_Handlers;
use App\Helpers\MSG;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->validated();
            $token = auth()->attempt($credentials);

            if (!$token) {
                throw new \Exception('Email ou senha inválidos');
            }

            $tokenType = 'Bearer';
            $token = [
                'access_token' => $token,
                'token_type' => $tokenType,
            ];

            $response = Response_Handlers::setAndRespond(MSG::LOGIN_SUCCESS, ['token' => $token]);
            return response()->json($response, MSG::OK);

        } catch (ValidationException $validator) {
            $errors = ['errors' => ['validation' => $validator->errors()]];
            $response = Response_Handlers::setAndRespond(MSG::LOGIN_INVALID_FORMAT, $errors);
            return response()->json($response, MSG::UNPROCESSABLE_ENTITY);

        } catch (\Exception $error) {
            $errors = ['errors' => ['generic' => $error->getMessage()]];
            $response = Response_Handlers::setAndRespond(MSG::LOGIN_FAIL, $errors);
            return response()->json($response, MSG::INTERNAL_SERVER_ERROR);
        }
    }

    public function authorizeToken() {
        $isValid = auth()->check();
        if ($isValid) {
            return response()->json([
                'message' => 'Authorized',
                'user' => auth()->user()
            ], 200);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function authorizeAdmin() {
        $isValid = auth()->check();
        if ($isValid) {
            $user = auth()->user();
            $usertype = $user->userType;
            if ($usertype == 'admin') {
                return response()->json(['message' => 'Authorized'], 200);
            }
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        // return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'userType' => auth()->user()->userType,
            'token_type' => 'bearer',
            // 'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
