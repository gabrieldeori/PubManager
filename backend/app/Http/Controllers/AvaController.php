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
            $toCreate = $request->all();
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
            $user->name = $toUpdate['name'];
            $user->nickname = $toUpdate['nickname'];
            $user->email = $toUpdate['email'];
            $user->password = 'apenas teste';
            $user->userType = $toUpdate['userType'];
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
