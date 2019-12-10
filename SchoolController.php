<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\School;

class SchoolController extends Controller
{
    public function index()
    {
    	$school= School::all();
    	return view('school.index',compact('school'));
    } 

    public function create()
    {
    	return view('school.create');
    }

    public function store(Request $request)
    {
    	$request->validate([
        
        'school_name' => 'required',
        'subject' => 'required',
    ]);
    	$data= new School();
    	$data->school_name=$request->school_name;
    	$data->subject=$request->subject;
    	$data->save();
    	return back();

    	//return $request->all();
    }
   public function schooldelete($school_id)
   {
   //School::find($school_id)->delete();
   School::where('id',"=",$school_id)->delete();
       return back();
   }
   public function schooledit($school_id)
   {
   	$school= School::findOrfail($school_id);
    	return view('school.edit',compact('school'));

   }
    public function schooleditupdate(Request $request)
   {
 
    //print_r($_POST);
   //dd($request->all());
   	   	$request->validate([
        
        'school_name' => 'required',
        'subject' => 'required',
    ]);

   $school=	School::find($request->school_id);
   	 $school->school_name=$request->school_name;
   	  $school->subject=$request->subject;
   	  $school->save();
   	  return redirect('index')->with('message','update sucessfully!!');
    }

}

|--------------------------------------------------------------------------
| School Routes
|--------------------------------------------------------------------------
*/
Route::get('/index', 'SchoolController@index');
Route::get('/create', 'SchoolController@create');
Route::post('/store', 'SchoolController@store');
Route::get('/school/delete/{school_id}','SchoolController@schooldelete');
Route::get('/school/edit/{school_id}','SchoolController@schooledit');
Route::post('/school/edit/update','SchoolController@schooleditupdate');
|--------------------------------------------------------------------------
| create Routes
|--------------------------------------------------------------------------
*/
<form action="{{ url('store') }}" method="post">
  @csrf
  <div class="form-group">
    <label for="exampleInputEmail1">Shool name</label>
    <input type="text" class="form-control" name="school_name" placeholder="Enter School">
  </div>
   <div class="form-group">
    <label for="exampleInputEmail1">Subject</label>
    <input type="text" class="form-control" name="subject" placeholder="Enter Subject">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

|--------------------------------------------------------------------------
| view
|--------------------------------------------------------------------------
*/
<table class="table">
  <thead>
    <tr>
      <th scope="col">School</th>
      <th scope="col">Subject</th>
    </tr>
  </thead>
  <tbody>
    <tr>
    @foreach($school as $info)
      <td>{{ $info->school_name }}</td>
      <td>{{ $info->subject }}</td>
      <td>
      	<a href="{{ url('school/delete') }}/{{ $info->id }}">Delated</a>
      	<a href="{{ url('school/edit') }}/{{ $info->id }}">Edit</a>
      </td>
    </tr>
    
   @endforeach
  </tbody>
</table>

|--------------------------------------------------------------------------
| view
|--------------------------------------------------------------------------
*/
<H1>Edit {{ $school->school_name }}</H1>
<form action="{{ url('school/edit/update') }}" method="post">
  @csrf
  <div class="form-group">
    <label for="exampleInputEmail1">Shool name</label>
   
    <input type="text" class="form-control" name="school_name" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" value="{{ $school->school_name }}">
  </div>
   <div class="form-group">
    <label for="exampleInputEmail1">Subjecet</label>
    <input type="text" class="form-control" name="subject" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" value="{{ $school->subject }}">
  </div>
  
  <input type="hidden" name="school_id" value="{{  $school->id }}">
 
  <button type="submit" class="btn btn-primary">Submit</button>
</form>