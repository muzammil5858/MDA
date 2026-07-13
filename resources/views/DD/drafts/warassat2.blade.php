<div class="document-container" id="document-container2">
<link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu&display=swap" rel="stylesheet">

    <style>
        .name {
            position: relative;
            transition: all 0.3s ease;
            font-weight: bold !important;
            cursor: crosshair;
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
    @foreach($request->dummywitness as $key => $witness)
    <div class="header">
        <div class="photo-section">
            <img src="{{asset('person.png')}}" alt="Photo" id="statement_witness_{{$key}}">
        </div>
        <div class="head" style="font-family: 'Noto Nastaliq Urdu', serif;">>
            <p id="buyer_statement">
                نام (گواہ نمبر {{$key + 1}}): {{$witness->name}}

            </p>
            <p id="buyer_statement">
                ولدیت: {{ preg_replace('/\b(ولد|دختر|بیوہ)\b\s*/u', '', $witness->father_name) }}
            </p>
            <p id="seller_statement_address">
                ساکن: {{$witness->address}}
            </p>
            <p id="buyer_statement_cnic">
                شناختی کارڈ نمبر: {{$witness->cnic}}
            </p>
        </div>
    </div>
    @endforeach


    <div class="content">
        {!! $request->statement->receiver_statement!!}
    </div>
    <div class="fingerprint">
        @foreach($request->dummywitness as $key => $witness)
        <div>

            <img src="" id="thumb-witness-{{$key}}" style="margin-right:auto;margin-left:auto;width:auto;"
                alt="Fingerprint">
            <p>(گواہ نمبر {{$key + 1}})انگوٹھے کا نشان</p>
        </div>
        @endforeach

    </div>
    <div class="footer">
        <p>تاریخ: {{now()->format('Y-m-d')}}</p>
    </div>
</div>