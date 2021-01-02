@extends("layouts.app")
@section("content")
<form action="{{route('payments-purchase')}}" method="POST" id="payment-form">
    {{csrf_field()}}
    <input type="hidden" name="items" value="12">
    <input type="hidden" name="total" value="12">
    <button class="btn btn-primary btn-lg btn-block mt15">Purchase</button>
</form>
@endsection