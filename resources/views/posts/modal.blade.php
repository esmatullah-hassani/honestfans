<div id="modal-overflow" uk-modal>
        <div class="uk-modal-dialog ">

            <button class="uk-modal-close-default" type="button" uk-close></button>

            <div class="uk-modal-header">
                <h2 class="uk-modal-title">All suggestion for you</h2>
            </div>

            <div class="uk-modal-body " uk-overflow-auto>
            @foreach(Helper::getUser()['users'] as $user)
                        <div class="row" style="display: inline-block; margin-top: 10px; width: 100%;">
                            <div class="col-md-4">
                                <a  href="/user/{{$user->id}}" tabindex="0" style="width: 56px; height: 56px;">
                                @if($user->social_path != "")
                                <img alt="profile picture" class="circle-user-image-32" data-testid="user-avatar" draggable="false" src="{{ $user->social_path}}">
                                @else
                                    <img alt="profile picture" class="circle-user-image-32" data-testid="user-avatar" draggable="false" src="{{ asset('images/avatar/'.$user->image)}}">
                                @endif
                                </a>
                            </div>
                            <div  class="col-md-8">
                                <div class="row">
                                    <div class="col-md-8">
                                        <a href="/user/{{$user->id}}" class="margin-left-10 color-dark" >
                                        @if($user->display_name == ""){{$user->name}}
                                        @else
                                        {{$user->display_name}}
                                        @endif
                                        </a><br>
                                
                                        <span class="margin-left-10" style="font-size: 15px;">{{Helper::getUser()['status']}}</span>
                                    </div>
                                    <div class="col-md-2" >
                                    <form method="POST" action="{{ route('account.follow', $user->id) }}" class="w100">
                                        @csrf
                                        <input type="submit" class="btn btn-link mp color-dark" value="{{ __('Follow') }}" style="margin-left: 0;">
                                    </form>
                                    </div>
                                </div>
                            </div>
                                
                            
                        </div>
                        @endforeach
                
            </div>


        </div>
    </div>

<!-- 
    Start  Payment modal
    -->
<div id="modal-payment" class="uk-flex-top " uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical uk-width-large ">
        <form action="">
            <div  style="text-align: center; border-bottom: 1px solid #ddd; padding-bottom: 20px; color: blue;">
                Paypal payment,Click accept button  
            </div>
            <div class="uk-modal-close"  style="text-align: center; border-bottom: 1px solid #ddd; padding-bottom: 20px;padding-top: 20px;">
                10$ Will cat from your paypal account
            </div>
            <div   style="text-align: center; border-bottom: 1px solid #ddd; padding-bottom: 20px;padding-top: 20px;">
                <button class="btn btn-success form-control">Accept</button>
            </div>
        </form>
       
        <a>
            <div class="uk-modal-close" style="text-align: center; padding-top: 20px;">
                Cancel
            </div>
        </a>
        
    </div>
</div>
<!-- End Payment modal -->

