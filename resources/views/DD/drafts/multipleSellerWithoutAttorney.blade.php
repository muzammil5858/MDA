<style>
    p{
            direction: rtl !important;
        }
</style>
<div class="document-container" id="document-container1">
    

    @foreach($request->participants as $participants)
                                    <div class="header">
                                        <div class="photo-section">
                                            <img src="{{asset('uploads/user/images/'.$participants->owner->picture)}}" alt="Photo" id="seller_photo">
                                        </div>
                                        <div class="head">
                                             <h1 style="text-align: center; font-family: 'Noto Nastaliq Urdu', serif;">
    بیان بااقرارِ صالح محررہ : {{ \Carbon\Carbon::now()->locale('ur')->translatedFormat('d F Y') }}ء 
</h1>
                                            <p id="buyer_statement" ><span style="direction: rtl; text-align: right; font-family: 'Noto Nastaliq Urdu', 'Jameel Noori Nastaleeq', serif;"></span>{{$participants->owner->name}}:نام</p>
                                            <p id="buyer_statement" ><span style="direction: rtl; text-align: right; font-family: 'Noto Nastaliq Urdu', 'Jameel Noori Nastaleeq', serif;"></span>{{ preg_replace('/\b(ولد|دختر|بیوہ)\b\s*/u', '', $participants->owner->father_name) }}
