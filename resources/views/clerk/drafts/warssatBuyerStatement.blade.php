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
    .cke_notifications_area{
        display: none;
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
  $type1 = $urduOrdinals[$index] ?? 'مشتری ';
  $text = '';
  $type = $urduOrdinals[$index-1] ?? ' مشتریان ';
  if($allOwnersMadeRequest){
  $type = $urduOrdinalsPlural[$index-1] ?? ' مشتریان ';
  $izzat = 'مسمیان ';

  }
  if($singleOwner){
  $type = $urduOrdinals[$index-1] ?? 'مشتری ';
  $izzat = 'مُسمی ';

  }
  else{
  $text = ' اپنے حصے کی حد تک ';
  }
  if($multipleRequest){
  $type = $urduOrdinalsPlural[$index-1] ?? '';
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
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="direction: rtl; text-align: right;">
        <strong>خرابی!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="float: left;"></button>
    </div>
    @endif

    <form action="{{route('receiverStatementStore',$data->id)}}" method="POST">
        @csrf
        
        <textarea name="requester_statement" id="editor1">
            <div style="direction: rtl; text-align: justify; line-height: 2.2; font-family: 'Noto Nastaliq Urdu', serif;">
           <p style="direction: rtl; text-align: right; font-family: 'Noto Nastaliq Urdu', 'Jameel Noori Nastaleeq', serif;margin-top:10px;text-align:justify !important;"
            id="names">


            بیان کیا ہے کہ پلاٹ نمبر {{ $property->plot_no }} تعدادی @if($property->kanal) {{ $property->kanal }} کنال
            @endif
            @if($property->marla) {{ $property->marla }} مرلہ @endif
            @if($property->sqft) {{ $property->sqft }} مربع فٹ @endif واقع سیکثر {{
            $property->sector }} {{$property->township->urdu_name.' '}} تحت ضابطہ بنام {{ $property->owners->map(fn($p) => $p->name . ' ' .
            $p->father_name)->implode(' اور ') }}
            {{$siffixs}} شدہ ہے۔{{$text}}<strong>{{$type}}</strong> مورخہ {{ \Carbon\Carbon::parse($data->death_date)->format('Y-m-d') }} وفات پا چکا /چکی ہے۔ وراثتی انتقال
            موضع{{$data->death_place}} <span class="name" data-id="certificate">جانشینی سرٹیفکیٹ</span>
            <span class="divider">/</span>
            <span class="name" data-id="certificate">ڈیتھ سرٹیفکیٹ</span>

            <span class="name" data-id="certificate">تصدیق شدہ</span>
            <span class="divider">/</span>
            <span class="name" data-id="certificate">جاری شدہ</span>
            ہے ۔مظہر /مظہرہ حلفاً بیان کرتا /کرتی ہے کہ <strong>{{$type}}</strong> کے درج ذیل ورثاء موجود ہیں۔
        </p>
        <ul style="list-style-type: lower-roman; text-align: right; direction: rtl; margin-right: 30px;">
            @foreach($request->dummyreceiver as $dummy)
            <li style="margin-bottom: 5px;">
                {{ $dummy->name . ' ' . $dummy->father_name }}
                @if(!is_null($dummy->area))
                ({{ $dummy->area }} مرلہ)
                @endif
            </li>
            @endforeach

        </ul>

        <br>
        <p
            style="direction: rtl; text-align: right; font-family: 'Noto Nastaliq Urdu', 'Jameel Noori Nastaleeq', serif;">
            درج بالا ورثاء کے علاوہ دیگر کوئی وارث زندہ موجود نہ ہے . اگر ورثاء کے بارہ میں کسی قسم کا ابہام پایا گیا تو
            مظہر / مظہرہ خود ذمہ دار ہو گا/ ہو گی ، ادارہ ذمہ دار نہ ہو گا۔ لہذا پلاٹ زیر بحث بنام شرعی ورثاء درج بالا
            منتقل کیا جائے . بیان اسی قدر ہے .
        </p>
            </div>

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
</script>