<x-app-layout>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>بلڈنگ کنٹرول سیکشن - منظوری سے انکار | MDHA</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;500;600;700&display=swap');

        .form-container {
            font-family: 'Noto Nastaliq Urdu', 'Segoe UI', serif;
            max-width: 980px;
            margin: 0 auto;
            width: 100%;
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
            overflow: hidden;
            border: 1px solid #e2ddd0;
            direction: rtl;
        }

        .form-header {
            background: #0f2e3f;
            padding: 18px 28px 14px 28px;
            border-bottom: 3px solid #d4a373;
        }

        .badge-title {
            display: inline-block;
            background: #e9c46a;
            color: #1e3a2f;
            font-weight: 700;
            font-size: 0.7rem;
            padding: 4px 14px;
            border-radius: 30px;
            margin-bottom: 8px;
        }

        .form-header h1 {
            color: white;
            font-size: 1.45rem;
            font-weight: 700;
            margin: 6px 0 4px 0;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .form-header p {
            color: #cfdfe9;
            font-size: 0.72rem;
        }

        .form-content {
            padding: 22px 28px 30px 28px;
        }

        .form-rows {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-row {
            background: #fefcf7;
            border-radius: 14px;
            padding: 8px 16px;
            border: 1px solid #ece5d8;
            transition: all 0.15s;
        }

        .form-row:hover {
            border-color: #d4a373;
            background: #fffdf9;
        }

        .row-flex {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .row-number {
            font-weight: 800;
            font-size: 0.85rem;
            background: #e9edf2;
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 30px;
            color: #1e4660;
            flex-shrink: 0;
        }

        .row-text {
            flex: 1;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
            font-weight: 500;
            font-size: 0.85rem;
            color: #1f2d3d;
        }

        .input-field {
            font-family: 'Courier New', 'Noto Nastaliq Urdu', monospace;
            background: #ffffff;
            border: 1px solid #d4cbb8;
            border-radius: 10px;
            padding: 10px 10px;
            font-size: 0.8rem;
            min-width: 70px;
            width: auto;
            transition: all 0.15s;
            text-align: center;
            font-weight: 500;
            color: #1f3b4a;
        }

        .input-field:focus {
            outline: none;
            border-color: #c0842f;
            box-shadow: 0 0 0 2px rgba(192, 132, 47, 0.15);
            background-color: #fffaf2;
        }

        .w-sm  { width: 80px; }
        .w-md  { width: 140px; }
        .w-xs  { width: 120px; }
        .w-xxs { width: 400px !important; }

        /* Toggle Styles */
        .toggle-group {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #f0ede7;
            padding: 3px 6px;
            border-radius: 40px;
            border: 1px solid #e0d6c8;
        }

        .toggle-option {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            cursor: pointer;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: 700;
            font-family: 'Noto Nastaliq Urdu', serif;
            transition: all 0.15s;
            background: transparent;
            color: #5a4a38;
            user-select: none;
        }

        .toggle-option.active-yes {
            background: #1e5e3c;
            color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12);
        }

        .toggle-option.active-no {
            background: #9b3c2a;
            color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12);
        }

        .toggle-option:not(.active-yes):not(.active-no):hover {
            background: #e5ddd2;
        }

        .inline-toggle {
            margin-right: 4px;
            margin-left: 4px;
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 28px;
            flex-wrap: wrap;
        }

        .btn-save, .btn-reset {
            flex: 1;
            padding: 10px 14px;
            font-family: 'Noto Nastaliq Urdu', serif;
            font-size: 0.85rem;
            font-weight: 700;
            border: none;
            border-radius: 40px;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-save {
            background: #1e5e3c;
            color: white;
        }

        .btn-save:hover {
            background: #12452c;
            transform: translateY(-1px);
        }

        .btn-reset {
            background: #8b3c2c;
            color: white;
        }

        .btn-reset:hover {
            background: #6e2f22;
            transform: translateY(-1px);
        }

        .toast-msg {
            text-align: center;
            margin-top: 14px;
            font-weight: 600;
            padding: 6px;
            border-radius: 30px;
            background: #eef2e6;
            color: #2b6e43;
            font-size: 0.75rem;
            min-height: 28px;
        }

        @media (max-width: 650px) {
            .row-flex { flex-direction: column; align-items: flex-start; }
            .toggle-group { margin-top: 5px; }
            .w-xxs { width: 100% !important; }
        }
    </style>
</head>

<div class="form-container">
    <div class="form-header">
        <div class="badge-title">🔖 منگلا ڈیم ہاؤسنگ اتھارٹی | بلڈنگ کنٹرول</div>
        <h1>🏛️ اپروول آف بلڈنگ کنٹرول سیکشن <span style="font-size: 0.75rem;">(پیشہ ورانہ فارم)</span></h1>
        <p>تعمیراتی نقشہ جات، اضافی رقبہ جات اور منظوری کی مکمل رپورٹ — تمام حقائق مستند ہیں</p>
    </div>

    <div class="form-content">

        <form id="mapApprovalForm" action="/engineer/map-approval-store" method="POST">
            @csrf
            <input type="hidden" name="request_id"      value="{{ $request_id }}">
            <input type="hidden" name="property_id"     value="{{ $property->id }}">
            <input type="hidden" name="map_approval_id" value="{{ $mapApproval->id ?? '' }}">

            <div class="form-rows">

                <!-- Row 1 -->
                <div class="form-row">
                    <div class="row-flex">
                        <div class="row-number">1</div>
                        <div class="row-text">
                            پلاٹ
                            <input type="text" class="input-field w-sm"
                                   name="plot_no"
                                   value="{{ old('plot_no', $property->plot_no) }}">
                            {{-- FIX: null-safe operator for township relation --}}
                            ٹاؤن شپ
                            <input type="text" class="input-field w-md"
                                   name="township_name"
                                   value="{{ old('township_name', $property->township?->urdu_name) }}">
                            سیکٹر
                            <input type="text" class="input-field w-sm"
                                   name="sector"
                                   value="{{ old('sector', $property->sector) }}">
                            تعداد
                            <input type="text" class="input-field w-xs"
                                   name="count"
                                   value="{{ old('count', $property->count) }}">
                            ہے۔
                        </div>
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="form-row">
                    <div class="row-flex">
                        <div class="row-number">2</div>
                        <div class="row-text">
                            پلاٹ منظور شدہ ابتدائی نقشہ پلان / ڈرائنگ نمبر
                            <input type="text" class="input-field w-sm"
                                   name="drawing_no"
                                   value="{{ old('drawing_no', $mapApproval->drawing_no ?? '') }}">
                            مورخہ
                            <input type="date" class="input-field w-md"
                                   name="drawing_date"
                                   value="{{ old('drawing_date',
                                            $mapApproval->drawing_date
                                                ? \Carbon\Carbon::parse($mapApproval->drawing_date)->format('Y-m-d')
                                                : ''
                                        ) }}">
                            میں
                            <input type="text" class="input-field w-xxs"
                                   name="drawing_location"
                                   value="{{ old('drawing_location', $mapApproval->drawing_location ?? '') }}">
                            ہے۔
                        </div>
                    </div>
                </div>

                <!-- Row 3 -->
                <div class="form-row">
                    <div class="row-flex">
                        <div class="row-number">3</div>
                        <div class="row-text">
                            نمبر 1,2 کی روشنی میں پلاٹ موقع پر کے لئے مختص شدہ رقبہ یا کمرشل
                            <div class="toggle-group inline-toggle" id="toggleGroup3">
                                <span class="toggle-option" data-value="yes" data-group="group3">✔️ ہاں</span>
                                <span class="toggle-option" data-value="no"  data-group="group3">❌ نہیں</span>
                            </div>
                            {{-- FIX: DB column is "allocated_area" — matches correctly --}}
                            <input type="hidden" name="allocated_area" id="allocatedArea"
                                   value="{{ old('allocated_area', $mapApproval->allocated_area ?? '') }}">
                            ہے۔
                        </div>
                    </div>
                </div>

                <!-- Row 4 -->
                <div class="form-row">
                    <div class="row-flex">
                        <div class="row-number">4</div>
                        <div class="row-text">
                            پلاٹ میں روڈ پر واقع
                            <div class="toggle-group inline-toggle" id="toggleGroup4">
                                <span class="toggle-option" data-value="yes" data-group="group4">✔️ ہاں</span>
                                <span class="toggle-option" data-value="no"  data-group="group4">❌ نہیں</span>
                            </div>
                            {{-- FIX: DB column is "road_location" — matches correctly --}}
                            <input type="hidden" name="road_location" id="roadLocation"
                                   value="{{ old('road_location', $mapApproval->road_location ?? '') }}">
                            ہے۔
                        </div>
                    </div>
                </div>

                <!-- Row 5 -->
                <div class="form-row">
                    <div class="row-flex">
                        <div class="row-number">5</div>
                        <div class="row-text">
                            چار دیواری / مکان تعمیر شدہ
                            <div class="toggle-group inline-toggle" id="toggleGroup5">
                                <span class="toggle-option" data-value="yes" data-group="group5">✔️ ہاں</span>
                                <span class="toggle-option" data-value="no"  data-group="group5">❌ نہیں</span>
                            </div>
                            {{-- FIX: DB column is "construction_status" — matches correctly --}}
                            <input type="hidden" name="construction_status" id="constructionStatus"
                                   value="{{ old('construction_status', $mapApproval->construction_status ?? '') }}">
                            ہے۔
                        </div>
                    </div>
                </div>

                <!-- Row 6 -->
                <div class="form-row">
                    <div class="row-flex">
                        <div class="row-number">6</div>
                        <div class="row-text">
                            پلاٹ ہذا کے ساتھ ملحقہ رقبہ کی منظوری کے بعد پلاٹ کا سائز
                            {{-- FIX: DB column is "plot_size_status", was wrongly "plot_size_after_approval" --}}
                            <input type="text" class="input-field w-md"
                                   name="plot_size_after_approval"
                                   value="{{ old('plot_size_after_approval', $mapApproval->plot_size_status ?? '') }}">
                            ہے۔
                        </div>
                    </div>
                </div>

                <!-- Row 7 -->
                <div class="form-row">
                    <div class="row-flex">
                        <div class="row-number">7</div>
                        <div class="row-text">
                            پلاٹ ہذا کے رقبہ میں
                            {{-- FIX: DB column is "added_area_sq_yards" — matches correctly --}}
                            <input type="text" class="input-field w-md"
                                   name="added_area_sq_yards"
                                   value="{{ old('added_area_sq_yards', $mapApproval->added_area_sq_yards ?? '') }}">
                            مربع گز کا اضافہ ہو چکا
                            {{-- FIX: DB column is "additional_remarks" — matches correctly --}}
                            <input type="text" class="input-field w-md"
                                   name="additional_remarks"
                                   value="{{ old('additional_remarks', $mapApproval->additional_remarks ?? '') }}">
                            ہے۔
                        </div>
                    </div>
                </div>

                <!-- Row 8 -->
                <div class="form-row">
                    <div class="row-flex">
                        <div class="row-number">8</div>
                        <div class="row-text">
                            اس زائد رقبہ کی وجہ سے کوئی سرکاری تنصیب / منڈی / کوئی دیگر پلاٹ
                            <div class="toggle-group inline-toggle" id="toggleGroup8">
                                <span class="toggle-option" data-value="yes" data-group="group8">✔️ ہاں</span>
                                <span class="toggle-option" data-value="no"  data-group="group8">❌ نہیں</span>
                            </div>
                            {{-- FIX: DB column is "impact_on_public" — matches correctly --}}
                            <input type="hidden" name="impact_on_public" id="impactOnPublic"
                                   value="{{ old('impact_on_public', $mapApproval->impact_on_public ?? '') }}">
                            ہے۔
                        </div>
                    </div>
                </div>

                <!-- Row 9 -->
                <div class="form-row">
                    <div class="row-flex">
                        <div class="row-number">9</div>
                        <div class="row-text">
                            زائد رقبہ کسی مقابر عامہ کے رقبہ میں شامل
                            <div class="toggle-group inline-toggle" id="toggleGroup9">
                                <span class="toggle-option" data-value="yes" data-group="group9">✔️ ہاں</span>
                                <span class="toggle-option" data-value="no"  data-group="group9">❌ نہیں</span>
                            </div>
                            {{-- FIX: DB column is "graveyard_status" — matches correctly --}}
                            <input type="hidden" name="graveyard_status" id="graveyardStatus"
                                   value="{{ old('graveyard_status', $mapApproval->graveyard_status ?? '') }}">
                            ہے۔
                        </div>
                    </div>
                </div>

                <!-- Row 10 -->
                <div class="form-row">
                    <div class="row-flex">
                        <div class="row-number">10</div>
                        <div class="row-text">
                            زائد رقبہ کا کوئی علیحدہ پلاٹ نہیں
                            <div class="toggle-group inline-toggle" id="toggleGroup10">
                                <span class="toggle-option" data-value="yes" data-group="group10">✔️ ہاں</span>
                                <span class="toggle-option" data-value="no"  data-group="group10">❌ نہیں</span>
                            </div>
                            {{-- FIX: DB column is "separate_plot" — matches correctly --}}
                            <input type="hidden" name="separate_plot" id="separatePlot"
                                   value="{{ old('separate_plot', $mapApproval->separate_plot ?? '') }}">
                            ہے۔
                        </div>
                    </div>
                </div>

                <!-- Row 11 -->
                <div class="form-row">
                    <div class="row-flex">
                        <div class="row-number">11</div>
                        <div class="row-text">
                            نقشہ ہذا کی اور MDHA / TOR کی روشنی میں
                            <div class="toggle-group inline-toggle" id="toggleGroup11">
                                <span class="toggle-option" data-value="yes" data-group="group11">✔️ ہاں</span>
                                <span class="toggle-option" data-value="no"  data-group="group11">❌ نہیں</span>
                            </div>
                            {{-- FIX: DB column is "tor_compliance" — matches correctly --}}
                            <input type="hidden" name="tor_compliance" id="torCompliance"
                                   value="{{ old('tor_compliance', $mapApproval->tor_compliance ?? '') }}">
                            ہے۔
                        </div>
                    </div>
                </div>

                <!-- Row 12 -->
                <div class="form-row">
                    <div class="row-flex">
                        <div class="row-number">12</div>
                        <div class="row-text">
                            کور ایریا
                            {{-- FIX: DB column is "cover_area" — matches correctly --}}
                            <input type="text" class="input-field w-xxs"
                                   name="covered_area"
                                   value="{{ old('covered_area', $mapApproval->covered_area ?? '') }}">
                            ہے۔
                        </div>
                    </div>
                </div>

            </div>{{-- end .form-rows --}}

            <div class="button-group">
                <button type="submit" class="btn-save">فارم جمع کروائیں</button>
                <button type="button" class="btn-reset" id="resetFormBtn">دوبارہ ترتیب دیں</button>
            </div>

        </form>{{-- end form --}}

        <div id="toastMessage" class="toast-msg"></div>

    </div>{{-- end .form-content --}}
