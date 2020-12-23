@extends('layouts.app')

@section('content')
<div id="app" class="container">
    <chat-content :user="{{ $user }}" :others="{{ $others }}"
     pusher-key="{{ config('broadcasting.connections.pusher.key') }}"
     pusher-cluster="{{ config('broadcasting.connections.pusher.options.cluster') }}">
    </chat-content>
</div>

@include('layouts.script')


@endsection
