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
      background-color: white;
      width: 210mm;
      height: 297mm;
      padding: 10mm;
      box-sizing: border-box;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
      position: relative;
    }

    /* Border Styling */
    .border-frame {
      border: 4px double #000;
      outline: 2px solid #000;
      outline-offset: 4px;
      min-height: calc(100% - 20px);
      height:auto;
      /* Padding inside the border where text lives */
      padding: 10mm 8mm;
      box-sizing: border-box;
      position: relative;
       display: flex;
      flex-direction: column;
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
      font-size: 16px;
      font-weight: bold;
    }

    .header-sub {
      font-size: 14px;
      /* margin-bottom: 5px; */
    }

    .main-title {
      font-size: 30px;
      font-weight: 900;
      /* margin: 5px 0 10px 0; */
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
      font-size: 14px;
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
      margin-top: 20px;
      margin-bottom: 10px;
      display: flex;
      justify-content: flex-end;
      padding-left: 30px;
    }

    .ref-row {
      text-align: center;
      font-weight: bold;
      margin: 15px 0 10px 0;
      font-size: 15px;
    }

    .bottom-container {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      flex-direction: column;
      margin-top: 10px;
    }

    .copy-col {
    
      text-align: right;
    }

    .copy-title {
      font-weight: bold;
      text-decoration: underline;
      margin-bottom: 5px;
      display: inline-block;
    }

    .copy-list {
      list-style-type: decimal;
      margin: 0;
      padding-right: 25px;
    }

    .copy-list li {
      margin-bottom: 3px;
      line-height: 1.6;
    }

    .sig-col {
   
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-end;
      align-self: end;
      padding-top: 20px;
    }

    .signature-block {
      text-align: center;
      width: 180px;
    }

    .fake-sig {
      font-family: 'Brush Script MT', cursive;
      font-size: 30px;
      color: #000080;
      transform: rotate(-10deg);
      margin-bottom: -10px;
      display: block;
      height: 40px;
    }

    .designation {
      border-top: 1px solid #000;
      padding-top: 2px;
      font-weight: bold;
      
      font-size: 14px;
    }

    .bottom-footer {
      position: absolute;
      bottom: 2mm;
      left: 15mm;
      font-family: sans-serif;
      font-size: 11px;
      color: #000;
      direction: ltr;
    }

    @media print {
      body {
        background: none;
      }

      .page {
        box-shadow: none;
        margin: 0;
        width: 100%;
        min-height: calc(100% - 20px);;
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
  </style>
</head>

<body>
  @php
    $typecopy = 'منتقل';
    if($data->property->allotment_type == 'original_allotee') {
    $typecopy = 'الاٹ';
    }
  $index = $data->property->sale_count;

  $urduOrdinals = [
  
  1 => 'مشتری',
  2 => 'مشتری دوم',
  3 => 'مشتری سوم',
  4 => 'مشتری چہارم',
  5 => 'مشتری پنجم',
  6 => 'مشتری ششم',
  7 => 'مشتری ہفتم',
  8 => 'مشتری ہشتم',
  9 => 'مشتری نہم',
  10 => 'مشتری دہم'];

  $type1 = $urduOrdinals[$index] ?? 'مشتری';
  $text = '';
  $text2 = '';
  $type = $urduOrdinals[$index-1] ?? 'مشتری';
  if($singleOwner){
  $type = $urduOrdinals[$index-1] ?? 'مشتریان';
  $type2 = 'الاٹی';
  }
  if($singleOwner){
  
  }
  else{
    $text = ' اپنے حصے کی حد تک ';
  }
  
  if($data->property->latest_transfer == 2){
    $type = 'شرعی ورثاء';
    $type2 = 'الاٹی';
  }
  if($data->property->latest_transfer == 2 && ($singleOwner || !$multipleRequest)){
    $type =  ' پسرشرعی وارث';
    $type2 = 'الاٹی';
  }
  if($data->property->latest_transfer == 3){
    $type = 'پسرموہوب الیہ ';
    $type2 = 'الاٹی';
  }
//   if($data->property->allotment_type == 'original_allotee'){
    $type = 'پسرالاٹی ';
    $type2 = 'الاٹی';
//   }


  @endphp

  @php
  $participantsList = $data->transfer->buyer_name . $data->transfer->buyer_fname;



  @endphp

  @php
  ///receiver list
  $receiversList = $data->dummyreceiver->map(function($receiver) use ($data) {
    $name = $receiver->name ?? '__________';
    $fatherName = $receiver->father_name ?? '__________';
    
    return "$name";
})->implode(', ');


  /// plot size
  $sizeText = '';

  if (!empty($data->property->marla)) {
  $sizeText = $data->property->marla . ' مرلہ';
  } elseif (!empty($data->property->kanal)) {
  $sizeText = $data->property->kanal . ' کنال';
  } else {
  $sizeText = 'N/A'; // fallback if neither is set
  }

  //// rceivers  with address and cnic

$receiversList1 = $data->dummyreceiver->map(function ($receiver) {

    $name       = $receiver->name ?? '__________';
    $fatherName = $receiver->father_name ?? '__________';
    $address    = $receiver->address ?? '__________';
    $cnic       = $receiver->cnic ?? '__________';

    return "بنام $name  $fatherName   ";

})->implode('، ');

$requesterList1 = $data->participants->map(function ($receiver) {

    $name       = $receiver->owner->name ?? '__________';
    $fatherName = $receiver->owner->father_name ?? '__________';
    $address    = $receiver->owner->address ?? '__________';
    $cnic       = $receiver->owner->cnic ?? '__________';

    return "نام  $name  $fatherName ";

})->implode('، ');


  @endphp
  <div class="page" id="captureContainer">
    <div class="border-frame">
      <div class="main-content-wrapper">
      <?php
        $z = url('/');
        $qrCode = $z.'/view-transfer-order'.$data->id;
        ?>

      <div class="qr-code">
        {{-- {!! QrCode::size(100)->generate("$hr") !!} --}}
        {!! QrCode::size(100)->generate("$z") !!}
      </div>


      <div class="header">
        <div class="header-top">آزاد حکومت ریاست جموں و کشمیر</div>
        <div class="header-sub">بورڈ آف ریونیو</div>
        <div class="main-title">منگلا ڈیم ہاؤسنگ اتھارٹی میرپور</div>
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
        <p>
          پلاٹ نمبر <span class="bold">{{ $data->property->plot_no }}</span>
          تعدادی <span class="bold">{{$sizeText}} </span>
          واقع سیکٹر
          <span class="bold">{{ $data->property->township->name }}, Sectior {{ $data->property->sector }}</span>
          تحت ضابطہ بنام
          <span class="bold"><br>
            {{ 
    collect($ownersNotReceivers)
        ->map(fn($owner) => $owner['name'] . ' ' . $owner['father_name'])
        ->implode(', ')
}}
          </span>
          {{$typecopy}} شدہ ہے۔
        </p>

        <p style="direction: rtl;">
          اسس پلاٹ کی منتقلی کے لئے 
<span class="bold">{{$participantsList}}</span> ({{$type}}) نے درخواست دے کر استدعا کی ہے کہ 
<span class="bold">{{$requesterList1}}({{$type2}}) </span> مورخہ 
<span class="bold">{{ \Carbon\Carbon::parse($data->transfer->death_date)->format('Y-m-d') }}</span> کو وفات پا چکا ہے۔ 
جسکے شرعی ورثاء میں 
<span class="bold">{{$receiversList}}</span> زندہ موجود ہیں اور کوئی شرعی وارث موجود نہ ہے۔ 
شرعی ورثاء کی تائید میں پسر متوفی کے علاوہ دو کس معزز گواہان کے بیانات بھی قلمبند ہو چکے ہیں۔ 
ڈیتھ سرٹیفکیٹ کی مصدقہ نقل بطور ثبوت شامل ہے۔ 

 فیس منتقلی مبلغ -/
          <span class="bold">{{ $data->transferAttaches->transferfee_paid_amount ?? '__________' }}</span> روپےروئے چالان نمبر <span>{{$data->transferAttaches->transferfee_challan_no}}</span>
          {{-- @if(!empty($kashmir_liberation_fee)) --}}
          کشمیر لبریشن فیس مبلغ -/
          <span class="bold">{{ $data->transferAttaches->klc_paid_amount ?? '__________' }}</span> روپے چالان نمبر <span>{{$data->transferAttaches->klc_challan_no}}</span>
          مورخہ <span class="bold">{{ $data->transferAttaches->created_at->format('Y-m-d') ?? '__________' }}</span> کو
          {{-- @endif --}}
          داخل خزانہ سرکار اور شرعی ورثاء درج بالا کے حق میں مورخہ
          <span class="bold">{{ $data->head_date ?? '__________' }}</span> کو ہو چکی ہے۔
        </p>

        <p> لہذا بربنائے واقعات محولہ بالا حسب منظوری <span class="bold">مجاز اتھارٹی</span> پلاٹ نمبر <span class="bold">{{$data->property->plot_no}}</span> تعدادی <span class="bold">{{$sizeText}}</span> واقع <span class="bold"> سیکٹر {{$data->property->township->name}}{{$data->property->sector}}</span> کے {{$text}}حقوق الاٹمنٹ باخراج نام <span class="bold">{{$receiversList}}</span> منتقل کئے جاتے ہیں۔ عمل درآمد ہو۔ </p>

      <div class="mid-signature">
        <div class="signature-block">
          {{-- <span class="fake-sig">Signature</span> --}}
          <div class="designation">اسسٹنٹ ڈائریکٹر اسٹیٹ مینجمنٹ</div>
        </div>
      </div>

      <div class="ref-row" >
    نمبر: ڈی ای ایم / ایم ڈی ایچ اے / 
    <input type="text" name="ref_number" 
        placeholder="Number" 
        style="border: none;  width: 70px; font-weight: 600; font-size: 14px; text-align: left; outline: none; background: transparent;">
    / {{$year}}&nbsp;&nbsp; 
    تاریخ: {{ $day }} {{ $month }} {{ $year }}ء
</div>

      <div class="bottom-container">

        <div class="copy-col">
          <span class="copy-title">نقل بالا:</span>
          <ol class="copy-list">
            <li>{{$receiversList}}(شرعی ورثاء)</li>
          
            <li>ماسٹر فائل۔</li>
          </ol>
        </div>

        <div class="sig-col">
          <div class="signature-block">
            {{-- <span class="fake-sig" style="color: #000080;">Signed</span> --}}
            <div class="designation">اسسٹنٹ ڈائریکٹر اسٹیٹ مینجمنٹ</div>
          </div>
        </div>
 <form id="screenshotForm" method="POST" action="/upload-transfer-order/{{$data->id}}" style="display:none;">
      @csrf
  <input type="hidden" name="screenshot" id="screenshotInput">
  <input type="hidden" name="type" value="1">
</form>
      </div>

    </div>
    <div class="bottom-footer">
      This is a system-generated document and does not require a physical signature.
    </div>
  </div>
  </div>
  <div class="action-buttons">
  <button id="screenshotBtn">Take Screenshot</button>
  <button id="printBtn">Print Page</button>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
  // Screenshot of specific element
  document.getElementById('screenshotBtn').addEventListener('click', function() {
    const element = document.getElementById('captureContainer');

    html2canvas(element).then(canvas => {
      const dataURL = canvas.toDataURL('image/png');

      // Set hidden input value
      document.getElementById('screenshotInput').value = dataURL;

      // Submit the form
      document.getElementById('screenshotForm').submit();
    });
  });

  // Print entire page
  document.getElementById('printBtn').addEventListener('click', function() {
    window.print();
  });
</script>

</body>

</html>