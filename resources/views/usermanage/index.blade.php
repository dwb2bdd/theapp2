@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 ">
			<div class="panel panel-default">
				<div class="panel-heading">
                	<div class="row">
                        <div class="col-md-4">
                            <img src="{{ URL::asset('assets/images/FLS_BLUE_TR.png') }}" alt="FLSMIDTH logo">
                        </div>
    
                        <div class="col-md-8">
                            <br>
                            <h1>Compressor Sizing Program Admin Panel</h1>
                        </div>
					</div>
                </div>
                
				<div class="panel-body">
                    <h2>User management</h2>
                    <div>
                      <table cellspacing="0" cellpadding="4" border="0" class="data table table-bordered">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Edit</th>
                        </tr>    
                        @foreach($users as $user)
                        <tr>
                            <td> {{ $user->name }} {{ $user->last_name }} </td>
                            <td> {{ $user->email }} </td>
                            <td> 
                                @if ($user->activated == '0') Active 
                                @else
                                	Not Active, <a href="/loadThisOne/{{ $user->id }}">Activate</a>
                                @endif
                            </td>
                            <td> <a href="/usermanagement/{{ $user->id }}/edit">Edit</a>  or <a href="/loadThisOne/{{ $user->id }}">Delete</a> </td>
                        </tr>
                        @endforeach
                      </table>
                      <div class="pagination"> {!! $users->render() !!} </div>
	                </div>                
				</div>
                
                
                
			</div>
		</div>
	</div>
</div>
@endsection
