@extends('layouts.apprp')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit New User</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
        </div>
    </div>
</div>


@if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>Whoops!</strong> Something went wrong.<br><br>
    <ul>
       @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
       @endforeach
    </ul>
  </div>
@endif


{{-- {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!} --}}
<form action="{{route('users.update',$user->id)}}" method="POST">
@method('PATCH')
@csrf
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            <input type="text" name="name" value="{{$user->name}}" placeholder="Name" class="form-control">

            {{-- {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!} --}}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email:</strong>
            <input type="text" name="email" value="{{$user->email}}" placeholder="Email" class="form-control">

            {{-- {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!} --}}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>CNIC:</strong>
            <input type="number" name="cnic" value="{{$user->cnic}}" placeholder="CNIC" class="form-control">

            {{-- {!! Form::text('phoneNo', array('placeholder' => 'Phone Number','class' => 'form-control')) !!} --}}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Phone No:</strong>
            <input type="number" name="phone_no" value="{{$user->phone_no}}" placeholder="Phone Number" class="form-control">

            {{-- {!! Form::text('phoneNo', array('placeholder' => 'Phone Number','class' => 'form-control')) !!} --}}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Password:</strong>
            <input type="password" name="password"  placeholder="Password" class="form-control">

            {{-- {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!} --}}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Confirm Password:</strong>
            <input type="password" name="confirm-password"  placeholder="Confirm Password" class="form-control">

            {{-- {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!} --}}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Role:</strong>
            <select name="roles[]" id="roles" class="form-control" multiple>
                <option value="">Select Roles</option>
                @foreach ($roles as $item)
                    <option {{in_array($item,$userRole) ? 'selected' : ''}}  value="{{$item}}">{{$item}}</option>
                @endforeach
            </select>
            {{-- {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple')) !!} --}}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <div style="border-width:1px;border-top-radius:round line-hight:1.5;margin-top:14px "class="form-group row">
                
                
                <select id="district"name="district" type="text" class="form-control" value="old('district')" required />
                <option disabled selected value="">District of User</option>
                             @foreach (App\Models\District::all() as $key => $value)
                               <option  {{$user->district == $value->id ? 'selected' : ''}} value="{{ $value->id }}">{{ $value->name}}</option>
                               @endforeach

                               <select>
       </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
        <div style="border-width:1px;border-top-radius:round line-hight:1.5;margin-top:14px "class="form-group row">
            
            
            <select id="tehsil"name="institute" type="text"  class="form-control" value="old('institute')" required >
                @foreach (App\Models\Institute::where('district_id',$user->district)->get() as $key => $value)
                <option  {{$user->institute == $value->id ? 'selected' : ''}} value="{{ $value->id }}">{{ $value->iname}}</option>
                @endforeach
                            

 <select>
       </div>
        </div>
    </div>
   
    {{-- <div style="border-width:1px;border-top-radius:round line-hight:1.5;margin-top:14px "class="form-group row">
        <select id="Gender" type="text" class="form-control" name="Gender" value="{{ old('Gender') }}"autocomplete="Gender" autofocus>
                              <option value="">* Gender</option>
                                <option {{$user->Gender == 'Male' ? 'selected' : ''}} value="Male">Male</option>
                                <option {{$user->Gender == 'Female' ? 'selected' : ''}} value="Female">Female</option>
                                <option {{$user->Gender == 'Other' ? 'selected' : ''}} value="Other">Other</option>
                                </select>
                                @error('Gender')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div> --}}
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
</form>
{{-- {!! Form::close() !!} --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


<script>
    $(document).ready(function(){
        var district = 0;
        $('#district').change(function(){
            district = $('#district').val();
            $.ajax({
          url:'/tehsils/'+district,
          type:'GET',
          data:{},
          dataType:'JSON',
          success:function(data){
            console.log(data);
            $('select[name="institute"]').empty();
            $.each(data, function(key,value){
              $('select[name="institute"]').append(
                '<option value=" '+value.id+'">'+value.iname+'</option>');
            })
          }
        })

        });


    });
</script>


@endsection
