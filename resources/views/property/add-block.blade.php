<x-app-layout>

    <div class="container-fluid">

        <div class="row">

            <div class="col-md-8 offset-md-2">

                {{-- Success Message --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-hidden="true">
                            &times;
                        </button>

                        <h5>
                            <i class="icon fas fa-check"></i>
                            Success!
                        </h5>

                        {{ session('success') }}
                    </div>
                @endif

                {{-- Error Message --}}
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-hidden="true">
                            &times;
                        </button>

                        <h5>
                            <i class="icon fas fa-ban"></i>
                            Error!
                        </h5>

                        {{ session('error') }}
                    </div>
                @endif


                {{-- Add Block Card --}}
                <div class="card card-primary">

                    <div class="card-header">
                        <h3 class="card-title">
                            Add New Block
                        </h3>
                    </div>

                    <form action="{{ route('storeBlock') }}"
                          method="POST"
                          id="addBlockForm">

                        @csrf

                        <div class="card-body">

                            {{-- Sector --}}
                            <div class="form-group">

                                <label for="sector_id">
                                    Select Sector
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    name="sector_id"
                                    id="sector_id"
                                    class="form-control select2 @error('sector_id') is-invalid @enderror"
                                    style="width: 100%;"
                                    required
                                >

                                    <option value="">
                                        -- Select Sector --
                                    </option>

                                    @foreach($sectors as $sector)

                                        <option
                                            value="{{ $sector->id }}"
                                            {{ old('sector_id') == $sector->id ? 'selected' : '' }}
                                        >
                                            {{ $sector->name }}
                                        </option>

                                    @endforeach

                                </select>

                                @error('sector_id')

                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>

                                @enderror

                            </div>


                            {{-- Block Name --}}
                            <div class="form-group">

                                <label for="name">
                                    Block Name
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    id="name"
                                    name="name"
                                    placeholder="Enter block name"
                                    value="{{ old('name') }}"
                                    required
                                >

                                @error('name')

                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>

                                @enderror

                                <small class="form-text text-muted">
                                    Block name must be unique within the selected sector.
                                </small>

                            </div>

                        </div>


                        {{-- Footer --}}
                        <div class="card-footer">

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                <i class="fas fa-save"></i>
                                Add Block
                            </button>

                            <a
                                href="{{ route('formList') }}"
                                class="btn btn-secondary"
                            >
                                <i class="fas fa-times"></i>
                                Cancel
                            </a>

                        </div>

                    </form>

                </div>


            </div>

        </div>

    </div>

    @push('styles')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css">

    <style>
        /* Keep the dropdown itself compact and scrollable instead of showing every option */
        .select2-results__options {
            max-height: 220px;
            overflow-y: auto;
        }

        .select2-container .select2-selection--single {
            height: calc(2.25rem + 2px);
            padding: 0.375rem 0.75rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
            padding-left: 0;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: calc(2.25rem + 2px);
        }
    </style>

    @endpush

    @push('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

    <script>

    $(document).ready(function () {

        // Turn the plain <select> into a searchable, compact Select2 dropdown
        $('#sector_id').select2({
            placeholder: '-- Select Sector --',
            allowClear: true,
            width: '100%'
        });


        // Filter blocks by sector
        $('#filterSector').on('change', function () {

            var sectorId = $(this).val();

            if (sectorId === '') {

                $('#blocksTableBody tr').show();

            } else {

                $('#blocksTableBody tr').hide();

                $('#blocksTableBody tr[data-sector="' + sectorId + '"]')
                    .show();
            }

        });

    });

    </script>

    @endpush

</x-app-layout>
