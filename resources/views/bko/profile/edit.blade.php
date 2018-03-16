@extends('layouts.bko')

@section('heading', "Mon compte")

@section('content')
    @include('bko.profile.forms._profile')
@endsection

@section('panel-content')
    <div class="panel panel-default">
        <div class="panel-heading">Modifier mon mot de passe</div>
        <div class="panel-body">
            @if($errors->errors_password->any())
                <div class="alert alert-danger">
                    @foreach($errors->errors_password->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            @if(Session::has('success_password'))
                <div class="alert alert-success">
                    {{ session('success_password') }}
                </div>
            @endif

            @include('bko.profile.forms._password')
        </div>
    </div>
@endsection