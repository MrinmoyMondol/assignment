@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Contact LIst') }}

                    <button type="button" class="btn btn-primary mb-3 float-end" data-bs-toggle="modal" data-bs-target="#addContactModal">
                        Add Contact
                    </button>

                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif




                        <table id="contactTable" class="table table-striped" style="width:100%">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                           
                            </thead>
                            <tbody>
                            @foreach ($contacts as $contact)
                                <tr>
                                    <td>{{ $contact->name }}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ $contact->phone }}</td>
                                    <td>{{ $contact->address }}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm show-contact" data-id="{{ $contact->id }}">Show</button>
                                        <button class="btn btn-warning btn-sm edit-contact" data-id="{{ $contact->id }}">Edit</button>
                                        <button class="btn btn-danger btn-sm delete-contact" data-id="{{ $contact->id }}">Delete</button>
                                    </td>
                                </tr>
                            @endforeach


                        </table>


                </div>
            </div>
        </div>
    </div>
</div>

<!--Contacts Modals -->
@include('contacts.add')
@include('contacts.edit')
@include('contacts.show')





@endsection
