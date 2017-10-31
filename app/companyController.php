<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;

class companyController extends Controller
{
    public function index()
    {
        return view('company.index');
    }

    public function addJobSubmit(Request $r)
    {
        $skills = $r->skills;
        $contact_email = $r->contact_email;
        $job_title = $r->job_title;
        $requirements = $r->requirements;
        $com_id = Auth::user()->id;

        $add_job = DB::table('jobs')->insert([
            'skills' => $skills,
            'contact_email' => $contact_email,
            'job_title' => $job_title,
            'requirements' => $requirements,
            'company_id' => $com_id,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),


        ]);

        if ($add_job) {
            return back()->with('msg', 'Nowa oferta pracy została pomyślnie dodana !');
        }
    }

    public function viewJobs()
    {
        $jobs = DB::table('jobs')->where('company_id', Auth::user()->id)
            ->get();
        return view('company.jobs', compact('jobs'));
    }

    public function deleteJob($id)
    {
        $delete = DB::table('jobs')->where('id', $id)->delete();

        if ($delete)
            return back()->with('msg', 'Oferta została usunięta ');
    }

    public function editJob($id)
    {
        $job = DB::table('jobs')
            ->where('id', $id)
            ->get();

        return view('company.editJob', compact('job'));
    }

    public function editJobSubmit(Request $r)
    {
        $skills = $r->skills;
        $contact_email = $r->contact_email;
        $job_title = $r->job_title;
        $requirements = $r->requirements;
        $com_id = Auth::user()->id;

        $edit = DB::table('jobs')
            ->where('company_id', $com_id)->update([
                'skills' => $skills,
                'contact_email' => $contact_email,
                'job_title' => $job_title,
                'requirements' => $requirements,
                'company_id' => $com_id,
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);


        if ($edit) {
            return back()->with('msg', 'Oferta pracy została pomyślnie edytowana !');
        }
    }

}
