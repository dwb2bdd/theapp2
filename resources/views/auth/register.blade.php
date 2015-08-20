@extends('app')

@section('content')
  
<script type="text/javascript">
	jQuery(document).ready(function ($) {
		$('#registerForm').submit( function (e) {
			e.preventDefault();
			var form = this;
			
			if ($('#accept_agreement').is(':checked'))
				form.submit();
			else
				alert ('You must accept our user agreement to proceed, please make sure to read the agreement thoroughly and check the accept agreement check box.');
		});
		return false;
	});
</script>
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
                            <h1>Compressor Sizing Program Access Request</h1>
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
                    
                    <p>Please complete the following information:</p>
                    
				<form class="form-horizontal" id="registerForm" role="form" method="POST" action="{{ url('/auth/register') }}">
					<div class="row">
                        <div class="col-md-6">
    
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
    
                            <div class="form-group">
                                <label class="col-md-4 control-label">First Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                </div>
                            </div>
    
                            <div class="form-group">
                                <label class="col-md-4 control-label">Last Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-4 control-label">Company</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="company" value="{{ old('company') }}">
                                </div>
                            </div>
    
                            <div class="form-group">
                                <label class="col-md-4 control-label">Address</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="address" value="{{ old('address') }}">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-4 control-label">City, State</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="city_state" value="{{ old('city_state') }}">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-4 control-label">Country</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="country" value="{{ old('country') }}">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-4 control-label">Phone</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                                </div>
                            </div>
    
                            <div class="form-group">
                                <label class="col-md-4 control-label">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                </div>
                            </div>
    
                            <div class="form-group">
                                <label class="col-md-4 control-label">Confirm Email</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email_confirmation" value="{{ old('email_confirmation') }}">
                                </div>
                            </div>
    

                        </div>                
                        
                        <div class="col-md-6">
                        	<p>User type (check one)</p>
							{!! Form::checkbox('user_type', 'End user') !!} End user &nbsp;&nbsp;
							{!! Form::checkbox('user_type', 'OEM') !!} OEM &nbsp;&nbsp;
							{!! Form::checkbox('user_type', 'Packager') !!} Packager &nbsp;&nbsp;
							{!! Form::checkbox('user_type', 'Municipality') !!} Municipality/Agency <br>
							{!! Form::checkbox('user_type', 'Consultant') !!} Consultant &nbsp;&nbsp;<br>
							{!! Form::checkbox('user_type', 'Other') !!} Other (Please Specify): <br>
							<input type="text" class="form-control" name="user_type_other" value="{{ old('user_type_other') }}">
							<br><br>
                        	<p>Primary industry sector:</p>
                            {!!
                                Form::select('primary_industry', array(
                                    '0' => 'Agriculture/Farm',
                                    '1' => 'Landfill',
                                    '2' => 'Wastewater Treatment',
                                    '3' => 'Energy Exploration',
                                    '4' => 'Gas Processing',
                                    '5' => 'Refining',
                                    '6' => 'Natural Gas',
                                    '7' => 'Food and Beverage',
                                    '8' => 'Refrigeration',
                                    '9' => 'Petrochemical',
                                    '10' => 'Power Generation',
                                    '11' => 'Other (specify)',
                                ))                            
                            !!}
                            <br><br>
                            <p>If Other, please specify:</p>
							<input type="text" class="form-control" name="primary_industry_other" value="{{ old('primary_industry_other') }}">
                            
                        </div>        
                        

                            <div class="row" style="clear:both">

                                <div class="row" style="clear:both">
                                    <div class="col-md-10 col-md-offset-1">
                                        <div style="background-color:#000;color:#fff; padding:10px;">
                                            <p>FLSmidth may use the information you provide to distribute marketing and advertising materials directly to you and/or your organization.  Your information will not be distributed outside of FLSmidth or its affiliate companies.  </p>
                                            <p>If you do not wish to receive future marketing or advertising communications from FLSmidth, <a href="/auth/login">click here.</a></p>
                                        </div>
                                        <br>
                                        <input type="checkbox" name="accept_agreement" id="accept_agreement" value="0">
                                        Click here to accept our user agreement.
                                    </div>
                                </div>
                                
                                <div class="row" style="clear:both">
                                  <div id="licenseAgreement" class="col-md-10 col-md-offset-1">
	                                  @include('register.agreement')
                                        
                                    </div>     
                                </div>
                            </div>
                            
                            
                            <br><br>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div>
    
                            <div class="form-group">
                                <label class="col-md-4 control-label">Confirm Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary" style="width:300px; margin-top:20px;">
                                        Send
                                    </button>
                                </div>
                            </div>
                                
					</div>                

				</form>
    
	                <div>
						<p>Thank you for your request.</p>
						<p>Please allow 1 to 2 business days for FLSmidth to verify your information and set up your user account. You will receive an email confirmation with login credentials when your account is approved.</p>
	                </div>                

				</div>
                
                
                
			</div>
		</div>
	</div>
</div>
@endsection
