<x-app-layout>

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

<div class="w-full h-full pt-3">
<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row mx-5 bg-white py-3 px-2 mt-2">
        <div class="col text-center mb-3">
            <h2 style="font-size:30px;">Edit User</h2>
            <p style="font-size:16px;">Update the form fields below to modify user details</p>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" value="{{ $user->name }}" class="form-control">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <strong>Email:</strong>
                <input type="text" name="email" value="{{ $user->email }}" class="form-control">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <strong>CNIC:</strong>
                <input type="number" name="cnic" value="{{ $user->cnic }}" class="form-control">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <strong>Phone No:</strong>
                <input type="number" name="phoneno" value="{{ $user->phoneno }}" class="form-control">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <strong>Town:</strong>
                <select name="town[]" id="town" class="form-control" multiple>
                    @php
                        $towns = DB::table('towns')->get();
                        $selectedTownIds = json_decode($user->town, true) ?? [];
                        
                    @endphp
                    <option disabled>Select Town</option>
                    @foreach($towns as $town)
                        <option value="{{ $town->id }}" {{ in_array($town->id, $selectedTownIds) ? 'selected' : '' }}>
                            {{ $town->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <strong>Password: <small>(leave blank to keep current)</small></strong>
                <input type="password" name="password" placeholder="Password" class="form-control">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <strong>Confirm Password:</strong>
                <input type="password" name="confirm-password" placeholder="Confirm Password" class="form-control">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <strong>Role:</strong>
                <select name="roles[]" id="roles" class="form-control">
                    <option value="">Select Role</option>
                    @foreach ($roles as $role)
                        @if($role == 'user')
                            <option value="{{ $role }}" {{ in_array($role, $user->getRoleNames()->toArray()) ? 'selected' : '' }}>
                                {{ $role }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>

    </div>
</form>
</div>

</x-app-layout>
