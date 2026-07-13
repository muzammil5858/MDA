<!DOCTYPE html>
<html lang="ur" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hukam-e-Muntaqli 2017 - MDHA Final</title>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;700&display=swap" rel="stylesheet">

  <style>
    @page {
      size: A4;
      margin: 0;
    }

    body {
      background-color: #e0e0e0;
      margin: 0;
      padding: 20px;
      font-family: 'Noto Nastaliq Urdu', serif;
      display: flex;
      justify-content: center;
    }

     .page {
      background-color: rgb(255, 255, 255);
      width: 250mm;
      height: 286mm;
      padding: 5mm;
      box-sizing: border-box;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
      position: relative;
      
    direction: rtl !important;
    text-align: right !important;

      /* Add watermark as background */
      
    }

     .watermark-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 70%;
            opacity: 0.12; /* Adjust for desired visibility */
            z-index: 1;
            pointer-events: none;
        }

        /* Border Styling */
        .border-frame {
            border: 4px double #000;
            outline: 2px solid #000;
            outline-offset: 4px;
            min-height: 275mm;
            padding: 9mm 8mm;
            box-sizing: border-box;
            position: relative;
            display: flex;
            flex-direction: column;
            z-index: 2; /* Sits above watermark */
            background-color: transparent;
        }

    .main-content-wrapper {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .border-frame::before {
      content: "";
      position: absolute;
      top: -6px;
      left: -6px;
      right: -6px;
      bottom: -6px;
      border: 2px dashed #444;
      z-index: -1;
    }

    /* QR Code Styling - Top Left Corner */
    .qr-code {
      position: absolute;
      top: 10px;
      left: 15px;
      z-index: 10;
    }

    /* Header */
    .header {
      text-align: center;
      margin-bottom: 10px;
      margin-top: -20px;
    }

    .header-top {
      font-size: 20px;
      font-weight: 900 !important;
      text-shadow: 0px 0px 1px #000;
    }

    .header-sub {
      font-size: 14px;
      /* margin-bottom: 5px; */
    }

    .main-title {
      font-size: 25px;
      font-weight: 900;

      text-shadow: 0px 0px 1px #000;
    }

    .title-box {
      margin-top: 4px;
      border: 2px solid #000;
      padding: 0px 60px;
      font-size: 15px;
      font-weight: bolder;
      display: inline-block;
      box-shadow: 3px 3px 0px rgba(0, 0, 0, 0.1);
    }

    /* Content */
    .content {
      font-size: 13px;
      line-height: 2.1;
      text-align: justify;
      text-align-last: right;
    }

    .bold {
      font-weight: bold;
    }

    p {
      margin-bottom: 5px;
      margin-top: 5px;
    }

    .mid-signature {
      margin-top: 0px;
      margin-bottom: 0px;
      display: flex;
      justify-content: flex-end;
      padding-left: 30px;

    }

    .mid-signature .designation,
    .sig-col .designation {
      font-size: 13px;
    }

    .ref-row {
      text-align: right;
      font-weight: bold;

      margin: -10px 0 0px 0;
      font-size: 13px;
    }

    .bottom-container {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      flex-direction: column;
      margin-top: 5px;
    }

    .copy-col {
      width: 100%;
      text-align: right;
    }

    .copy-title {
      font-weight: bold;
      text-decoration: underline;
      margin-bottom: 5px;
      display: inline-block;
    }

    .copy-list {
    list-style-position: inside; /* Keeps numbers tucked into the text */
    padding-right: 0;
    margin-right: 0;
    text-align: right;
}

.copy-list li {
    direction: rtl;
    unicode-bidi: bidi-override; /* Prevents numbers from jumping to the left */
    text-align: right;
    display: list-item;
}

    

    .signature-block {
      text-align: center;
      width: 180px;
    }

   #img{
    width:80px;
    height:80px;
   }

    .designation {
      margin-top:-15px;
      font-weight: bold;
      font-size: 14px;
    }

    .bottom-footer {
      position: absolute;
      bottom: 2mm;
      left: 75mm;
      font-family: sans-serif;
      font-size: 11px;
      color: #000;

      /* direction: ltr; */
    }

    @media print {
      body {
        background: none;
      }

      .page {
        box-shadow: none;
        margin: 0;
        width: 100%;
        
      }
       
  .bottom-footer{
    left:50mm;
  }
    }

    .action-buttons {
      position: fixed;
      top: 50%;
      right: 10px;
      display: flex;
      flex-direction: column;
      gap: 10px;
      z-index: 1000;
    }

    .action-buttons button {
      padding: 10px 15px;
      font-size: 14px;
      cursor: pointer;
      border: none;
      border-radius: 5px;
      background-color: #007bff;
      color: white;
    }

    .action-buttons button:hover {
      background-color: #0056b3;
    }

    @media print {
      .action-buttons {
        display: none !important;
      }
    }
    #previewContainer {
            margin: 20px auto;
            width: 210mm;
            display: none;
            text-align: center;
        }
  </style>
