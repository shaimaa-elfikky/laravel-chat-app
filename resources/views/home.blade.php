@extends('layouts.app')

@section('content')


        <div class="container mt-4">

        <div class="row">

            @if(count($users) > 0 )

                <div class="col-md-3">

                    <ul class="list-group">
                        @foreach($users as $user)
                        <li class="list-group-item list-group-item-dark cursor-pointer user-list" data-id={{ $user->id }}>
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
@endsection
