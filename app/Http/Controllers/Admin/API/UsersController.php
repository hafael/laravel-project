<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvitationResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\WalletResource;
use App\Mail\SendInvitationMail;
use App\Models\Invitation;
use App\Models\User;
use App\Rules\IsPhone;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    
    public function update(Request $request, User $user)
    {

        $this->validate($request, [
            'name' => 'string|nullable',
            'lastname' => 'string|nullable',
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id, 'id')],
            'phone' => ['numeric', 'nullable', new IsPhone ],
            'current_network' => 'nullable|enum:MainNet,TestNet',
            'birthdate' => 'nullable|date',
        ]);

        $data = array_diff($request->all(), Arr::except($user->toArray(), ['created_at', 'updated_at']));

        $user->fill($data);

        if(!empty($data['email']))
        {
            $user->forceFill(['email_verified_at' => null]);
            $user->sendEmailVerificationNotification();
        }

        $user->save();

        return new UserResource($user->fresh());
    }
    
}
