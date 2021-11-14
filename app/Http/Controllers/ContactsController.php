<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;

class ContactsController extends Controller
{

    
    public function index(Request $request)
    {
        return Inertia::render('Contacts', [
            'contacts' => $request->user()->contacts()->get()->all(),
            'create_url' => URL::route('contacts.store'),
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render('Contacts/Create');
    }

    public function store(Request $request)
    {


        $this->validate($request, [
            'name' => 'required|string',
            'address' => 'required|string',
        ]);

        $request->user()->contacts()->create([
            'name' => $request->input('name'),
            'wallet_address' => $request->input('address'),
        ]);

        return redirect()->back();
    }

    public function show(Request $request, Contact $contact)
    {
        return Inertia::render('Contacts/Show', [
            'contact' => $contact,
        ]);
    }


}
