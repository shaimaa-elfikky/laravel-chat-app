@extends('layouts.app')

@section('content')


<div class="container mt-4">



      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModalCenter">
              اضافة  
      </button>

      <table class="table" dir="rtl">
        <thead>
          <tr>
            <td>مسلسل</td>
            <td>الصورة</td>
            <td>الاسم</td>
            <td>الحد الاقصى للجروب</td>
            <td>الاعضاء</td>
            <td></td>
          </tr>
        </thead>
          <tbody>
            @if(count($groups)>0)

            @php
            $i = 0;
            @endphp

            @foreach($groups as $group)

            <tr>
              <td>{{++$i}}</td>
              <td><img src="{{$group->image}}" alt="{{$group->image}}" width="100px" height="100px"></td>
              <td>{{$group->name}}</td>
              <td>{{$group->join_limit}}</td>
              <td>

                <a style="cursor: pointer" class="addMember" 
                    data-limit="{{$group->join_limit}}"
                    data-id="{{$group->id}}" data-toggle="modal" data-target="#memberModal">
                  الأعضاء
                </a>

              </td>
              <td></td>

              
            </tr>
           

            @endforeach

            @else
            <tr>
              <th colspan="6">No Data Found</th>
            </tr>
            @endif
          </tbody>

      </table>

     <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Create Group</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form enctype="multipart/form-data" id="creatGroupForm">
                  
                <div class="modal-body">
                   <input type="text" name="name" placeholder="inter group name" class="form-control w-100 mb-2" required/> 
                   <input type="file" name="image" class="form-control w-100 mb-2"/>
                   <input type="number" name="join_limit" min="1" placeholder="inter users limit" required  class="form-control w-100 mb-2"/>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">غلق</button>
                  <button type="submit" class="btn btn-primary">اضافة</button>
                </div>
            </form>
          </div>
        </div>
    </div>

    <!-- Members -->
    <div class="modal fade" id="memberModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">الأعضاء</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form  id="add-member-form">
                  
                <div class="modal-body">
                <input type="hidden" name ="group_id" id="add-group-id"/>
                <input type="hidden" name ="join_limit" id="add-limit"/>
                <table class="table" dir="rtl">
                    <thead>
                        <tr>
                            <th>اختر</th>
                            <th>الاسم</th>
                        </tr>
                    </thead>
                    <tbody class="addMembersInTable">
                       
                    </tbody>
                </table>
                              
                </div>
                <div class="modal-footer">
                  <span id="add-member-error"></span>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">غلق</button>
                  <button type="submit" class="btn btn-primary">اضافة</button>
                </div>
            </form>
          </div>
        </div>
    </div>


</div>





@endsection
