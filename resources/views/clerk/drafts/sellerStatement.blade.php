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

    .save-btn:hover {
        background-color: var(--accent-color);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
    }
</style>

@php
    // Your existing PHP Logic remains exactly the same

    $suffixr = '';
    $type12 = ($request->request_type == 3) ? 'ہبہ' : 'بیع';
    $siffixs = ($property->allotment_type == 'original_allotee') ? 'الاٹ' : 'منتقل';

    $index = $property->sale_count;
    $urduOrdinals = [
        1 => 'مشتری', 2 => 'مشتری دوم', 3 => 'مشتری سوم', 4 => 'مشتری چہارم',
        5 => 'مشتری پنجم', 6 => 'مشتری ششم', 7 => 'مشتری ہفتم', 8 => 'مشتری ہشتم',
        9 => 'مشتری نہم', 10 => 'مشتری دہم'
    ];
    $indexesToGet = range($index - 1, $index + 2);
    $filtered = array_intersect_key($urduOrdinals, array_flip($indexesToGet));

    $type = (count($request->participants) > 1) ? 'مسمیان ' : 'مُسمی ';
    $text = (count($request->participants) != count($property->owners)) ? ' اپنے حصے کی حد تک ' : 'اب یہ پلاٹ';
@endphp
@php


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

    $urduOrdinalsPlural = [
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
     $filt = [
    0 => "موہوب الیہ",
    1 => "موہوب الیہان",
    2 => "مشتری",
    3 => "مشتریان",
    4 => "بائع",
    5 => "بائعان",
    6 => "واہب",
    7 => "واہبان",
    ];

    $indexesToGet = range($index - 1, $index + 2); // e.g. 3, 4, 5, 6

    $filtered1 = array_intersect_key($urduOrdinals, array_flip($indexesToGet));
@endphp
@php

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
  $type1 = $urduOrdinals[$index+1] ?? 'مشتری ';
  $text = '';
  $type = $urduOrdinals[$index] ?? ' الاٹی ';
  if($allOwnersMadeRequest){
  $type = $urduOrdinalsPlural[$index-1] ?? ' الاٹیاں ';
  $izzat = 'مسمیان ';
$text = 'یہ پلاٹ';
  }
  if($singleOwner){
  $type = $urduOrdinals[$index] ?? 'الاٹی ';
  $izzat = 'مُسمی ';
  $text = 'یہ پلاٹ';

  }
  else{
  $text = ' اپنے حصے کی حد تک ';
  }
  if($multipleRequest){
  $type = $urduOrdinalsPlural[$index] ?? '';
  $izzat = 'مسمیان ';

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
  if($request->request_type == 3){
    $type1 = 'موہوب الیہ';
  }

  if(count(collect($data->dummyreceiver)) == 1){
  $izzat1 = 'مُسمی ';
  }
  else{
  $izzat1 = 'مسمیان';
  }
  @endphp

<div class="editor-container">
    <div class="editor-header">
        <h2>قانونی دستاویز کی تیاری</h2>
        <span class="label-badge">پلاٹ منتقلی بیان</span>
    </div>

    <form action="{{route('requesterStatementStore',$data->request_id)}}" method="POST">
        @csrf

        <textarea name="requester_statement" id="editor1">
            <div style="direction: rtl; text-align: justify; line-height: 2.2; font-family: 'Noto Nastaliq Urdu', serif;">

            بیان کیا  ہے کہ پلاٹ نمبر{{ $property->plot_no }}
            تعدادی @if($property->kanal) {{ $property->kanal }} کنال @endif
            @if($property->marla) {{ $property->marla }} مرلہ @endif
            @if($property->sqft) {{ $property->sqft }} مربع فٹ @endif واقع سیکثر {{
            $property->sector }} {{$property->township->urdu_name}} تحت ضابطہ بنام {{ $property->owners->map(fn($p) => $p->name . ' ' .
            $p->father_name)->implode('اور') }}
            {{$siffixs}} شدہ ہے۔ {{$type.' '}}{{ $request->participants->map(fn($p) => $p->owner->name .' '.
            $p->owner->father_name)->implode('اور') }} {{$text}} بطور{{' '.$type12}} بالعوض<b>{{
                number_format($data->amount) }} روپے</b>  مُسمی {{ $request->dummyreceiver->map(fn($e) => $e->name .'
            '. $e->father_name)->join('، ') }} کودے کر قبضہ حوالے {{$suffixr}} کر دیا ہے ۔ اس لئے اب <span class="name"
                data-id="muzzamal"><strong>{{$type}}</strong></span> کو اس پلاٹ کی منتقلی بنام <span class="name"
                data-id="muzzamal"><strong>{{$type1}}</strong></span> میں کوئی عذر اعتراض نہیں ہے اور اس پلاٹ کی نسبت کسی دیگر فرد/ادارہ کو مختار/اقرار نامہ
            معاہدہ بیع وغیرہ نہیں دے رکھا ہے اور نہ ہی اس پلاٹ کو رہن رکھ کر کسی بھی سرکاری وغیر سرکاری ادارہ سے قرض
            حاصل کر رکھا ہے۔ بیان ہذا سے قبل اگر اس پلاٹ کی نسبت کسی قسم کا ابہام ہوا تومظہر/ مظہرہ ذمہ دار
            ہوگا/گی/ادارہ ذمہ دار نہ ہوگا۔ مظہر/مظہرہ حلفاً بیان کرتا/ کرتی ہے کہ پلاٹ سے متعلق کاغذات/دستاویزات حوالہ
            <span class="name" data-id="muzzamal"><strong>{{$type1}}</strong></span> کر دئیے ہیں۔استدعا ہیکہ پلاٹ بنام <span class="name"
                data-id="muzzamal"><strong>{{$type1.' '}}</strong></span>{{ $request->dummyreceiver->map(fn($e) => $e->name . ' '. $e->father_name)->join('، ')
            }} منتقل فرمایا جائے۔<br>
            مظہر/مظہرہ حلفاً بیان کرتا ہے کہ مظہر/مظہرہ کو معلوم و تسلیم ہے کہ پلاٹ کی منتقلی پر حکومت کی جانب سے
            ایڈوانس انکم ٹیکس،ایجوکیشن سیس،سٹیمپ ڈیوٹی وغیرہ کے نفاذ کے معاملہ پرپروفیسر(ریٹائرڈ) اذکار احمد وغیرہ بنام
            منگلا ڈیم ہاؤسنگ اتھارٹی میرپور وغیر ہ کے عنوان سے رٹ پٹیشن عدالت العالیہ میں زیرسماعت ہے اور معززعدالت نے
            حکم مصدرہ2022-10-19 کے تحت ایڈوانس انکم ٹیکس ، ایجوکیشن سیس، سٹیمپ ڈیوٹی کی وصولی معطل کی ہوئی ہے ۔ لہذا
            مظہر/مظہرہ پلاٹ زیر بحث کی نسبت جس قدر ٹیکسز درج بالا سابقہ و موجودہ واجب الادا ہوں گے معزز عدالت العالیہ کے
            احکامات کی روشنی میں ادا کرنے کا /کی پابند ہوگا/گی
        </p>

        </p>
            </div>
        </textarea>
         <div class="editor-header">
        <h2>قانونی دستاویز کی تیاری</h2>
        <span class="label-badge">پلاٹ منتقلی بیان</span>
    </div>
         <textarea name="witness_statement" id="editor2">
            <p id="names">
            گواہان مظہران @foreach($filt as $key => $value)
            {{-- اگر یہ پہلا آئٹم نہیں ہے، تب ڈیوائیڈر دکھاؤ --}}
            @if(!$loop->first)
            <span class="divider">/</span>
            @endif

            <span class="name" data-id="muzzamal">{{$value}}</span>
            @endforeach کے بیان مندرجہ بالا کی تصدیق و تائید کرتے ہیں۔
        </p>
        </textarea>

        <input type="hidden" name="request_type" value="{{$request->request_type}}">

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
        height: 200,
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
