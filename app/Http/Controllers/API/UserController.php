<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function update(Request $request)
    {
        $account = $request->user();

        $account->update($request->only([
            'read_first_algo_modal'
        ]));

        return new UserResource($account->fresh());
    }


    public function show(Request $request)
    {
        $account = $request->user();

        return new UserResource($account);
    }

    public function limits(Request $request)
    {
        $account = $request->user();

        return response()->json($account->accountLimits());
    }


    public function destroy(Request $request)
    {

        $this->validate($request, [
            'password' => 'required',
        ]);

        $user = $request->user();

        if($user && $request->input('password') === Hash::check($request->input('password'), $user->password))
        {
            $request->user()->delete();

            return response(null, 204);
        }

        return response()->json([
            'message' => 'Erro de autenticação.'
        ], 422);
    }

}
