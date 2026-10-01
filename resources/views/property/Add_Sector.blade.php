<x-app-layout>

    <div class="container-fluid">

        <div class="row">

            <div class="col-md-8 offset-md-2">

                {{-- Success Message --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <h5><i class="icon fas fa-check"></i> Success!</h5>
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Error Message --}}
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Error!</h5>
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Add Sector Card --}}
                <div class="card card-success">

                    <div class="card-header">
                        <h3 class="card-title">Add New Sector</h3>
                    </div>

                    <form action="{{ route('storeSector') }}" method="POST">
                        @csrf

                        <div class="card-body">

                            <div class="form-group">
                                <label for="name">
                                    Sector Name <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    id="name"
                                    name="name"
                                    placeholder="Enter sector name"
                                    value="{{ old('name') }}"
                                    required
                                >

                                @error('name')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Add Sector
                            </button>

                            <a href="{{ route('formList') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
