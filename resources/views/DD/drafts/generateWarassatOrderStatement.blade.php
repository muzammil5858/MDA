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
          <span class="bold">{{ $data->property->sector }} {{ $data->property->township->urdu_name }}</span>
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

        <p> لہذا بربنائے واقعات محولہ بالا حسب منظوری <span class="bold">مجاز اتھارٹی</span> پلاٹ نمبر <span class="bold">{{$data->property->plot_no}}</span> تعدادی <span class="bold">{{$sizeText}}</span> واقع <span class="bold"> سیکٹر {{$data->property->sector}},{{$data->property->township->urdu_name}}</span> کے {{$text}}حقوق الاٹمنٹ باخراج نام <span class="bold">{{$receiversList}}</span> منتقل کئے جاتے ہیں۔ عمل درآمد ہو۔ </p>
        <br>
        <br>
        <br>
        <br>
        <br>
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
                {{$receiversList}}(شرعی ورثاء)
              </li>
              
              <li>2. ماسٹر فائل۔ </li>
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