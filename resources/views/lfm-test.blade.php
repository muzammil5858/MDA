<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel File Manager Test</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f4f7fb;
        }
        .card {
            border: 0;
            border-radius: 16px;
            box-shadow: 0 10px 35px rgba(15, 23, 42, 0.08);
        }
        #holder {
            min-height: 90px;
            border: 1px dashed #cbd5e1;
            border-radius: 10px;
            padding: 12px;
            background: #fff;
        }
        #holder img {
            max-height: 80px;
            border-radius: 8px;
            margin-right: 10px;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="card">
            <div class="card-body p-4 p-md-5">
                <h3 class="mb-3">Laravel File Manager Test</h3>
                <p class="text-muted mb-4">This is a dummy page to verify the LFM chooser and preview flow.</p>

                <div class="input-group mb-3">
                    <button id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                        <i class="fa fa-image"></i> Choose Image
                    </button>
                    <input id="thumbnail" name="filepath" type="text" class="form-control" placeholder="Selected file path will appear here">
                </div>

                <div id="holder" class="mb-4"></div>

                <div class="alert alert-info mb-0">
                    File manager route prefix: <strong>/{{ config('lfm.url_prefix', 'filemanager') }}</strong>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body p-4">
                <h5 class="mb-3">Embedded LFM</h5>
                <iframe src="/{{ config('lfm.url_prefix', '') }}" style="width: 100%; height: 620px; border: 1px solid #dbe3ef; border-radius: 10px; background: white;"></iframe>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.12.4.min.js"></script>
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script>
        $('#lfm').filemanager('image', { prefix: '/{{ config('lfm.url_prefix', 'filemanager') }}' });
    </script>
</body>
</html>