</head>

<body>
  <div class="page" id="captureContainer">
    <img src="{{ asset('/watermark.png') }}" class="watermark-overlay" alt="Watermark">
    <div class="border-frame">
      <div class="main-content-wrapper">
        <?php
        $z = url('/');
        $qrCode = $z.'/view-transfer-order/'.$data->id;
        ?>

        <div class="qr-code">
          {{-- {!! QrCode::size(100)->generate("$hr") !!} --}}
          {!! QrCode::size(100)->generate("$z") !!}
        </div>


        <div class="header">
          <div class=" main-title">آزاد حکومت ریاست جموں و کشمیر</div>
          <div class="header-sub">بورڈ آف ریونیو</div>
          <div class="header-top">منگلا ڈیم ہاؤسنگ اتھارٹی میرپور</div>
          <div class="title-box">حکم منتقلی</div>
        </div>
        @php
        $urduMonths = [
        1 => 'جنوری',
        2 => 'فروری',
        3 => 'مارچ',
        4 => 'اپریل',
        5 => 'مئی',
        6 => 'جون',
        7 => 'جولائی',
        8 => 'اگست',
        9 => 'ستمبر',
        10 => 'اکتوبر',
        11 => 'نومبر',
        12 => 'دسمبر',
        ];
        $date = \Carbon\Carbon::parse(now());
        $day = $date->format('d');
        $month = $urduMonths[(int)$date->format('m')];
        $year = $date->format('Y');
        @endphp

        <div class="content">
          {!! $data->statement->transfer_order !!}
        </div>

        <div class="mid-signature">
          <div class="signature-block">
            <img id="img" src="{{asset('sign-1.png')}}" alt="">
            <div class="designation">اسسٹنٹ ڈائریکٹر اسٹیٹ مینجمنٹ</div>
          </div>
        </div>

        <div class="ref-row">
          نمبر: ڈی ای ایم / ایم ڈی ایچ اے /
          <input type="text" name="ref_number" placeholder="Number"
            style="border: none;  width: 70px; font-weight: 600; font-size: 14px; text-align: left; outline: none; background: transparent;">
          / {{$year}}&nbsp;&nbsp;
          تاریخ: {{ $day }} {{ $month }} {{ $year }}ء
        </div>

        <div class="bottom-container">
          <div class="copy-col">
            <span class="copy-title">نقل بالا:</span>
            {!! $data->statement->nakle_bala !!}
          </div>

          

        </div>

      </div>
      <form id="screenshotForm" method="POST" action="/upload-transfer-order/{{$data->id}}" style="display:none;">
        @csrf
        <input type="hidden" name="screenshot" id="screenshotInput">
        <input type="hidden" name="type" value="1">
      </form>
      
    </div>
    <div class="bottom-footer" >
        This is a system-generated document and does not require a physical signature
      </div>
  </div>
  <div id="previewContainer">
        <hr>
        <h3>Captured Screenshot Preview:</h3>
        <img id="screenshotPreview" src="" alt="Preview" style="width: 100%; border: 1px solid #ccc;">
    </div>
  <div class="action-buttons">
    <button id="screenshotBtn">Save Order</button>
    <button id="printBtn">Print Page</button>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
 <script>
        document.getElementById('screenshotBtn').addEventListener('click', function() {
    const element = document.getElementById('captureContainer');
    
    const options = {
        scale: 4, // Higher scale prevents the "crumbling" of small Urdu curves
        useCORS: true,
        allowTaint: false,
        backgroundColor: "#ffffff",
        // Forces the renderer to treat the element as its actual size
        width: element.offsetWidth,
        height: element.offsetHeight,
        // Critical for RTL: Prevents shifting during capture
        scrollX: -window.scrollX,
        scrollY: -window.scrollY,
        windowWidth: document.documentElement.offsetWidth,
        windowHeight: document.documentElement.offsetHeight
    };

    html2canvas(element, options).then(canvas => {
        const dataURL = canvas.toDataURL('image/png', 1.0);
        document.getElementById('screenshotPreview').src = dataURL;
        document.getElementById('previewContainer').style.display = 'block';
        document.getElementById('screenshotInput').value = dataURL;

        // Optional: Submit
        document.getElementById('screenshotForm').submit();
    });
});

        document.getElementById('printBtn').addEventListener('click', function() {
            window.print();
        });
    </script>


</body>

</html>