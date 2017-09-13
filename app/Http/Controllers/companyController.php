<?php

namespace Bevy\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class companyController extends Controller
{
    public function index(){
        return view('company.index');
    }

    public function addJobSubmit(Request $r){
       $skills = implode($r->skills,',');
       $contact_email = $r->contact_email;
       $job_title = $r->job_title;
       $requirements = $r->requirements;
       $com_id = Auth::user()->id;

       $add_job = DB::table('jobs')->insert([
           'skills'=> $skills,
           'contact_email'=>$contact_email,
            'job_title'=> $job_title,
           'requirements' => $requirements,
           'company_id' => $com_id,
           'created_at' => \Carbon\Carbon::now()->toDateTimeString(),


       ]);

       if($add_job){
           return back()->with('msg','Nowa oferta pracy została pomyślnie dodana !');
       }
    }

    public function viewJobs(){
        $jobs = DB::table('jobs')->where('company_id',Auth::user()->id)
            ->get();
        return view('company.jobs',compact('jobs'));
    }


}
