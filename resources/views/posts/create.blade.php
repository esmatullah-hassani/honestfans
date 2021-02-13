@extends('layouts.app')

@section('content')
<div class="container row">
<div class="col-md-4"></div>
<div class="col-md-6">  
    <div class="card has-background-dark h100" style="margin-left: 10px;">
        <div id="app">
            <upload-video></upload-video>
        </div>
    </div>
</div>
<div class="col-md-2"></div>
</div>
<script src="{{mix('js/app.js')}}"></script>

<script>

    window.csrfToken = "{{csrf_token()}}";

</script>
@endsection
