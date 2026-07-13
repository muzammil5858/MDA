<div class="document-container" id="document-container2">


    <style>
        .name {
            position: relative;
            transition: all 0.3s ease
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
    @if(count($request->dummyreceiver) > 1)
    <div class="header">
        <div class="photo-section" style="visibility: hidden;" >
        </div>
        @foreach($request->dummyreceiver as $key => $dummyreceiver)
          <div class="head">
             <p id="buyer_statement">نام: {{$dummyreceiver->name}}</p>
            <p id="buyer_statement">ولدیت: {{ preg_replace('/\b(ولد|دختر|بیوہ)\b\s*/u', '',
                $dummyreceiver->father_name) }}</p>
            <p id="seller_statement_address">ساکن: {{$dummyreceiver->address}}</p>
            <p id="buyer_statement_cnic">شناختی کارڈ نمبر: {{$dummyreceiver->cnic}}</p>
        </div>
        @endforeach
    </div>
    <div class="header">
        <div class="photo-section" style=">
            <img src="{{asset('person.png')}}" alt="Photo" id="statement-representative-0">
        </div>

        <div class="head">
            <h1> بذریعہ نمائندہ </h1>
            <p id="buyer_statement">نام: {{$data->callSharedRepresentative->name}}</p>
            <p id="buyer_statement">ولدیت: {{ preg_replace('/\b(ولد|دختر|بیوہ)\b\s*/u', '',
                $data->callSharedRepresentative->father_name) }}</p>
            <p id="seller_statement_address">ساکن: {{$data->callSharedRepresentative->address}}</p>
            <p id="buyer_statement_cnic">شناختی کارڈ نمبر: {{$data->callSharedRepresentative->cnic}}</p>
        </div>

    </div>
    @else
     <div class="header">
        <div class="photo-section" style="width:33%;">
            <img src="{{asset('person.png')}}" alt="Photo" id="statement-representative-0">
        </div>

        <div class="head">
            <h1> بذریعہ نمائندہ </h1>
            <p id="buyer_statement">نام: {{$data->callSharedRepresentative->name}}</p>
            <p id="buyer_statement">ولدیت: {{ preg_replace('/\b(ولد|دختر|بیوہ)\b\s*/u', '',
                $data->callSharedRepresentative->father_name) }}</p>
            <p id="seller_statement_address">ساکن: {{$data->callSharedRepresentative->address}}</p>
            <p id="buyer_statement_cnic">شناختی کارڈ نمبر: {{$data->callSharedRepresentative->cnic}}</p>
        </div>
        <div class="head">
            <h1 style="text-align: center; font-family: 'Noto Nastaliq Urdu', serif;">

            </h1>
             <p id="buyer_statement">نام: {{$request->dummyreceiver[0]->name}}</p>
            <p id="buyer_statement">ولدیت: {{ preg_replace('/\b(ولد|دختر|بیوہ)\b\s*/u', '',
                $request->dummyreceiver[0]->father_name) }}</p>
            <p id="seller_statement_address">ساکن: {{$request->dummyreceiver[0]->address}}</p>
            <p id="buyer_statement_cnic">شناختی کارڈ نمبر: {{$request->dummyreceiver[0]->cnic}}</p>
        </div>
    </div>
    @endif

    <div class="content">

        {!! $request->statement->receiver_statement !!}
    </div>
    <div class="fingerprint">
        <div>
            <img src="" id="thumb-representative-0" style="margin-right:auto;margin-left:auto;width:auto;"
                alt="Fingerprint">
            <p> انگوٹھے کا نشان</p>
        </div>

    </div>
    <div class="footer">
        <p>تاریخ: {{now()->format('d-m-Y')}}</p>
    </div>
</div>
