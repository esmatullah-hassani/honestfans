@extends('layouts.app')

@section('content')
<div class="container row">
    <div class="col-md-4"></div>
    <div class="col-md-6">
        <div class="card has-background-dark h100 ml-25" style="margin-left: 10px;">
            <div class="card-body is-transparent">
                <h1 class="is-size-2 is-size-4-touch ">{{ __('Reset Password') }}</h1>
                @if($errors->any())
                <div class="notification is-warning">
                    <button class="delete"></button>
                    <p>{{ $errors->first() }}</p>
                </div>
                @endif
                <form method="POST" action="{{ route('password.email') }}">

                    <!-- CSRF Token -->
                    @csrf

                    <!-- Email Input -->
                    <div class="field">
                        <label class="label ">{{ __('E-Mail Address') }}</label>
                        <div class="control">
                            <input class="input" type="email" name="email" value="{{ old('email') }}"
                                required autofocus placeholder="E-mail address">
                        </div>
                    </div>

                    <!-- Submit button -->
                    <div class="field">
                        <div class="control">
                            <button type="submit" class="button is-primary is-fullwidth is-large">
                                {{ __('Send Email') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>

@endsection
