<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\students;

class StudentController extends Controller
{
   
    
 /**
   * Student Home Page
 */
    public function index()
    {
       $students = students::latest() -> get();
        return view ('Student.index',[
         'students' => $students 
        ]);
    }


/**
 * Student Create Page
*/
public function create()
{
   return view('student.create');
}


/**
 * Student Data Store To database
*/

public function store(Request $request)
{

  /**
   * Photo Upload Feature
  */
  if($request -> hasFile('photo')){

    $file = $request -> file('photo');
    $file_name = md5('date().rand()').'.'.$file -> clientExtension();
    $file -> move(public_path('assets/media/img/uploaded_img'),$file_name);

  }else{
    $file_name = null;
  }



  /**
   * Form Valiation
  */

  $this -> validate($request,[

    'name'        => 'required',
    'email'       => 'required|email|unique:students',
    'cell'        => 'required|numeric|starts_with:01,8801,+8801|digits_between:11,16|unique:students',
    'username'    => 'required|min:8|max:14|unique:students',
    'age'         => 'required|numeric',
    'gender'      => 'required',
    'education'   => 'required',

  ],
    /**
   * Form error custom massage
  */

  [
   'name.required' => 'নামের ঘরটি পূরণ করুন',
   'email.required' => 'ইমেইলের ঘরটি পূরণ করুন',
   'cell.required' => 'নাম্বারের ঘরটি পূরণ করুন',
   'username.required' => 'ইউজার নেমের ঘরটি পূরণ করুন',
   'age.required' => 'বয়সের ঘরটি পূরণ করুন',
   'gender.required' => 'লিঙ্গের ঘরটি পূরণ করুন',
   'education.required' => ' এডুকেশনের ঘরটি পূরণ করুন',


  ]);
  students::create([
    'name'          => $request -> name,
    'email'         => $request -> email,
    'cell'          => $request -> cell,
    'username'      => $request -> username,
    'age'           => $request -> age,
    'gender'        => $request -> gender,
    'education'     => $request -> education,
    'courses'       => json_encode($request -> courses),
    'photo'         => $file_name
  ]);



  return back()->with('success','Student Data Added Successfully!');

}




}