</div>{{-- end .form-container --}}


<script>
(function () {

    // -----------------------------------------------
    // Toggle group initialiser
    // -----------------------------------------------
    function initToggleGroup(groupId, hiddenId, currentValue) {
        var container   = document.getElementById(groupId);
        if (!container) return;

        var hiddenInput = document.getElementById(hiddenId);
        var options     = container.querySelectorAll('.toggle-option');

        function setActive(selectedEl) {
            options.forEach(function (opt) {
                opt.classList.remove('active-yes', 'active-no');
            });

            if (!selectedEl) {
                if (hiddenInput) hiddenInput.value = '';
                return;
            }

            var val = selectedEl.getAttribute('data-value');
            if (hiddenInput) hiddenInput.value = val;

            if (val === 'yes') {
                selectedEl.classList.add('active-yes');
            } else {
                selectedEl.classList.add('active-no');
            }
        }

        // Pre-select based on existing DB / old() value
        if (currentValue === 'yes' || currentValue === 'no') {
            options.forEach(function (opt) {
                if (opt.getAttribute('data-value') === currentValue) {
                    setActive(opt);
                }
            });
        } else {
            setActive(null);
        }

        options.forEach(function (opt) {
            opt.addEventListener('click', function (e) {
                e.stopPropagation();
                // Allow toggling off by clicking the already-active option
                if (opt.classList.contains('active-yes') || opt.classList.contains('active-no')) {
                    setActive(null);
                    return;
                }
                setActive(opt);
            });
        });
    }

    // Config: groupId → hiddenInputId → current DB/old() value
    var toggleConfigs = [
        { groupId: 'toggleGroup3',  hiddenId: 'allocatedArea',      val: '{{ old("allocated_area",      $mapApproval->allocated_area      ?? "") }}' },
        { groupId: 'toggleGroup4',  hiddenId: 'roadLocation',       val: '{{ old("road_location",       $mapApproval->road_location       ?? "") }}' },
        { groupId: 'toggleGroup5',  hiddenId: 'constructionStatus', val: '{{ old("construction_status", $mapApproval->construction_status ?? "") }}' },
        { groupId: 'toggleGroup8',  hiddenId: 'impactOnPublic',     val: '{{ old("impact_on_public",    $mapApproval->impact_on_public    ?? "") }}' },
        { groupId: 'toggleGroup9',  hiddenId: 'graveyardStatus',    val: '{{ old("graveyard_status",    $mapApproval->graveyard_status    ?? "") }}' },
        { groupId: 'toggleGroup10', hiddenId: 'separatePlot',       val: '{{ old("separate_plot",       $mapApproval->separate_plot       ?? "") }}' },
        { groupId: 'toggleGroup11', hiddenId: 'torCompliance',      val: '{{ old("tor_compliance",      $mapApproval->tor_compliance      ?? "") }}' },
    ];

    toggleConfigs.forEach(function (cfg) {
        initToggleGroup(cfg.groupId, cfg.hiddenId, cfg.val);
    });

    // -----------------------------------------------
    // Reset button
    // -----------------------------------------------
    document.getElementById('resetFormBtn').addEventListener('click', function () {
        var clearable = [
            'drawing_no', 'drawing_date', 'drawing_location',
            'plot_size_after_approval', 'added_area_sq_yards',
            'additional_remarks', 'cover_area'
        ];
        clearable.forEach(function (name) {
            var el = document.querySelector('[name="' + name + '"]');
            if (el) el.value = '';
        });

        toggleConfigs.forEach(function (cfg) {
            initToggleGroup(cfg.groupId, cfg.hiddenId, '');
        });

        showToast('فارم دوبارہ ترتیب دے دیا گیا');
    });

    // -----------------------------------------------
    // Toast helper
    // -----------------------------------------------
    var toastEl = document.getElementById('toastMessage');

    function showToast(msg, isError) {
        if (!toastEl) return;
        toastEl.innerText        = msg;
        toastEl.style.color      = isError ? '#b13e3e' : '#2b6e43';
        toastEl.style.background = isError ? '#ffe6e5' : '#e6f4ea';
        setTimeout(function () { toastEl.innerText = ''; }, 2800);
    }

    // -----------------------------------------------
    // Client-side validation
    // -----------------------------------------------
    document.getElementById('mapApprovalForm').addEventListener('submit', function (e) {
        var missing = toggleConfigs.some(function (cfg) {
            var el = document.getElementById(cfg.hiddenId);
            return el && el.value === '';
        });

        if (missing) {
            e.preventDefault();
            showToast('براہ کرم تمام ہاں / نہیں کے اختیارات منتخب کریں', true);
        }
    });

})();
</script>

</x-app-layout>
