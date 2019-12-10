<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Info;

class InfoController extends Controller
{
    public function Index()
    {  
    	$information=Info::all();
    	return view('admin.index',compact('information'));
    } 

     public function Create()
    {
    	return view('admin.create');
    }
    public function Store(Request $request)
        {
       $data = new Info;
       $data->name = $request->name; 
       $data->home = $request->home; 
    
       $data->save();
       if ($data->save()) {
      $notification=array(
                'messege'=>'Post Added Successfully',
                'alert-type'=>'success'
                 );
               //return Redirect()->route('all.employee')->with($notification);
       	return back()->with($notification);
       }else{
       	return back();
       }
    }

    public function Edit($id)
    {
    	
    	$old=Info::findOrfail($id);
    	return view('admin.edit',compact('old'));
    }

    public function Update(Request $request)
    {
    	$info=Info::find($request->info_update);
    	 $info->name = $request->name; 
    	 $info->home = $request->home; 
    	 $info->save();

 if ($info->save()) {
      $notification=array(
                'messege'=>'Post Updated Successfully',
                'alert-type'=>'success'
                 );
               //return Redirect()->route('all.employee')->with($notification);
       	return back()->with($notification);
       }else{
       	return back();
       }
    }

    public function Delete($id)
    {
      $info=Info::find($id)->delete();
       if ($info) {
      $notification=array(
                'messege'=>' Post Delete Successfully',
                'alert-type'=>'success'
                 );
               //return Redirect()->route('all.employee')->with($notification);
        return back()->with($notification);
       }else{
        return back();
       }
  
}
}
//--------------------------------------
Route::get('create', 'InfoController@Create');
Route::post('store', 'InfoController@Store');
Route::get('index', 'InfoController@Index');
Route::get('edit/{id}', 'InfoController@Edit');
Route::post('update', 'InfoController@Update');
Route::get('delete/{id}', 'InfoController@Delete');
-----------------------------------------------
//create-----------------
@extends('layouts.app')

@section('content')
 <a href="{{ url('index')}}">back</a>
<div class="container">
	<form action="{{ url('store')}}" method="post">
	@csrf
	<input type="tex" name="name"placeholder="Enter Your Home">
	<input type="tex" name="home" placeholder="Enter Your Home">
	<button class="submit">Submit</button>
</form>
</div>

@endsection
//index-----------------
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
           <table class="table table-dark">
    <a href="{{ url('create')}}">create</a>
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Home</th>
                  
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                       @foreach ($information as $info)
                      <tr>
                           <td>  {{ $loop-> index +1 }} </td>
                           <td>  {{ $info->name }} </td>
                           <td>  {{ $info->home }} </td>
                       
                           <td>
                           
                             <a class="btn btn-success" href="{{ url('edit') }}/{{ $info->id }}">Edit</a>
                          <!--    <a class="btn btn-danger delete_id" id="delete_id" href="{{ url('delete') }}/{{ $info->id }}">Delete</a> -->
                             
                             <button class="btn btn-danger delete_link" type="button" value="{{ url('delete') }}/{{ $info->id }}">Delete</button>
                           </td>
                          </tr>
                        @endforeach
       </table>


                    </div>
                  </div>
                </div>
                </div>
 

@endsection


       @section('footer')

      <script>  
        $( document ).ready(function() {

   $('.delete_link').click(function(){
    var redirect_link= $(this).val();
Swal.fire({
  title: 'Are you sure?',
  text: "You want to Delete!",
  icon: 'question',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes!'
}).then((result) => {
  if (result.value) {
  window.location.href=redirect_link;
  }
})


   });
    });
    </script>
       @endsection
//edit
@extends('layouts.app')

@section('content')

<div class="container">
	<form action="{{ url('update')}}" method="post">
	@csrf
	<input type="tex" name="name"placeholder="Enter Your Home" value="{{ $old->name }}">
	<input type="tex" name="home" placeholder="Enter Your Home" value="{{ $old->home }}">
	<input type="hidden" name="info_update" value="{{ $old->id }}">
	<button class="submit">Update</button>
</form>
</div>
@endsection
//need app
<!-- toster message  -->
      <script>
      @if(Session::has('messege'))
        var type="{{Session::get('alert-type','info')}}"
        switch(type){
            case 'info':
                 toastr.info("{{ Session::get('messege') }}");
                 break;
            case 'success':
                toastr.success("{{ Session::get('messege') }}");
                break;
            case 'warning':
                toastr.warning("{{ Session::get('messege') }}");
                break;
            case 'error':
                toastr.error("{{ Session::get('messege') }}");
                break;
        }
      @endif
    </script>
	
	// 3file js add
	
<!-- Script toaster -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/toaster.min.js') }}"></script>
<!-- Script toaster end  -->
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
// 3file css add
 <!-- Styles toaster-->
    <link href="{{ asset('css/toaster.css') }}" rel="stylesheet">