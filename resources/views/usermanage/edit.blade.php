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
                            <h1>Compressor Sizing Program Update User</h1>
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
                    

                {!! Form::model($user, [
                    'method' => 'PATCH',
                    'route' => ['usermanagement.update', $user->id],
                    'class' => 'form-horizontal',
                ]) !!}                    
                    <div class="row">
                        <div class="col-md-6">
    
    
                            <div class="form-group">
                                <label class="col-md-4 control-label">First Name</label>
                                <div class="col-md-6">
                                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
    
                            <div class="form-group">
                                <label class="col-md-4 control-label">Last Name</label>
                                <div class="col-md-6">
                                    {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-4 control-label">Company</label>
                                <div class="col-md-6">
                                    {!! Form::text('company', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
    
                            <div class="form-group">
                                <label class="col-md-4 control-label">Address</label>
                                <div class="col-md-6">
                                    {!! Form::text('address', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-4 control-label">City, State</label>
                                <div class="col-md-6">
                                    {!! Form::text('city_state', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-4 control-label">Country</label>
                                <div class="col-md-6">
                                    {!! Form::text('country', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-4 control-label">Phone</label>
                                <div class="col-md-6">
                                    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
    
                            <div class="form-group">
                                <label class="col-md-4 control-label">E-Mail Address</label>
                                <div class="col-md-6">
                                    {!! Form::text('email', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
    
                            <div class="form-group">
                                <label class="col-md-4 control-label">Confirm Email</label>
                                <div class="col-md-6">
                                    {!! Form::text('email_confirmation', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
    

                        </div>                
                        
                        <div class="col-md-6">
                            <p>User type (check one) {!! $user->user_type !!}</p>

                            {!! Form::checkbox('user_type', 'End user') !!} End user &nbsp;&nbsp;
                            {!! Form::checkbox('user_type', 'OEM') !!} OEM &nbsp;&nbsp;
                            {!! Form::checkbox('user_type', 'Packager') !!} Packager &nbsp;&nbsp;
                            {!! Form::checkbox('user_type', 'Municipality') !!} Municipality/Agency <br>
                            {!! Form::checkbox('user_type', 'Consultant') !!} Consultant &nbsp;&nbsp;<br>
                            {!! Form::checkbox('user_type', 'Other') !!} Other (Please Specify): <br>
                            {!! Form::text('user_type_other', null, ['class' => 'form-control']) !!}
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
                            {!! Form::text('primary_industry_other', null, ['class' => 'form-control']) !!}
                            
                        </div>        
                        

                            
                            
                            <br><br>
<!--                            <div class="form-group">
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
                            </div>-->


                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary" style="width:300px; margin-top:20px;">
                                        Update
                                    </button>
                                </div>
                            </div>
                                
                    </div>                

                {!! Form::close() !!}
    
         

                </div>
                
                
                
            </div>
        </div>
    </div>
</div>
@endsection
