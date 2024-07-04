<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{



    //New Contact Save Function
// app/Http/Controllers/ContactController.php
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:contacts',
                'phone' => 'required',
                'address'=>'required',
            ]);

            Contact::create($request->all());

            return response()->json(['success' => 'Contact added successfully.']);
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error creating contact: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    //Contact Details Function
    public function show($id)
    {
        $contact = Contact::find($id);
        return response()->json($contact);
    }

    //Contact Edit Form
    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }

    //Contact Update Function
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:contacts,email,' . $id,
            'phone' => 'required',
            'address'=>'required'
        ]);

        $contact = Contact::find($id);
        $contact->update($request->all());

        return response()->json(['success' => 'Contact updated successfully.']);
    }

    //Contact Delete Function
    public function destroy($id)
    {
        try {
            Contact::find($id)->delete();
            return response()->json(['success' => 'Contact deleted successfully.']);
        } catch (\Exception $e) {
            \Log::error('Error deleting contact: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

}
