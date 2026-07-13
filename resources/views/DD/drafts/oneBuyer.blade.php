<div class="document-container" id="document-container2">



    <style>
        .name {
            position: relative;
            transition: all 0.3s ease;
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
    <!-- @foreach($request->dummyreceiver as $index => $receiver)
    <div class="header">
        <div class="photo-section">
            <img src="{{asset('person.png')}}" alt="Photo" id="statement-buyer-{{$index}}">
        </div>


        <div class="head">
            <p id="buyer_statement">نام: {{$receiver->name}}</p>
            <p id="buyer_statement">ولدیت: {{ preg_replace('/\b(ولد|دختر|بیوہ)\b\s*/u', '',
                $receiver->father_name) }}</p>
            <p id="seller_statement_address">ساکن: {{$receiver->address}}</p>
            <p id="buyer_statement_cnic">شناختی کارڈ نمبر: {{$receiver->cnic}}</p>
        </div>
    </div>
    @endforeach -->
    @if($data->shared_representative)
       <div class="header">
        @foreach($request->dummyreceiver as $key => $participants)
        <div class="head">
            <p id="buyer_statement">نام: {{$participants->name}}</p>
            <p id="buyer_statement">ولدیت: {{ preg_replace('/\b(ولد|دختر|بیوہ)\b\s*/u', '',
                $participants->father_name) }}</p>
            <p id="seller_statement_address">ساکن: {{$participants->address}}</p>
            <p id="buyer_statement_cnic">شناختی کارڈ نمبر: {{$participants->cnic}}</p>
        </div>
        @endforeach
    </div>

    <div class="header">
        <div class="photo-section">
            <img src="{{asset('person.png')}}" alt="Photo" id="statement-representative-0">
        </div>
        <div class="head">
            <h1> بذریعہ نمائندہ</h1>
            <p id="buyer_statement"><span
                    style="direction: rtl; text-align: right; font-family: 'Noto Nastaliq Urdu', 'Jameel Noori Nastaleeq', serif;"></span>نام:{{$data->callSharedRepresentative->name}}
            </p>
            <p id="buyer_statement"><span
                    style="direction: rtl; text-align: right; font-family: 'Noto Nastaliq Urdu', 'Jameel Noori Nastaleeq', serif;"></span>ولدیت:{{
                preg_replace('/\b(ولد|دختر|بیوہ)\b\s*/u', '', $data->callSharedRepresentative->father_name) }}
                </p>
            <p id="seller_statement_address">ساکن:{{$data->callSharedRepresentative->address}}</p>
            <p id="buyer_statement_cnic">شناختی کارڈ نمبر:{{$data->callSharedRepresentative->cnic}}</p>
        </div>
    </div>
    @else
    @foreach($request->dummyreceiver as $key => $participant)
    @if($participant->representative)
    <div class="header">
        <div class="photo-section" style="width:33%;">
            <img src="{{asset('person.png')}}" alt="Photo" id="statement-representative-{{$key}}">
        </div>

        <div class="head">
            <h1> بذریعہ مختار عام</h1>
            <p id="buyer_statement">نام: {{$participant->representative->name}}</p>
            <p id="buyer_statement">ولدیت: {{ preg_replace('/\b(ولد|دختر|بیوہ)\b\s*/u', '',
                $participant->representative->father_name) }}</p>
            <p id="seller_statement_address">ساکن: {{$participant->representative->address}}</p>
            <p id="buyer_statement_cnic">شناختی کارڈ نمبر: {{$participant->representative->cnic}}</p>
        </div>

        <div class="head">
            <p id="buyer_statement">نام: {{$participant->name}}</p>
            <p id="buyer_statement">ولدیت: {{ preg_replace('/\b(ولد|دختر|بیوہ)\b\s*/u', '',
                $participant->father_name) }}</p>
            <p id="seller_statement_address">ساکن: {{$participant->address}}</p>
            <p id="buyer_statement_cnic">شناختی کارڈ نمبر: {{$participant->cnic}}</p>
        </div>
    </div>
    @else
    <div class="header">
        <div class="photo-section">
            <img src=" {{asset('person.png')}}"
                alt="Photo" id="statement-buyer-{{$key}}">
        </div>
        <div class="head">
            <p id="buyer_statement">نام: {{$participant->name}}</p>
            <p id="buyer_statement">ولدیت: {{ preg_replace('/\b(ولد|دختر|بیوہ)\b\s*/u', '',
                $participant->father_name) }}</p>
            <p id="seller_statement_address">ساکن: {{$participant->address}}</p>
            <p id="buyer_statement_cnic">شناختی کارڈ نمبر: {{$participant->cnic}}</p>
        </div>
    </div>
    @endif
    <div style="clear: both;"></div>
    @endforeach
    @endif
    <div class="content">

        {!!$request->statement->receiver_statement!!}
    </div>
    <div class="fingerprint">
        @if($data->shared_representative)
        <div>
            <img src="" id="thumb-representative-0" style="margin-right:auto;margin-left:auto;width:auto;" alt="Fingerprint">
            <p> {{$data->callSharedRepresentative->name}}   انگوٹھے کا نشان  </p>
        </div>
        @else
       @foreach($request->dummyreceiver as $index => $receiver)
       @if($receiver->representative)
        <div>
            <img src="" id="thumb-representative-{{$index}}" style="margin-right:auto;margin-left:auto;width:auto;" alt="Fingerprint">
            <p> {{$receiver->representative->name}}   انگوٹھے کا نشان  </p>
        </div>
        @else
        <div>
            <img src="" id="thumb-buyer-{{$index}}" style="margin-right:auto;margin-left:auto;width:auto;" alt="Fingerprint">
            <p> {{$receiver->name}}   انگوٹھے کا نشان  </p>
        </div>
        @endif
        @endforeach
        @endif
    </div>
    <div class="footer">
        <p>تاریخ: {{now()->format('Y-m-d')}}</p>
    </div>
</div>
