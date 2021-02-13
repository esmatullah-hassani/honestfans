@extends('layouts.app')

@section('content')
<div id="app" class="container">
    <life-video :allusers="{{ $users }}" :authUser="{{ auth()->user() }}" turn_url="{{ env('TURN_SERVER_URL') }}"
        >
    </life-video>
</div>

@include('layouts.script')
<script src="{{mix('js/app.js')}}"></script>

<script>

    window.csrfToken = "{{csrf_token()}}";

</script>

@endsection
