
@extends('layouts.template.base')

@section('content')
<div class="container-fluid">
    <div class="fade-in">
        <div class="card">
            <div class="card-body">
                <br><br><br>
                <h2 class="text-center"> Alert!</h2>
                <br>
                @if(Auth::user()->registerComplete && (!Auth::user()->isApproved))
                <h2 class="text-center"> Your account still pending from admin approval.</h2>
                @elseif ((!Auth::user()->registerComplete) && (!Auth::user()->isApproved))
                <h2 class="text-center"> Your account need to be completed for futher action.</h2>
                @else
                <h2 class="text-center"> Your account was rejected by admin. Please update your profile for futher action.</h2>
                @endif

                <br>
                <p class="text-center">
                    You can update your profile.
                    <div class="mb-3 text-center">
                        <a class="font-weight-bold btn btn-success rounded p-3" href="{{url('/user-profile')}}">User Profile</a>
                    </div>
                </p>
                <br><br><br>
            </div>
        </div>
    </div>
</div>
@endsection

