   @extends('layouts.master')



@section('content')
 <div style="margin-top: 90px" class=" col-md-8 col-md-offset-4">{!! $calendar->calendar() !!}
    {!! $calendar->script() !!}</div>



        @stop