@extends('layouts.app')

@section('content')
<div class="container row">
    <div class="col-md-3"></div>
    <div class="col-md-9">
        <table class="table table-hover table-striped table-bordered">
            <thead>
                <th>No</th>
                <th>Name</th>
                <th>Display Name</th>
                <th>Email</th>
                <th>Coin</th>
                <th>Add Coin</th>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->display_name}}</td>
                    <td>{{$user->email}}</td>
                    <td>@if(!$user->coin->isEmpty()) {{$user->coin[0]->amount}} @else 0 @endif</td>
                    <td>
                        <a class="text-success" onclick="addCoin({{$user->id}});"><i class="fas fa-plus"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
            
        </table>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4"><center>{{ $users->links() }}</center></div>
            <div class="col-md-4"></div>
        </div>
        <div id="set-payment" class="uk-flex-top " uk-modal>
          <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical uk-width-large ">
              
            <div  style="text-align: center; border-bottom: 1px solid #ddd; padding-bottom: 20px;padding-top: 20px;">
                Do you want to add some coin,Pleae submit
            </div>
            <form action="{{url('/settings')}}" method="POST">
            @csrf
            <input type="hidden" name="user_id" id="user_id">
                <a >
                    <div class="bye-button"   style="text-align: center; border-bottom: 1px solid #ddd; padding-bottom: 10px;padding-top: 10px;">
                        Amount
                        <input type="number" name="amount" class="form-control" autocomplete="off" placeholder="Amount :">    
                    </div>
                </a>
                <div class="bye-button"   style="text-align: center; border-bottom: 1px solid #ddd; padding-bottom: 10px;padding-top: 10px;">
                    <button type="submit" class="btn btn-success form-control mp">Add Coin</button>
                </div>
            </form>
              
            <a>
              <div class="uk-modal-close" style="text-align: center; padding-top: 20px;">
                  Cancel
              </div>
            </a>
              
        </div>
    </div>
</div>
<script>
function addCoin(id){
    $("#user_id").val(id);
    var modal = UIkit.modal("#set-payment");
    modal.show();
}
</script>

@endsection