:ولدیت</p>
                                            <p id="seller_statement_address">{{$participants->owner->address}}:ساکن</p>
                                            <p id="buyer_statement_cnic">{{$participants->owner->cnic}}:شناختی کارڈ نمبر</p>
                                        </div>
                                    </div>
    @endforeach
                                   
                                    <div class="content">
                                        <p  style="direction: rtl; text-align: right; font-family: 'Noto Nastaliq Urdu', 'Jameel Noori Nastaleeq', serif;">
                                           
                                          
                                               بیان کیا ہیکہ ہے کہ پلاٹ نمبر{{ $property->plot_no }} 
                                               تعداد  {{{$request->participants->first()->owner->area}}} مرلہ واقع سیکثر {{$property->township->name}},{{ $property->sector }}،  تحت ضابطہ بنام {{$property->allotee_name}}{{$property->relation}}       منتقل شدہ ہے۔مظہر/مظہر ہ/ نے اب یہ پلاٹ بطورہبہ/بیع بالعوض<b>{{ number_format($data->amount) }} روپے</b>  میں {{ $request->dummyreceiver->map(fn($e) => $e->name . ' ' . $e->father_name)->join('، ') }}  کودے کر قبضہ حوالے موہوب الیہ/مشتری /مشتریہ/مشتری دوئم/مشتری سوئم / مشتری چہارم /مشتری پنجم کر دیا ہے ۔۔ اس لئے اب الاٹی/الاٹیہ/موہوب الیہ/مشتری/مشتریہ/مشتری اوّل /مشتری دوئم/مشتری سوئم /مشتری چہارم/تبادلہ دہندہ کو اس پلاٹ کی منتقلی بنام موہوب الیہ / مشتری / مشتریہ/مشتری دوئم /مشتری سوئم/مشتری چہارم /مشتری پنجم/تبادلہ گرہندہ میں کوئی عذر اعتراض نہیں ہے اور اس پلاٹ کی نسبت کسی دیگر فرد/ادارہ کو مختار/اقرار نامہ معاہدہ بیع وغیرہ نہیں دے رکھا ہے اور نہ ہی اس پلاٹ کو رہن رکھ کر کسی بھی سرکاری وغیر سرکاری ادارہ سے قرض حاصل کر رکھا ہے۔ بیان ہذا سے قبل اگر اس پلاٹ کی نسبت کسی قسم کا ابہام ہوا تومظہر/ مظہرہ ذمہ دار ہوگا/گی/ادارہ ذمہ دار نہ ہوگا۔ مظہر/مظہرہ حلفاً بیان کرتا/ کرتی ہے کہ پلاٹ سے متعلق کاغذات/دستاویزات حوالہ موہوب الیہ/مشتری /مشتریہ /مشتری دوئم/مشتری سوئم /مشتری چہارم/مشتری پنجم کر دئیے ہیں۔استدعا ہیکہ پلاٹ بنام موہوب الیہ / مشتری/مشتریہ/مشتری دوئم/مشتری سوئم مشتری چہارم/مشتری پنجم…{{ $request->dummyreceiver->map(fn($e) => $e->name  .' '. $e->father_name)->join('، ') }}منتقل فرمایا جائے۔<br>مظہر/مظہرہ حلفاً بیان کرتا ہے کہ مظہر/مظہرہ کو معلوم و تسلیم ہے کہ پلاٹ کی منتقلی پر حکومت کی جانب سے ایڈوانس انکم ٹیکس،ایجوکیشن سیس،سٹیمپ ڈیوٹی وغیرہ کے نفاذ کے معاملہ پرپروفیسر(ریٹائرڈ) اذکار احمد وغیرہ بنام منگلا ڈیم ہاؤسنگ اتھارٹی میرپور وغیر ہ کے عنوان سے رٹ پٹیشن عدالت العالیہ میں زیرسماعت ہے اور معززعدالت نے حکم مصدرہ19-10-2022 کے تحت ایڈوانس انکم ٹیکس ، ایجوکیشن سیس، سٹیمپ ڈیوٹی کی وصولی معطل کی ہوئی ہے ۔ لہذا مظہر/مظہرہ پلاٹ زیر بحث کی نسبت جس قدر ٹیکسز درج بالا سابقہ و موجودہ واجب الادا ہوں گے معزز عدالت العالیہ کے احکامات کی روشنی میں ادا کرنے کا /کی پابند ہوگا/گی
                                            </p>
                                            
                                        </p>
                                    </div>
                                    <div class="fingerprint" >
                                        <img src="" id="thumb-seller-0" style="margin-right:auto;margin-left:auto;width:auto;" alt="Fingerprint">
                                        <p>انگوٹھے کا نشان</p>
                                    </div>
                                    <div class="footer">
                                        <p>تاریخ: 18/12/2018</p>
                                    </div>

                                    <div class="header"
                                        style="margin-top:20px;border-top:1px dashed #000;padding-top:10px;">
                                         <div class="photo-section">
                                            <img src="{{asset('person.png')}}" alt="Photo" id="statement_witness_1">
                                        </div>
                                        <div class="photo-section">
                                            <img src="{{asset('person.png')}}" alt="Photo" id="statement_witness_0">
                                        </div>
                                    </div>
                                    <div class="content"  dir="rtl" >
                                    <table style="width:100%; border-collapse: collapse; text-align:right;">
                                        <tr>
                                            <td style="width:50%; padding:5px;">
                                                <p>
                                                نام معہ ولدیت (گواہ نمبر 1): {{ $request->dummywitness[0]['name'] ?? '' }}  {{ $request->dummywitness[0]['father_name'] ?? '' }}
                                                </p>
                                            </td>
                                            <td style="width:50%; padding:5px;">
                                                <p>
                                                نام معہ ولدیت (گواہ نمبر 2): {{ $request->dummywitness[1]['name'] ?? '' }}  {{ $request->dummywitness[1]['father_name'] ?? '' }}
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

                                    <p>
                                        گواہان مظہران الاٹی /الاٹیہ/مشتریہ/مشتری اوّل /موہوب الیہ /مشتری دوئم /مشتری سوئم/مشتری چہارم کے بیان مندرجہ بالا کی تصدیق و تائید کرتے ہیں۔
                                    </p>

                                    </div>
                                    <div class="signature">
                                        
                                        <div class="fingerprint">
                                             <img src="" id="thumb_witness-1" style="margin-right:auto;margin-left:auto;width:auto;" alt="Fingerprint">
                                            <p> دستخط / نشان انگوٹها گواه شناخت نمبر (
                                                2) </p>
                                        </div>
                                        <div class="fingerprint">
                                             <img src="" id="thumb-witness-0" style="margin-right:auto;margin-left:auto;width:auto;" alt="Fingerprint">
                                            <p> دستخط / نشان انگوٹها گواه شناخت نمبر (1)
                                            </p>
                                        </div>


                                    </div>

                                    <div class="footer">
                                        <p>تاریخ:{{now()->format('d-m-Y')}}</p>
                                    </div>
                                </div>