<link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

<style>
    :root {
        --primary-color: #2c3e50;
        --accent-color: #3498db;
        --bg-color: #f4f7f6;
        --card-bg: #ffffff;
    }

    body {
        background-color: var(--bg-color);
        font-family: 'Inter', sans-serif;
        color: var(--primary-color);
        margin: 0;
        padding: 40px 0;
    }
.cke_notifications_area{
        display: none;
    }
    .editor-container {
        width: 85%;
        max-width: 1000px;
        margin: 0 auto;
        background: var(--card-bg);
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        direction: rtl;
    }

    .editor-header {
        border-bottom: 2px solid #eee;
        margin-bottom: 30px;
        padding-bottom: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .editor-header h2 {
        margin: 0;
        font-size: 24px;
        color: var(--primary-color);
        font-family: 'Noto Nastaliq Urdu', serif;
    }

    .label-badge {
        background: #e1f0fa;
        color: var(--accent-color);
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }

    /* CKEditor Customization */
    .cke_chrome {
        border: 1px solid #e1e1e1 !important;
        box-shadow: none !important;
        border-radius: 8px !important;
        overflow: hidden;
    }

    .save-btn {
        margin:0px auto;
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 12px 35px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: block;
        margin-top: 25px;
        font-family: 'Inter', sans-serif;
    }
    #editor2{
        height:200px !important;
    }

    .save-btn:hover {
        background-color: var(--accent-color);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
    }
