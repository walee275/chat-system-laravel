@extends('auth.auth_master')


@section('auth-content')
    <!-- login area start -->
    <div class="login-area">
        <div class="container">
            <div class="login-box ptb--100">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="login-form-head">
                        <h4>Sign Up</h4>
                        <p>Hello there, Sign up and start managing your Admin Panel</p>
                    </div>
                    <div class="login-form-body">
                        @include('partials.backend.messages')
                        <div class="row">
                            <div class="col">
                                <div class="form-gp">
                                    <label for="name">name</label>
                                    <input type="text" id="name" name="name">
                                    <i class="ti-name"></i>
                                    <div class="text-danger"></div>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-gp">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="text" id="exampleInputEmail1" name="email">
                                    <i class="ti-email"></i>
                                    <div class="text-danger"></div>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-gp mb-4">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" id="exampleInputPassword1" name="password">
                            <i class="ti-lock"></i>
                            <div class="text-danger"></div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="submit-btn-area">
                            <button id="form_submit" type="submit">Sign In <i class="ti-arrow-right"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- login area end -->
@endsection
