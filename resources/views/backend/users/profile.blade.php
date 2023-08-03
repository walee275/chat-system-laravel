@extends('layouts.backend.main')

@section('title', 'Profile Page')
{{-- @include('partials.backend.logout') --}}
@section('admin-content')
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5"
                        width="150px"
                        src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span
                        class="font-weight-bold">{{ Auth::user()->name }}</span><span
                        class="text-black-50">{{ Auth::user()->email }}</span><span>
                    </span></div>
            </div>
            <div class="col ">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>
                    <form action="">
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label class="labels">Name</label><input type="text" class="form-control"
                                    placeholder="first name" value="{{ Auth::user()->name }}">
                            </div>
                            <div class="col-md-6">
                                <label class="labels">Surname</label><input type="text" class="form-control"
                                    value="" placeholder="surname">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="labels">Email ID</label>
                                <input type="email" class="form-control" placeholder="enter email id"
                                    value="{{ Auth::user()->email }}">
                            </div>
                            <div class="col-md-6">
                                <label class="labels">Mobile Number</label>
                                <input type="text" class="form-control" placeholder="enter phone number" value="">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6"><label class="labels">Country</label><input type="text"
                                    class="form-control" placeholder="country" value=""></div>
                            <div class="col-md-6">
                                <label class="labels">Postcode</label>
                                <input type="text" class="form-control" placeholder="enter address line 2"
                                    value="">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label class="labels">Address </label>
                                <textarea type="text" class="form-control" placeholder="enter address " value=""></textarea>
                            </div>
                        </div>
                        <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="submit">Save
                                Profile</button></div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
