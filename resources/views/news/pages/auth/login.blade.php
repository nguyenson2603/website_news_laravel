@extends('news.login');
@section('content')
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-md-center h-100">
                <div class="card-wrapper">
                    {{-- <div class="brand">
                        <img src="{{ asset('auth/img/logo.png') }}">
                    </div> --}}
                    <div style="height: 100px"></div>
                    <div class="card fat">
                        <div class="card-body">
                            <h4 class="card-title">Login</h4>
                            {{-- <form method="POST">

                                <div class="form-group">
                                    <label for="email">E-Mail Address</label>

                                    <input id="email" type="email" class="form-control" name="email" value=""
                                        required autofocus>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password
                                        <a href="forgot.html" class="float-right">
                                            Forgot Password?
                                        </a>
                                    </label>
                                    <input id="password" type="password" class="form-control" name="password" required
                                        data-eye>
                                </div>

                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>

                                <div class="form-group no-margin">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Login
                                    </button>
                                </div>
                                <div class="margin-top20 text-center">
                                    Don't have an account? <a href="register.html">Create One</a>
                                </div>
                            </form> --}}
                            @include('news.templates.error')
                            @include('news.templates.notify')
                            {!! Form::open([
                                'method' => 'POST',
                                'url' => route("{$controllerName}/postLogin"),
                                'id' => 'auth-form',
                            ]) !!}
                            <div class="form-group">
                                {!! Form::label('username', 'Username') !!}
                                {!! Form::text('username', null, ['id' => "username", 'class' => "form-control", 'name' => "username",
                                'required' => true, 'autofocus' => true]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('password', 'Password') !!}
                                {!! Form::password('password', ['id' => "password", 'class' => "form-control", 'name' => "password",
                                'required' => true, 'data-eye' => true]) !!}
                            </div>
                            <div class="form-group no-margin">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Login
                                </button>
                            </div>
                            <div class="margin-top20 text-center">
                                Don't have an account? <a href="register.html">Create One</a>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="footer">
                        Copyright &copy; Your Company 2022
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