</style>

  @php
  $izzat = 'مُسمی';
  $typecopy = 'منتقل';
  if($data->property->allotment_type == 'original_allotee') {
  $type = 'الاٹی';
  $typecopy = 'الاٹ';
  }

  $index = $data->property->sale_count;


  $urduOrdinals = [
  0 => 'الاٹی',
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

  $urduOrdinalsPlural = [
  0 => 'الاٹیاں',
  1 => 'مشتریان', // مشتري -> مشتريان
  2 => 'مشتریان دوم', // مشتری دوم -> مشتریان دوم
  3 => 'مشتریان سوم', // مشتری سوم -> مشتریان سوم
  4 => 'مشتریان چہارم', // مشتری چہارم -> مشتریان چہارم
  5 => 'مشتریان پنجم', // مشتری پنجم -> مشتریان پنجم
  6 => 'مشتریان ششم', // مشتری ششم -> مشتریان ششم
  7 => 'مشتریان ہفتم', // مشتری ہفتم -> مشتریان ہفتم
  8 => 'مشتریان ہشتم', // مشتری ہشتم -> مشتریان ہشتم
  9 => 'مشتریان نہم', // مشتری نہم -> مشتریان نہم
  10 => 'مشتریان دہم' // مشتری دہم -> مشتریان دہم
  ];
  $type1 = $urduOrdinals[$index] ?? 'مشتری';
  $text = '';
  $Sell = '';
  $type = $urduOrdinals[$index-1] ?? 'مشتریان';
  if($allOwnersMadeRequest){
  $type = $urduOrdinalsPlural[$index-1] ?? 'مشتریان';
  $izzat = 'مسمیان ';
  $Sell = ' بائعان';
  }
  if($singleOwner){
  $type = $urduOrdinals[$index-1] ?? 'مشتری';
  $izzat = 'مُسمی ';
  $Sell = ' بائع';
  }
  else{
  $text = ' اپنے حصے کی حد تک ';
  }
  if($multipleRequest){
  $type = $urduOrdinalsPlural[$index-1] ?? '';
  $izzat = 'مسمیان ';
  $Sell = ' بائعان';
  }
  if($data->property->latest_transfer == 2){
  $type = 'شرعی ورثاء';
  }
  if($data->property->latest_transfer == 2 && ($singleOwner || !$multipleRequest)){

  $type = ' شرعی وارث';
  }
  if($data->property->latest_transfer == 3){
  $type = 'موہوب الیہ';
  }

  if(count(collect($data->dummyreceiver)) == 1){
  $izzat1 = 'مُسمی ';
  }
  else{
  $izzat1 = 'مسمیان';
  }





  @endphp

  @php
  $participantsList = 'مذکور';
  if(!$singleOwner && !$allOwnersMadeRequest)
  $participantsList = $data->participants->map(function($participant) {
  $name = $participant->owner->name ?? '__________';
  $fatherName = $participant->owner->father_name ?? '';

  if ($participant->mode == 'attorney') {
  $attorneyName = $participant->representative->name ?? '__________';
  $attorneyFather = $participant->representative->father_name ?? '';
  return "$name $fatherName (مختار عام: $attorneyName $attorneyFather)";
  }

  return "$name $fatherName";
  })->implode(', ');


  @endphp

  @php
  ///receiver list
  $receiversList = $data->dummyreceiver->map(function($receiver) {
  $name = $receiver->name ?? '__________';
  $fatherName = $receiver->father_name ?? ''; // assuming you have father_name field
  return "$name $fatherName";
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

  //// rceivers with address and cnic

  $receiversList1 = $data->dummyreceiver->map(function ($receiver) {

  $name = $receiver->name ?? '__________';
  $fatherName = $receiver->father_name ?? '__________';
  $address = $receiver->address ?? '__________';
  $cnic = $receiver->cnic ?? '__________';

  return "بنام $name $fatherName ساکن $address شناختی کارڈ نمبر: $cnic ";

  })->implode('، ');

  $requesterList1 = $data->participants->map(function ($receiver) {

  $name = $receiver->owner->name ?? '__________';
  $fatherName = $receiver->owner->father_name ?? '__________';
  $address = $receiver->owner->address ?? '__________';
  $cnic = $receiver->owner->cnic ?? '__________';

  return "نام $name $fatherName ساکن $address شناختی کارڈ نمبر: $cnic ";

  })->implode('، ');


  @endphp

<div class="editor-container">
    <div class="editor-header">
        <h2>حکمِ منتقلی (قانونی مسودہ)</h2>
        {{-- <span class="label-badge">پلاٹ منتقلی بیان</span> --}}
    </div>
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="direction: rtl; text-align: right;">
        <strong>خرابی!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="float: left;"></button>
    </div>
    @endif

    <form action="{{route('requesterStatementStore',$data->id)}}" method="POST">
        @csrf
        <input type="hidden" name="type" value="transferOrder">
        <textarea name="transfer_order" id="editor1">
            @if($data->statement && $data->statement->transfer_order)
                {!! $data->statement->transfer_order !!}
            @else
            <div style="direction: rtl; text-align: justify; line-height: 2.2; font-family: 'Noto Nastaliq Urdu', serif;">
                <p>
                    پلاٹ نمبر <span class="bold">{{ $data->property->plot_no }}</span>
                    تعدادی <span class="bold">{{$sizeText}} </span>
                    واقع سیکٹر
                    <span class="bold">{{ $data->property->sector }}{{ $data->property->township->urdu_name }}</span>
                    تحت ضابطہ بنام
                    <span class="bold">
                        {{
              collect($ownersNotReceivers)
              ->map(fn($owner) => $owner['name'] . ' ' . $owner['father_name'])
              ->implode(', ')
              }}
            </span>

            {{$typecopy}} شدہ ہے۔
          </p>

          <p>
            اس پلاٹ کی منتقلی کے لیے
            <span class="bold">
              {{$izzat}}
              {{ $participantsList }}

            </span>
            نے درخواست دے کر
            استدعا کی ہے کہ اس نے پلاٹ نمبر
            <span class="bold">{{ $data->property->plot_no ?? '__________' }}</span> تعدادی
            <span class="bold">{{ $sizeText}}</span> سیکٹر
            <span class="bold">{{$data->property->sector }} {{ $data->property->township->urdu_name}}</span> {{$izzat1}}
            <span class="bold">{{ $receiversList }}</span> <span>{{$text}}</spam>کو بالعوض -/
              <span class="bold">{{ $data->transfer->amount ?? '__________' }}</span> (روپے) میں فروخت کر دیا ہے اور
              قبضہ
              بھی حوالہ <span class="bold">{{ $type1 }}</span> کر دیا ہے۔
              اس لیے اب <span class="bold">{{ $type }}</span> کو اس پلاٹ کی منتقلی بنام <span class="bold">{{ $type1
                }}</span> کوئی عذر اعتراض نہیں ہے۔ پلاٹ متذکرہ <span class="bold">{{ $type1 }}</span> کے نام منتقل
              فرمایا
              جائے۔
              فیس منتقلی مبلغ -/
              <span class="bold">{{ $data->transferAttaches->transferfee_paid_amount ?? '__________' }}</span> روپےروئے
              چالان نمبر <span>{{$data->transferAttaches->transferfee_challan_no}}</span>
              {{-- @if(!empty($kashmir_liberation_fee)) --}}
              کشمیر لبریشن فیس مبلغ -/
              <span class="bold">{{ $data->transferAttaches->klc_paid_amount ?? '__________' }}</span> روپے چالان نمبر
              <span>{{$data->transferAttaches->klc_challan_no}}</span>
              مورخہ <span class="bold">{{ \Carbon\Carbon::parse($data->transferAttaches->klc_paid_date)->format('Y-m-d')  ?? '__________' }}</span>
              کو
              {{-- @endif --}}
              داخل خزانہ سرکار اور پلاٹ کی منتقلی کی منظوری مورخہ
              <span class="bold">{{ $data->dd_action_date ?? '__________' }}</span> کو ہو چکی ہے۔
          </p>

          <p style="margin-top: 10px;">
            لہذا بربنائے واقعات محولہ بالا حسب منظوری مجاز اتھارٹی پلاٹ نمبر <span
              class="bold">{{$data->property->plot_no}}</span> تعدادی <span class="bold">{{$sizeText}}</span> واقع
            سیکٹر <span class="bold">{{$data->property->sector }} {{ $data->property->township->urdu_name}}</span> کے
            حقوق الاٹمنٹ بااخراج <span class="bold">{{ $requesterList1 }}</span>{{$text}}<span class="bold">{{
              $receiversList1 }}</span> منتقل کیے جاتے ہیں۔ کسی
            قسم کا قانونی سقم، قانونی اعتراض یا سہواً دفتری غلطی کی صورت میں ادارہ منتقلی منسوخ کرنے کا اختیار رکھتا ہے۔
            عمل درآمد ہو۔
            <br>
            نوٹ: ادارہ میں حکومت کی جانب سےایڈوانس ٹیکس،ایجوکیشن سیس، سٹیمپ ڈیوٹی وغیرہ کے نفاذ کے معاملہ پر رٹ پٹیشن عنوانی پروفیسر(ریٹائرڈ) اذکاراحمد وغیربنام منگلاڈیم ہاؤسنگ اتھارٹی وغیرہ عدالت العالیہ میں زیر کار ہے اورمجاز عدالت نے ایڈوانس ٹیکس،ایجوکیشن سیس،سٹیمپ ڈیوٹی کا نفاذ مئوخر کردیا ہے۔لہذا {{$type1}} معززعدالت سے ہونے والے فیصلہ پرعملدرآمد کرنےکاپابندہوگابصورت دیگرحکم منتقلی منسوخ تصور ہو گا۔

</p>
            </div>
            @endif
        </textarea>
        <div class="editor-header">
        <h2>نقلِ بالا (قانونی مسودہ)</h2>
        {{-- <span class="label-badge">پلاٹ منتقلی بیان</span> --}}
    </div>
        <textarea name="nakle_bala" id="editor2">
             @if($data->statement && $data->statement->nakle_bala)
                {!! $data->statement->nakle_bala !!}
                
            @else
            <div style="direction: rtl !important; text-align: justify; line-height: 2.2; font-family: 'Noto Nastaliq Urdu', serif;">
          <ol class="copy-list" style="list-style:none;" >
              <li>
                1. 
                @foreach($data->participants as $receiver)
                @php
                $name = $receiver->owner->name ?? '__________';
                $fatherName = $receiver->owner->father_name ?? '__________';
                $address = $receiver->owner->address ?? '__________';
                @endphp

                {{ "$name $fatherName ساکن $address" }}@if(!$loop->last)، @endif
                @endforeach
                ({{$Sell}})
              </li>
              @foreach($data->dummyreceiver as $receiver)
              @php
              $name = $receiver->name ?? '__________';
              $fatherName = $receiver->father_name ?? '__________';
              $address = $receiver->address ?? '__________';
              @endphp
              <li>2. {{ "$name $fatherName ساکن $address" }}({{$type1}})</li>
              @endforeach


              <li>3. ماسٹر فائل۔ </li>
            </ol>
            </div>
            @endif
        </textarea>
        
        <button type="submit" class="save-btn">Save Statement</button>
    </form>
</div>

<script>
    CKEDITOR.replace('editor1', {
        language: 'ur',
        contentsLangDirection: 'rtl',
        height: 600,
        uiColor: '#ffffff',
        // Improved Editor Styling
        contentsCss: [
            'https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu&display=swap',
            'body { font-family: "Noto Nastaliq Urdu", serif; font-size: 19px; line-height: 2.5; padding: 40px; color: #2c3e50; text-align: justify; }',
            'strong { color: #000; font-weight: bold; }'
        ],
        toolbarGroups: [
            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
            { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
            { name: 'styles' },
            { name: 'colors' },
            { name: 'tools' }
        ],
        allowedContent: true 
    });
    CKEDITOR.replace('editor2', {
        language: 'ur',
        contentsLangDirection: 'rtl',
        height: 300,
        uiColor: '#ffffff',
        // Improved Editor Styling
        contentsCss: [
            'https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu&display=swap',
            'body { font-family: "Noto Nastaliq Urdu", serif; font-size: 19px; line-height: 2.5; padding: 40px; color: #2c3e50; text-align: justify; }',
            'strong { color: #000; font-weight: bold; }'
        ],
        toolbarGroups: [
            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
            { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
            { name: 'styles' },
            { name: 'colors' },
            { name: 'tools' }
        ],
        allowedContent: true 
    });
</script>