@extends('layouts.app')

@section('content')


        <div class="container mt-4">

        <div class="row">

            @if(count($users) > 0 )

                <div class="col-md-3">

                    <ul class="list-group">
                    @foreach($users as $user)

                        @php
                            if($user->image != '' && $user->image != null){
                                $image = $user->image  ;
                            }
                            else{
                                $image ='images/dummy.png' ;

                            }

                        @endphp
                        <li class="list-group-item list-group-item-dark cursor-pointer user-list" data-id={{ $user->id }}>
                            <img src="{{ $image }}" alt="" class="user-image">
                          {{$user->name}}
                          <b> <sup id="{{$user->id}}-status" class="offline-status">offline</sup> </b>
                        </li>
                    @endforeach

                    </ul>

                </div>

                <div class="col-md-9">
                    <h3 class="start-head">Click to chat</h3>

                    <div class="chat-section">

                        <div id="chat-container">
                           <div class="current-user-chat">
                              <h5></h5>
                           </div>
                            <div class="distance-user-chat">
                              <h5></h5>
                           </div>


                        </div>
                        <form action="" id="chat-form">
                            <input type="text"  name="message" placeholder="inter your message" id="message" class="border" required/>
                            <input type="submit" value="Send Message" class="btn btn-primary"/>
                        </form>

                    </div>

                </div>
            @else


                <div class="col-md-12">
                        <h6>Users Not Found!</h6>
                </div>

            @endif

        </div>


        </div>




  <!-- Modal -->
  <div class="modal fade" id="deleteChatModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete Chat </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" id="delete-chat-form">
            <div class="modal-body">
               <input type="hidden" name="id" id="delete-message-id" />
               <p> Are You Sure You Want TO Delete !</p>
               <p> <b id="delete-message"> </b></p>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Delete </button>
            </div>
        </form>
      </div>
    </div>
  </div>


    <!-- UPDATE Modal -->
    <div class="modal fade" id="updateChatModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Chat </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" id="update-chat-form">
            <div class="modal-body">
               <input type="hidden" name="id" id="update-message-id" />
               <input type="text" class="form-control" name="message" id ="update-message" required/>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Edit </button>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection
