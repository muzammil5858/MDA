<div class="document-container" id="document-container1">
    
<link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu&display=swap" rel="stylesheet">
    <style>
        .name {
            position: relative;
            transition: all 0.3s ease;
            font-weight: bold !important;
            cursor: crosshair;
            color: black;
        }

        .name.strike::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            top: 50%;
            height: 2px;
            background: #050505;
            transform: translateY(-50%)
        }

        .name.strike.move-line::after {
            top: 100%;
            transform: translateY(-100%);
        }

        .divider {
            font-weight: bold;
            color: #6b7280
        }
        p{
            direction: rtl !important;
        }
    </style>

   <h1 style="text-align: center; font-family: 'Noto Nastaliq Urdu', serif;">
    بیان بااقرارِ صالح محررہ : {{ \Carbon\Carbon::now()->locale('ur')->translatedFormat('d F Y') }}ء 
</h1>
    <div class="header">
        <div class="photo-section">
            <img src="{{asset('person.png')}}" alt="Photo" id="statement-attorney-0">
        </div>
        <div class="head" style="font-family: 'Noto Nastaliq Urdu', serif;">
            <p id="buyer_statement">نام: {{$request->dummyreceiver->first()->name}}</p>
            <p id="buyer_statement">ولدیت: {{ preg_replace('/\b(ولد|دختر|بیوہ)\b\s*/u', '',
                $request->dummyreceiver->first()->father_name) }}</p>
            <p id="seller_statement_address">ساکن: {{$request->dummyreceiver->first()->address}}</p>
            <p id="buyer_statement_cnic">شناختی کارڈ نمبر: {{$request->dummyreceiver->first()->cnic}}</p>
        </div>
    </div>


    <div class="content">
       {!! $request->statement->requester_statement!!}
    </div>
    <div class="fingerprint">

        <div>

            <img src="" id="thumb-attorney-0" style="margin-right:auto;margin-left:auto;width:auto;" alt="Fingerprint">
            <p>انگوٹھے کا نشان</p>
        </div>

    </div>
    <div class="footer">
        <p>تاریخ: {{now()->format('Y-m-d')}}</p>
    </div>
</div>