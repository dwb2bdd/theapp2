@extends('app')

@section('content')

<h1>Load Sizing</h1>
  <table cellspacing="0" cellpadding="4" border="0" class="data table table-bordered">
    <tr>
      <th></th>
      <th>Calculations Performed By</th>
      <th>Customer</th>
      <th>Reference</th>
      <th>Last Updated</th>
    </tr>    
    @foreach($sizings as $sizing)
    <tr>
      <td> <a href="/loadThisOne/{{ $sizing->id }}">Load this data</a> </td>
<!--      <td> <a href="/public/loadThisOne/{{ $sizing->id }}">Load this data</a> </td> -->
      <td> {{ $sizing->calculations_performed_by }} </td>
      <td> {{ $sizing->customer }} </td>
      <td> {{ $sizing->reference }} </td>
      <td> {{ $sizing->updated_at }} </td>
    </tr>
    @endforeach
  </table>
  <div class="pagination"> {!! $sizings->render() !!} </div>
@stop