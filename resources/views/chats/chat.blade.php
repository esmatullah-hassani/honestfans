@extends('layouts.app')

@section('content')
<div id="app" class="container">
    <chat-content :allusers="{{ $users }}" :authUser="{{ auth()->user() }}" turn_url="{{ env('TURN_SERVER_URL') }}"
        turn_username="{{ env('TURN_SERVER_USERNAME') }}" turn_credential="{{ env('TURN_SERVER_CREDENTIAL') }}">
    </chat-content>
</div>

@include('layouts.script')
<script src="{{mix('js/app.js')}}"></script>

<script>

    window.csrfToken = "{{csrf_token()}}";

</script>

@endsection
