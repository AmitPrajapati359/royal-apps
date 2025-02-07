@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                @if(isset($authUserDetail))

                    <div class="card-body">
                    Welcome,  <b> {{ $authUserDetail['first_name']  ??  '' }}  {{ $authUserDetail['last_name']  ??  '' }} </b> <br/>
                    {{ $authUserDetail['email']  ??  '' }}
                    </div>

                    <div class="card-body">
                        <a href="{{ route('logout') }}" class="btn btn-info"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>

                @else
                    <div class="card-body">
                        <a href="{{ route('login') }}" class="btn btn-info">Login</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
