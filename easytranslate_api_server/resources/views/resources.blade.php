@extends('layouts.master')

@section('content')

    <h1 class="mt-5">Easy Currency Conversion</h1>
    <p class="mt-5 text-center">
        To use this convertor your token is required.<br/>If you don't have token yet, please <a href="/user/register">register</a> or <a href="/user/login">sign in</a> to get your token.
    </p>
    <div class="row text-center col-md-6 col-sm-12 m-auto mt-4 content-container">       
        <form method="post" action="/convert">     
            @csrf
            <div class="row mt-5">
                <div class="col-6">
                    <label for="currency-from" class="form-label">From</label>
                    <select id="currency-from" class="form-select" name="currency_from">
                        <option value="select_currency" selected>Select currency</option>
                        @foreach ($currencies as $currency => $name)
                            <option value="{{ $currency }}">{{ $currency }} - {{ $name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label for="currency-to" class="form-label">To</label>
                    <select id="currency-to" class="form-select" name="currency_to">
                        <option value="select_currency" selected>Select currency</option>
                        @foreach ($currencies as $currency => $name)
                            <option value="{{ $currency }}">{{ $currency }} - {{ $name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row text-center mt-4">
                <div>
                    <label for="amount-to-convert" class="form-label inline-label" style="width: 200px; display:inline-block;">Amount to convert</label>
                    <div style="width: 200px; display:inline-block;">
                        <div class="input-group">
                            <span class="input-group-text"></span>
                            <input type="text" class="form-control" id="amount-to-convert" name="amount_to_convert" placeholder="100" />
                        </div>                        
                    </div>
                </div>
            </div>
            <div class="row text-center mt-4">
                <div>
                    <label for="token" class="form-label inline-label" style="width: 200px; display:inline-block;">Token</label>
                    <div class="col-6" style="display:inline-block;">
                        <div class="input-group">                            
                          <input type="text" class="form-control inline-element col-8 token" id="token" name="token" placeholder="Enter here your API token" />   
                        </div>                        
                    </div>
                </div>
            </div>            
            <div class="col-12 mt-3 text-center">
                <span class="get-rate text-md-center">Get rate</span><br/>
                <span class="rate text-md-center"></span>
            </div>
            <div class="col-12 mt-2 text-center">                    
                <button type="submit" class="btn btn-primary" id="submit-btn" placeholder="100" name="convert" value="convert">Convert</button>
            </div>
        </form>
        <div class="converted-result">
        </div>
    </div>
@endsection