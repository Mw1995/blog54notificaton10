<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        if(!Auth::guest())
    {
        $nowdate=Carbon::now();
        $posts =DB::table('_notification')->get();
        $users =DB::table('users')->get();
        $pendingtasknum=DB::table('tasks')->where('dt_planned_ended','>=',$nowdate)->count();
        return view('pages.chat',compact('posts','users','pendingtasknum'));
       }
     
      else
          return redirect()->guest('login');


    }
    public function show()
    {   
        if(!Auth::guest())
    {
        $nowdate=Carbon::now();
        $id=Auth::user()->id;
         $posts =DB::table('_notification')->get();
        $pendingtasknum=DB::table('tasks')->where([['status','pending'],['user_id',$id],])->count();
        $event=DB::table('tasks')->where('user_id',$id)->get();
        foreach ($event as $event1) {

    $events[] = \Calendar::event(
    $event1->taskname, //event title
    true, //full day event?
    $event1->dt_created, //start time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg)
    $event1->dt_planned_ended //end time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg),
   
    
);
        }
        
        $calendar = \Calendar::addEvents($events) //add an array with addEvents
         ->setOptions([ //set fullcalendar options
        'firstDay' => 1
    ])->setCallbacks([          ]); 
    //dd($calendar);
       return view('pages.calendar',compact('pendingtasknum','posts','calendar'));


      }
     
     else
             return redirect()->guest('login');



    }
}
