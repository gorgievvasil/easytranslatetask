@extends('layouts.master')

@section('content')

    <h1 class="mt-5">User {{ ucfirst($action) }}</h1>
    @if (is_object($response))
        
    @if ($response->status == 1)
    <div class="alert alert-success mt-4" role="alert">
        <h3 class="mb-3">Your registration is successful!</h3>            
        <h5>Your token: <b><u>{{ $response->token }}</u></b></h5>            
        <span>Save your token on safe place. You need this token to be able to use this conversion service</span>                
    </div>
    <a class="btn btn-primary mt-5" href="/">Go to the conversion service page</a>';
    @elseif ($response->status == 0)
    <div class="alert alert-danger" role="alert">
        <h4 class="mb-3">Registration failed!</h4>
        <b>Errors:</b><br/>
        @foreach ($response->errors as $key => $value)
            @foreach ($value as $k => $v)
                <span>{{ $v }}</span><br/>
            @endforeach
        @endforeach            
    </div>
    @endif
    
    @endif
    <div class="row text-center col-md-6 col-sm-12 m-auto mt-4 content-container">       
    @if ($action == 'register')
        <h3 class="fw-normal mt-5 user-action-heading">Register and get API token</h3>
        <form method="post" action="/userProcessRequest" class="col-md-8 col-sm-12 m-auto mt-5">
            @csrf
            <input type="hidden" name="actionType" value="register" />            
            <div class="row text-left mt-3">
                <label for="name" class="form-label col-4 text-start">Name</label>                    
                <div class="col-8">
                    <input type="text" class="form-control inline-element col-8 name" id="name" name="name" placeholder="John Doe" />                                    
                </div>                    
            </div>
            <div class="row text-left mt-3">
                <label for="email" class="form-label col-4 text-start">E-mail</label>                    
                <div class="col-8">
                    <input type="text" class="form-control inline-element col-8 email" id="email" name="email" placeholder="jd@google.com" />                                    
                </div>                    
            </div>
            <div class="row text-left mt-3">
                <label for="password" class="form-label col-4 text-start">Password</label>                    
                <div class="col-8">
                    <input type="password" class="form-control inline-element col-8 password" id="password" name="password" placeholder="*********" />                                    
                </div>                    
            </div>
            <div class="row text-left mt-3">
                <label for="confirm-password" class="form-label col-4 text-start">Confirm Password</label>                    
                <div class="col-8">
                    <input type="password" class="form-control inline-element col-8 confirm-password" id="confirm-password" name="confirm_password" placeholder="*********" />                                    
                </div>                    
            </div>
            <div class="row mt-3">
                <button type="submit" class="btn btn-primary get-token col-md-4 col-sm-10 m-auto">Get Token</button>
            </div>    
        </form>
    @elseif ($action == 'login')
        <h3 class="fw-normal mt-5 user-action-heading">Enter your login credentials and get API token</h3>
        <form method="post" action="/userProcessRequest" class="col-md-8 col-sm-12 m-auto mt-5">
            @csrf
            <input type="hidden" name="actionType" value="login" />                        
            <div class="row text-left mt-3">
                <label for="email" class="form-label col-4 text-start">E-mail</label>                    
                <div class="col-8">
                    <input type="text" class="form-control inline-element col-8 email" id="email" name="email" placeholder="jd@google.com" />                                    
                </div>                    
            </div>
            <div class="row text-left mt-3">
                <label for="password" class="form-label col-4 text-start">Password</label>                    
                <div class="col-8">
                    <input type="password" class="form-control inline-element col-8 password" id="password" name="password" placeholder="*********" />                                    
                </div>                    
            </div>            
            <div class="row mt-3">
                <button type="submit" class="btn btn-primary get-token col-md-4 col-sm-10 m-auto">Get Token</button>
            </div>    
        </form>
    @endif
    </div>

@endsection