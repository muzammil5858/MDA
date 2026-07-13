@extends('layouts.apprp')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Create New User</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
        </div>
    </div>
</div>


@if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>Whoops!</strong>Something went wrong.<br><br>
    <ul>
       @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
       @endforeach
    </ul>
  </div>
@endif



{{-- {!! Form::open(array('route' => 'users.store','method'=>'POST')) !!} --}}
<form action="{{route('users.store')}}" method="POST">
    @csrf
    <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            <input type="text" name="name" placeholder="Name" class="form-control">
            {{-- {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!} --}}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email:</strong>
            <input type="text" name="email" placeholder="Email" class="form-control">

            {{-- {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!} --}}
        </div>
    </div>
   
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>CNIC:</strong>
            <input type="number" name="cnic" placeholder="CNIC" class="form-control">

            {{-- {!! Form::password('phoneNo', array('placeholder' => 'Phone Number','class' => 'form-control')) !!} --}}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Phone No:</strong>
            <input type="text" name="phone_no" placeholder="Phone Number" class="form-control">

            {{-- {!! Form::password('phoneNo', array('placeholder' => 'Phone Number','class' => 'form-control')) !!} --}}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Password:</strong>
            <input type="password" name="password" placeholder="Password" class="form-control">

            {{-- {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!} --}}
        </div>
    </div>
    
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Confirm Password:</strong>
            <input type="password" name="confirm-password" placeholder="Confirm Password" class="form-control">

            {{-- {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!} --}}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Role:</strong>
            <select name="roles[]" id="roles" multiple class="form-control">
                <option value="">Select Role</option>
                @foreach ($roles as $item)
                    <option value="{{$item}}">{{$item}}</option>
                @endforeach
            </select>
            {{-- <input type="text" name="name" placeholder="Nam" class="form-control multiple"> --}}

            {{-- {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!} --}}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
        <div style="border-width:1px;border-top-radius:round line-hight:1.5;margin-top:14px "class="form-group row">
           
                
           <select id="district"name="district" type="text" class="form-control" value="old('district')" required />
           <option disabled selected value="">District</option>
                             @foreach (App\Models\District::all() as $key => $value)
                               <option value="{{ $value->id }}">{{ $value->name}}</option>
                             @endforeach

 <select>
       </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
        <div style="border-width:1px;border-top-radius:round line-hight:1.5;margin-top:14px "class="form-group row">
           
                
           <select id="tehsil"name="institute" type="text"  class="form-control" value="old('institute')" required />
           <option disabled selected value="">Institute</option>
                            

 <select>
       </div>
        </div>
    </div>
   
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
           
            // $('select[name="tehsil"]').empty();
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