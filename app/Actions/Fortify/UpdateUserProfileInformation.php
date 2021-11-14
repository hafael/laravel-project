<?php

namespace App\Actions\Fortify;

use App\Rules\IsPhone;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['sometimes', 'string', 'nullable', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'phone' => ['numeric', 'nullable', new IsPhone ],
            'current_network' => ['in:MainNet,TestNet', 'nullable'],
            'birthdate' => ['date', 'nullable'],
            'language' => [ 'in:pt_BR', 'sometimes'],
            'currency' => ['in:BRL', 'sometimes'],
            'country' => ['in:BRA', 'sometimes'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $data = array_filter([
                'name' => $input['name'],
                'email' => $input['email'],
                'lastname' => $input['lastname'],
                'phone' => $input['phone'],
                'current_network' => $input['current_network'],
                'currency' => $input['currency'],
                'language' => $input['language'],
                'country' => $input['country'],
                'birthdate' => $input['birthdate'],
            ]);

            $user->forceFill($data)->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
