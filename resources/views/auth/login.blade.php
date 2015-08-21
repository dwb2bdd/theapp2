@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
                	<div class="row">
                        <div class="col-md-4">
                            <img src="{{ URL::asset('assets/images/FLS_BLUE_TR.png') }}" alt="FLSMIDTH logo">
                        </div>
    
                        <div class="col-md-8">
                            <br>
                            <h1>Compressor Sizing Program Login</h1>
                        </div>
					</div>
                </div>
				<div class="panel-body">

					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
                    @if (isset($regsuccess))
                        <div class="alert alert-success">
                              {{ $regsuccess }}  
                        </div>
                    @endif

                	<div class="row">
                        <div class="col-md-6">
                             <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
        
                                <div class="form-group">
                                    <label class="col-md-4 control-label">UserID</label>
                                    <div class="col-md-6">
                                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                    </div>
                                </div>
        
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Password</label>
                                    <div class="col-md-6">
                                        <input type="password" class="form-control" name="password">
                                    </div>
                                </div>
        
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <a class="btn btn-link" href="{{ url('/password/email') }}">Forgot Your Password?</a>
                                    
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember"> Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">Login</button>
                                    </div>
                                </div>
                            </form>
                        </div>
    
                        <div class="col-md-6">
                            <a href="{{ url('/auth/register') }}">New user? Click here to request access.</a>
                        </div>
                        
                        <div class="col-md-12 col-md-offset-2">
                            <p>You must have a valid userid and password to accesss the compressor sizing program. <a href="{{ url('/auth/register') }}">Apply here</a></p>
                            <p>Read our <a href="#" id="userAgreementLink">user agreement.</a></p>
                        </div>                        
                        
					</div>                    
                    
				</div>
			</div>
		</div>
	</div>
</div>
  <script type="text/javascript">
  jQuery(document).ready(function ($) {
	$('#myModal').on('shown.bs.modal', function () {
	  $('#myInput').focus()
	});
	
    $('#userAgreementLink').click( function (event) {
		event.preventDefault();
		$('#myModal').modal('show');
    });
		
  });
  </script>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body" id="dwModalBody">
 			@include('register.agreement')       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection