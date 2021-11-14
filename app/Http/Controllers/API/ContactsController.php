<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Rootsoft\Algorand\Algorand;
use Rootsoft\Algorand\Clients\AlgodClient;
use Rootsoft\Algorand\Clients\IndexerClient;
use Rootsoft\Algorand\Clients\PureStake;
use Rootsoft\Algorand\Models\Accounts\Address;
use Rootsoft\Algorand\Models\Transactions\TransactionType;
use Rootsoft\Algorand\Traits\KeyPairGenerator;

class ContactsController extends Controller
{

    public function index(Request $request)
    {

        $this->validate($request, [
            'q' => 'string|nullable',
            'limit' => 'integer|nullable'
        ]);

        $term = $request->input('query');

        $response = $request->user()
                            ->contacts()
                            ->when(!empty($term), function($builder) use ($term){
                                $builder->where('name', 'LIKE', "%{$term}%")
                                        ->orWhere('lastname', 'LIKE', "%{$term}%")
                                        ->orWhere('email', 'LIKE', "%{$term}%")
                                        ->orWhere('phone', 'LIKE', "%{$term}%")
                                        ->orWhere('wallet_address', 'LIKE', "%{$term}%");
                            })
                            ->orderBy('name')
                            ->orderBy('lastname')
                            ->paginate(15);

        return ContactResource::collection($response);
    }

    public function show(Request $request, string $contactIdOrAddress)
    {

        $response = $request->user()
                            ->contacts()
                            ->where('id', $contactIdOrAddress)
                            ->orWhere(function($query) use ($contactIdOrAddress, $request){
                                $query->where('wallet_address', $contactIdOrAddress)
                                      ->where('user_id', $request->user()->id);
                            })
                            ->first();

        if(empty($response))
        {
            return response()->json([
                'status' => 'not_found',
                'message' => 'Contact not found',
            ], 404);
        }

        return new ContactResource($response);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string',
            'wallet_address' => 'required|string',
        ]);

        $limits = $request->user()->accountLimits();

        if(($limits['contacts_count']['current'] + 1) > $limits['contacts_count']['limit'])
        {
            return abort(422, 'Excede o limite de contatos.');
        }

        $contact = $request->user()->contacts()->create([
            'name' => $request->input('name'),
            'lastname' => $request->input('lastname'),
            'wallet_address' => $request->input('wallet_address'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ]);

        return new ContactResource($contact);
    }

}
