<div class="document-container" id="document-container1">

    @php

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

    @endphp
    <style>
        .name {
            position: relative;
            transition: all 0.3s ease;
            font-weight: bold;
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
    <div class="header">
        @foreach($request->participants as $key => $participants)
        <div class="head">
            <p id="buyer_statement">نام: {{$participants->owner->name}}</p>
            <p id="buyer_statement">ولدیت: {{ preg_replace('/\b(ولد|دختر|بیوہ)\b\s*/u', '',
                $participants->owner->father_name) }}</p>
            <p id="seller_statement_address">ساکن: {{$participants->owner->address}}</p>
            <p id="buyer_statement_cnic">شناختی کارڈ نمبر: {{$participants->owner->cnic}}</p>
        </div>
        @endforeach
    </div>

    <div class="header">
        <div class="photo-section">
            <img src="{{asset('person.png')}}" alt="Photo" id="statement-attorney-0">
        </div>
        <div class="head">
            <h1> بذریعہ مختار عام</h1>
            <p id="buyer_statement"><span
                    style="direction: rtl; text-align: right; font-family: 'Noto Nastaliq Urdu', 'Jameel Noori Nastaleeq', serif;"></span>نام:{{$data->callAttorney->name}}
            </p>
            <p id="buyer_statement"><span
                    style="direction: rtl; text-align: right; font-family: 'Noto Nastaliq Urdu', 'Jameel Noori Nastaleeq', serif;"></span>ولدیت:{{
                preg_replace('/\b(ولد|دختر|بیوہ)\b\s*/u', '', $data->callAttorney->father_name) }}
                </p>
            <p id="seller_statement_address">ساکن:{{$data->callAttorney->address}}</p>
            <p id="buyer_statement_cnic">شناختی کارڈ نمبر:{{$data->callAttorney->cnic}}</p>
        </div>
    </div>


    <div class="content">
       {!! $request->statement->requester_statement !!}
    </div>
    <div class="fingerprint">
        <div>
            <img src="" id="thumb-attorney-0" style="margin-right:auto;margin-left:auto;width:auto;" alt="Fingerprint">
            <p>انگوٹھے کا نشان</p>
        </div>
    </div>
    <div class="footer">
        <p>تاریخ:{{now()->format('Y-m-d')}}</p>
    </div>

    <div class="header" style="margin-top:20px;border-top:1px dashed #000;padding-top:10px;">
        <div class="photo-section">
            <img src="{{asset('person.png')}}" alt="Photo" id="statement_witness_1">
        </div>
        <div class="photo-section">
            <img src="{{asset('person.png')}}" alt="Photo" id="statement_witness_0">
        </div>
    </div>
    <div class="content" dir="rtl">
        <table style="width:100%; border-collapse: collapse; text-align:right;">
            <tr>
                <td style="width:50%; padding:5px;">
                    <p>
                        نام معہ ولدیت (گواہ نمبر 1): {{ $request->dummywitness[0]['name'] ?? '' }} {{
                        $request->dummywitness[0]['father_name'] ?? '' }}
                    </p>
                </td>
                <td style="width:50%; padding:5px;">
                    <p>
                        نام معہ ولدیت (گواہ نمبر 2): {{ $request->dummywitness[1]['name'] ?? '' }} {{
                        $request->dummywitness[1]['father_name'] ?? '' }}
                    </p>
                </td>
            </tr>

            <tr>
                <td style="padding:5px;">
                    <p>
                        پتہ: {{ $request->dummywitness[0]['address'] ?? '' }}
                    </p>
                </td>
                <td style="padding:5px;">
                    <p>
                        پتہ: {{ $request->dummywitness[1]['address'] ?? '' }}
                    </p>
                </td>
            </tr>

            <tr>
                <td style="padding:5px;">
                    <p>
                        شناختی کارڈ نمبر: {{ $request->dummywitness[0]['cnic'] ?? '' }}
                    </p>
                </td>
                <td style="padding:5px;">
                    <p>
                        شناختی کارڈ نمبر: {{ $request->dummywitness[1]['cnic'] ?? '' }}
                    </p>
                </td>
            </tr>
        </table>

        {!! $request->statement->witness_statement!!}

    </div>
    <div class="signature">

        <div class="fingerprint">
            <div>

                <img src="" id="thumb-witness-1" style="margin-right:auto;margin-left:auto;width:auto;"
                    alt="Fingerprint">
                <p> دستخط / نشان انگوٹها گواه شناخت نمبر (
                    2) </p>
            </div>
        </div>
        <div class="fingerprint">
            <div>

                <img src="" id="thumb-witness-0" style="margin-right:auto;margin-left:auto;width:auto;"
                    alt="Fingerprint">
                <p> دستخط / نشان انگوٹها گواه شناخت نمبر (1)
                </p>
            </div>
        </div>


    </div>

    <div class="footer">
        <p>تاریخ:{{now()->format('Y-m-d')}}</p>
    </div>
</div>