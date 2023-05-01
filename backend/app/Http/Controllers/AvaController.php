<?php

namespace App\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\Error_Handlers;
use App\Helpers\Response_Handlers;
use App\Helpers\MSG;

class AvaController extends Controller
{
    public function getUsers(Request $request)
    {
        try {
            $users = User::all()->toArray();
            if (count($users) == 0) {
                throw new Exception(MSG::USERS_NOT_FOUND);
            } else {
                $users = Response_Handlers::setAndRespond(MSG::USERS_FOUND, $users);
            }
            return response()->json($users);
        } catch (\Exception $e) {
            $error = $e->getMessage();
            Error_Handlers::logError(MSG::SERVER_ERROR, $error);
            $response = Response_Handlers::setAndRespond(MSG::SERVER_ERROR, ['error'=>$error]);
            return response()->json($error, 500);
        }
    }

    public function getAUser(Request $request)
    {
        try {
            $id = $request->all()['id'];
            $user = User::find($id);
            if ($user == null) {
                $response = Response_Handlers::setAndRespond(MSG::CLIENT_NOT_FOUND);
                return response()->json($response, MSG::NOT_FOUND);
            }
            $response = Response_Handlers::setAndRespond(MSG::USERS_FOUND, ['user' => $user]);
            return response()->json($response);
        } catch (\Exception $e) {
            $error = $e->getMessage();
            Error_Handlers::logError(MSG::SERVER_ERROR, $error);
            $response = Response_Handlers::setAndRespond(MSG::SERVER_ERROR, ['error'=>$error]);
            return response()->json($response, MSG::NOT_FOUND);
        }
    }

    public function createUser(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|min:3|max:255|regex:/^[a-zA-ZÀ-ÿ\s]+$/',
                'nickname' => 'required|min:3|max:45|regex:/^[a-zA-Z]+$/',
                'email' => 'required|email',
                'password' => 'nullable|min:6|max:255',
                'userType' => 'required|in:Nenhum,Admin',
            ], MSG::USER_VALIDATE);

            $toCreate = $request->all();

            if (!$validated) {
                $response = Response_Handlers::setAndRespond(MSG::INVALID_DATA);
                return response()->json($response, MSG::NOT_FOUND);
            }

            User::create([
                'name' => $toCreate['name'],
                'nickname' => $toCreate['nickname'],
                'email' => $toCreate['email'],
                'password' => $toCreate['password'],
                'userType' => $toCreate['userType'],
            ]);

            return Response_Handlers::setAndRespond(MSG::USER_CREATED);
        } catch (\Exception $e) {
            $error = $e->getMessage();
            Error_Handlers::logError(MSG::SERVER_ERROR, $error);
            $response = Response_Handlers::setAndRespond(MSG::SERVER_ERROR, ['error'=>$error]);
            return response()->json($response, MSG::INTERNAL_SERVER_ERROR);
        }
    }

    public function editAUser(Request $request)
    {
        try {
            $toUpdate = $request->all();
            $user = User::find($toUpdate['id']);

            if ($user == null) {
                $response = Response_Handlers::setAndRespond(MSG::CLIENT_NOT_FOUND);
                return response()->json($response, MSG::NOT_FOUND);
            }

            $validated = $request->validate([
                'name' => 'required|min:3|max:255|regex:/^[a-zA-ZÀ-ÿ\s]+$/',
                'nickname' => 'required|min:3|max:45|regex:/^[a-zA-Z]+$/',
                'email' => 'required|email',
                'password' => 'nullable|min:6|max:255',
                'userType' => 'required|in:Nenhum,Admin',
                'password_old' => 'required|min:6|max:255',
            ], MSG::USER_VALIDATE);

            if (!$validated) {
                $response = Response_Handlers::setAndRespond(MSG::INVALID_DATA);
                return response()->json($response, MSG::NOT_FOUND);
            }

            if (!password_verify($toUpdate['password_old'], $user['password']) && $toUpdate['password_old'] != $user['password']) {
                $response = Response_Handlers::setAndRespond(MSG::PASSWORD_NOT_MATCH);
                return response()->json($response, MSG::NOT_FOUND);
            }

            $user->name = $toUpdate['name'];
            $user->nickname = $toUpdate['nickname'];
            $user->email = $toUpdate['email'];
            $user->userType = $toUpdate['userType'];

            if($toUpdate['password'] != '' || $toUpdate['password'] != null){
                $toUpdate['password'] = bcrypt($toUpdate['password']);
                $user->password = $toUpdate['password'];
            }

            $user->save();

            $response = Response_Handlers::setAndRespond(MSG::CLIENT_UPDATED);
            return response()->json($response, MSG::ACCEPTED);

        } catch (\Exception $e) {
            $error = $e->getMessage();
            Error_Handlers::logError(MSG::SERVER_ERROR, $error);
            $response = Response_Handlers::setAndRespond(MSG::SERVER_ERROR, ['error'=>$error]);
            return response()->json($response, MSG::INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteAUser(Request $request)
    {
        try {
            $user = User::find($request->id);
            if ($user == null) {
                $response = Response_Handlers::setAndRespond(MSG::CLIENT_NOT_FOUND);
                return response()->json($response, MSG::NOT_FOUND);
            }
            $user->delete();
            $response = Response_Handlers::setAndRespond(MSG::USER_DELETED);
            return response()->json($response, MSG::ACCEPTED);
        } catch (\Exception $e) {
            $error = $e->getMessage();
            Error_Handlers::logError(MSG::SERVER_ERROR, $error);
            $response = Response_Handlers::setAndRespond(MSG::SERVER_ERROR, ['error'=>$error]);
            return response()->json($response, MSG::INTERNAL_SERVER_ERROR);
        }
    }
}
