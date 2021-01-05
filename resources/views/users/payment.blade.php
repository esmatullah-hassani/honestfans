@extends('layouts.app')

@section('content')

<div id="app" class="container">
    <pay-pal-payment :user_id='{{auth()->id()}}'></pay-pal-payment>
</div>

@include('layouts.script')
<script src="{{mix('js/app.js')}}"></script>

<script>

    window.csrfToken = "{{csrf_token()}}";

</script>
@endsection
