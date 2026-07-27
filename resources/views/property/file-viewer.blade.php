<x-app-layout>
    <style>
        body { user-select: none; -webkit-user-select: none; }
        #pdfContainer canvas {
            display: block;
            margin: 0 auto 15px auto;
            box-shadow: 0 1px 4px rgba(0,0,0,0.2);
            max-width: 100%;
        }
        #pdfContainer {
            background: #e9ecef;
            padding: 15px;
            text-align: center;
        }
        .loading-text {
            color: #666;
            padding: 30px;
            font-size: 14px;
        }
    </style>

    <div style="padding:20px;" oncontextmenu="return false;">
        <a href="{{ url()->previous() }}"
           style="display:inline-block;margin-bottom:15px;padding:8px 14px;
                  background:#03346E;color:#fff;text-decoration:none;border-radius:4px;">
            ← Back
        </a>

        <h3 style="color:#03346E;margin-bottom:12px;">{{ basename($path) }}</h3>

        <div style="background:#fff;border:1px solid #cfe0ff;padding:10px;">
            @if($type === 'image')
                <img src="{{ $url }}" alt="file" draggable="false"
                     style="max-width:100%;height:auto;display:block;margin:auto;pointer-events:none;">

            @elseif($type === 'pdf')
                <div id="pdfContainer">
                    <div class="loading-text" id="loadingText">Loading PDF File...</div>
                </div>

            @else
                <p>This file does not support preview.
                   <a href="{{ $url }}" download>Click to Download</a>
                </p>
            @endif
        </div>
    </div>

    @if($type === 'pdf')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
        <script>
            pdfjsLib.GlobalWorkerOptions.workerSrc =
                'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

            var url = @json($url);
            var container = document.getElementById('pdfContainer');
            var loadingText = document.getElementById('loadingText');

            pdfjsLib.getDocument(url).promise.then(function (pdf) {
                loadingText.remove();

                var renderPage = function (pageNum) {
                    pdf.getPage(pageNum).then(function (page) {
                        var scale = 1.3;
                        var viewport = page.getViewport({ scale: scale });

                        var canvas = document.createElement('canvas');
                        canvas.oncontextmenu = function () { return false; };
                        var context = canvas.getContext('2d');
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;

                        container.appendChild(canvas);

                        page.render({
                            canvasContext: context,
                            viewport: viewport
                        });
                    });
                };

                for (var i = 1; i <= pdf.numPages; i++) {
                    renderPage(i);
                }
            }).catch(function (err) {
                loadingText.textContent = 'Failed to load PDF.';
                console.error(err);
            });
        </script>
    @endif

    <script>
        document.addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });

        // Ctrl+S / Ctrl+P jese common save/print shortcuts bhi block
        document.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && ['s', 'p', 'u'].includes(e.key.toLowerCase())) {
                e.preventDefault();
            }
        });
    </script>
</x-app-layout>
