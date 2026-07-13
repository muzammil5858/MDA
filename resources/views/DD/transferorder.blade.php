<!DOCTYPE html>
<html lang="ur" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hukam-e-Muntaqli 2017 - MDHA Final</title>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    @page {
      size: A4;
      margin: 0;
    }

    body {
      background-color: #e0e0e0;
      margin: 0;
      padding: 20px;
      font-family: 'Noto Nastaliq Urdu', serif;
      display: flex;
      justify-content: center;
    }

    /* Modal Styles */
    .modal {
      display: none;
      position: fixed;
      z-index: 10000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.8);
      animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    .modal-content {
      background-color: #fff;
      margin: 5% auto;
      padding: 20px;
      border-radius: 10px;
      width: 80%;
      max-width: 900px;
      max-height: 85vh;
      overflow-y: auto;
      box-shadow: 0 5px 30px rgba(0, 0, 0, 0.3);
      animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
      from {
        transform: translateY(-50px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-bottom: 15px;
      border-bottom: 2px solid #eee;
      margin-bottom: 20px;
    }

    .modal-title {
      font-size: 22px;
      font-weight: bold;
      color: #2c3e50;
    }

    .close-modal {
      background: none;
      border: none;
      font-size: 28px;
      cursor: pointer;
      color: #7f8c8d;
      transition: color 0.3s;
    }

    .close-modal:hover {
      color: #e74c3c;
    }

    .preview-container {
      text-align: center;
      margin-bottom: 25px;
    }

    .preview-image {
      max-width: 100%;
      min-height: 500px;
      border: 1px solid #ddd;
      border-radius: 5px;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    .confirmation-message {
      background-color: #f8f9fa;
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 20px;
      border-right: 4px solid #007bff;
      font-size: 16px;
      color: #2c3e50;
    }

    .confirmation-message i {
      color: #007bff;
      margin-left: 8px;
    }

    .modal-actions {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-top: 20px;
    }

    .modal-btn {
      padding: 12px 30px;
      font-size: 16px;
      font-weight: bold;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .confirm-btn {
      background-color: #28a745;
      color: white;
    }

    .confirm-btn:hover {
      background-color: #218838;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }

    .cancel-btn {
      background-color: #dc3545;
      color: white;
    }

    .cancel-btn:hover {
      background-color: #c82333;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
    }

    .loading-overlay {
      display: none;
      position: fixed;
      z-index: 10001;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.7);
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }

    .loading-spinner {
      border: 5px solid #f3f3f3;
      border-top: 5px solid #007bff;
      border-radius: 50%;
      width: 50px;
      height: 50px;
      animation: spin 1s linear infinite;
      margin-bottom: 15px;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .loading-text {
      color: white;
      font-size: 18px;
      margin-top: 10px;
    }

    .page {
    background-color: #ffffff;
    width: 210mm;
    height: 285mm;
    padding: 5mm; /* optional */
    box-sizing: border-box;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
    position: relative;
}


    /* Watermark overlay - added here */
    .watermark-overlay {
      position: absolute;
      top: 45%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 50%;
      opacity: 0.12;
      z-index: 1;
      pointer-events: none;
    }

    /* Border Styling - UPDATED */
    .border-frame {
      border: 4px double #000;
      /* outline: 2px solid #000; */
      outline-offset: 4px;
      min-height: calc(100% - 10px);
      height: auto;
      padding: 9mm 8mm;
      box-sizing: border-box;
      position: relative;
      display: flex;
      flex-direction: column;
      background-color: rgba(255, 255, 255, 0.85);
      opacity: 1;
    }
    .border{
       border: 2px solid #000;

      margin: -11.5mm -10.5mm 0mm 0mm;
      position: absolute;
      width:calc(103% - 3px);
      min-height: calc(103% - 10px);
      box-sizing: border-box;
      position: absolute;
      opacity: 1;
    }

    /* Dashed border div */
    .dashed-border {
      position: absolute;
      top: -6px;
      left: -6px;
      right: -6px;
      bottom: -6px;
      border: 2px dashed #444;
      z-index: 1;
      pointer-events: none;
    }

    /* OUTER BORDER - This will be added dynamically during screenshot */
    .outer-border-overlay {
      position: absolute;
      top: -25px;
      left: -25px;
      right: -25px;
      bottom: -25px;
      border: 15px solid #2c3e50;
      border-radius: 20px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
      z-index: 3;
      pointer-events: none;
      display: none;
    }

    /* INNER CORNER ACCENT */
    .inner-corner-accent {
      position: absolute;
      top: -18px;
      left: -18px;
      right: -18px;
      bottom: -18px;
      border: 8px solid #3498db;
      border-radius: 15px;
      z-index: 2;
      pointer-events: none;
      display: none;
    }

    .main-content-wrapper {
      flex: 1;
      display: flex;
      flex-direction: column;
      z-index: 2;
      position: relative;
    }

    /* QR Code Styling - Top Left Corner */
    .qr-code {
      position: absolute;
      top: -15px;
      left: -17px;
      z-index: 10;
    }

    /* Header */
    .header {
      text-align: center;
      margin-bottom: 10px;
      margin-top: -20px;
    }

    .header-top {
      font-size: 20px;
      font-weight: 900 !important;
      text-shadow: 0px 0px 1px #000;
    }

    .header-sub {
      font-size: 14px;
    }

    .main-title {
      font-size: 25px;
      font-weight: 900;
      text-shadow: 0px 0px 1px #000;
    }

    .title-box {
      margin-top: 4px;
      border: 2px solid #000;
      padding: 0px 60px;
      font-size: 15px;
      font-weight: bolder;
      display: inline-block;
      box-shadow: 3px 3px 0px rgba(0, 0, 0, 0.1);
    }

    /* Content */
    .content {
      font-size: 13px;
      line-height: 2.1;
      text-align: justify;
      text-align-last: right;
    }

    .bold {
      font-weight: bold;
    }

    p {
      margin-bottom: 5px;
      margin-top: 5px;
    }

    .mid-signature {
      margin-top: 0px;
      margin-bottom: 0px;
      display: flex;
      justify-content: flex-end;
      padding-left: 30px;
    }

    .mid-signature .designation,
    .sig-col .designation {
      font-size: 13px;
    }

    .ref-row {
      text-align: right;
      font-weight: bold;
      margin: -10px 0 0px 0;
      font-size: 13px;
    }

    .bottom-container {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      flex-direction: column;
      position: relative;
      margin-top: 5px;
    }

    .copy-col {
      width: 100%;
      text-align: right;
    }

    .copy-title {
      font-weight: bold;
      text-decoration: underline;
      margin-bottom: 5px;
      display: inline-block;
      direction: rtl !important;
    }

    .copy-list {
      list-style-type: decimal;
      margin: 0;
      padding-right: 25px;
    }

    .copy-list li {
      margin-bottom: 3px;
      font-size: 13px;
      line-height: 1.6;
      direction: rtl !important;
    }

    .signature-block {
      text-align: center;
      width: 180px;
    }

    #img {
      width: 80px;
      height: 80px;
    }

    .designation {
      margin-top: -15px;
      font-weight: bold;
      font-size: 14px;
    }

    .bottom-footer {
      position: absolute;
       width:95%;
      margin-top:2px;
      display: flex;
      justify-content: center;

    }
    .bottom-footer p{
      font-family: sans-serif;
      font-size: 11px;
      color: #000;
      direction: ltr !important;
      font-weight: normal;
    }

    @media print {
      body {
        background: none;
      }

      .page {
        box-shadow: none;
        margin: 0;
        width: 100%;
      }

      .watermark-overlay {
        opacity: 0.12 !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
      }

      .bottom-footer {
        left: 50mm;
      }

      .outer-border-overlay,
      .inner-corner-accent {
        display: none !important;
      }
    }

    .action-buttons {
      position: fixed;
      top: 50%;
      right: 10px;
      display: flex;
      flex-direction: column;
      gap: 10px;
      z-index: 1000;
    }

    .action-buttons button {
      padding: 10px 15px;
      font-size: 14px;
      cursor: pointer;
      border: none;
      border-radius: 5px;
      background-color: #007bff;
      color: white;
    }

    .action-buttons button:hover {
      background-color: #0056b3;
    }

    @media print {
      .action-buttons {
        display: none !important;
      }
    }

    /* Hide the span used for screenshot by default */
    .ref_number_ss {
      display: none;
    }

    /* Add these border styles to the page container */
    .screenshot-mode .page {
      padding: 20px;
    }

    .screenshot-mode .outer-border-overlay {
      display: block !important;
    }

    .screenshot-mode .inner-corner-accent {
      display: block !important;
    }
  </style>
</head>

<body>
  <div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
    <div class="loading-text">آرڈر محفوظ ہو رہا ہے... براہ کرم انتظار کریں</div>
  </div>

  <!-- Preview Modal -->
  <div class="modal" id="previewModal">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">
          <i class="fas fa-eye"></i> آرڈر کا پیش نظارہ
        </h2>
        <button class="close-modal" id="closeModal">
          <i class="fas fa-times"></i>
        </button>
      </div>

      <div class="preview-container">
        <img id="screenshotPreview" class="preview-image" src="" alt="Order Preview">
      </div>

      <div class="confirmation-message">
        <i class="fas fa-question-circle"></i>
        <strong>تصدیق:</strong> کیا آپ یہ آرڈر محفوظ کرنا چاہتے ہیں؟ ایک بار محفوظ ہونے کے بعد آپ اسے واپس نہیں لوٹا سکتے۔
      </div>

      <div class="modal-actions">
        <button class="modal-btn confirm-btn" id="confirmUpload">
          <i class="fas fa-check-circle"></i> جی ہاں، محفوظ کریں
        </button>
        <button class="modal-btn cancel-btn" id="cancelUpload">
          <i class="fas fa-times-circle"></i> نہیں، منسوخ کریں
        </button>
      </div>
    </div>
  </div>

  <div class="page" id="captureContainer">
    <!-- Watermark Overlay -->
    <img src="{{ asset('/watermark.png') }}" class="watermark-overlay" alt="Watermark">

    <!-- ADD THESE OVERLAY DIVS HERE -->
    <div class="outer-border-overlay"></div>
    <div class="inner-corner-accent"></div>

    <div class="border-frame">
      <div class="border"></div>


      <!-- Add dashed border div here -->
      <div class="dashed-border"></div>

      <div class="main-content-wrapper">
        <?php
        $z = 'https://mdha.punjab.gov.pk';
        $qrCode = $z.'/view-transfer-order/'.$data->id;
        ?>

        <div class="qr-code">
          {!! QrCode::size(100)->generate("$qrCode") !!}
        </div>

        <div class="header">
          <div class="main-title">آزاد حکومت ریاست جموں و کشمیر</div>
          <div class="header-sub">بورڈ آف ریونیو</div>
          <div class="header-top">منگلا ڈیم ہاؤسنگ اتھارٹی میرپور</div>
          <div class="title-box">حکم منتقلی</div>
        </div>

        @php
        $urduMonths = [
          1 => 'جنوری',
          2 => 'فروری',
          3 => 'مارچ',
          4 => 'اپریل',
          5 => 'مئی',
          6 => 'جون',
          7 => 'جولائی',
          8 => 'اگست',
          9 => 'ستمبر',
          10 => 'اکتوبر',
          11 => 'نومبر',
          12 => 'دسمبر',
        ];
        $date = \Carbon\Carbon::now();
        $day = $date->format('d');
        $month = $urduMonths[(int)$date->format('m')];
        $year = $date->format('Y');
        @endphp

        <div class="content">
          {!! $data->statement->transfer_order !!}
        </div>

        <div class="mid-signature">
            @if(auth()->user()->hasRole('assistant-director'))
          <div class="signature-block">
            <img id="img" src="{{asset('sign-1.png')}}" alt="">
            <div class="designation">اسسٹنٹ ڈائریکٹر اسٹیٹ مینجمنٹ</div>
          </div>
            @elseif(auth()->user()->hasRole('deputy-director'))
            <div class="signature-block">
            <img id="img" src="{{asset('deputy-sign.png')}}" alt="">
            <div class="designation">ڈپٹی ڈائریکٹر اسٹیٹ مینجمنٹ</div>
          </div>
          @endif

        </div>

        <div class="ref-row">
          نمبر: ڈی ای ایم / ایم ڈی ایچ اے /
          <input type="text" class="ref_number" name="ref_number" placeholder="Number"
            style="direction:ltr;border: none; width: 70px; font-weight: 600; font-size: 14px; text-align: left; outline: none; background: transparent;">
          <span class="ref_number_ss"></span>
          / {{$year}}&nbsp;&nbsp;
          تاریخ: {{ $day }} {{ $month }} {{ $year }}ء
        </div>

        <div class="bottom-container">
          <div class="copy-col">
            <span class="copy-title">نقل بالا:</span>
            {!! $data->statement->nakle_bala !!}
          </div>
        </div>
      </div>

      <form id="screenshotForm" method="POST" action="/upload-transfer-order/{{$data->id}}" style="display:none;">
        @csrf
        <input type="hidden" name="screenshot" id="screenshotInput">
        <input type="hidden" name="type" value="1">
      </form>
    </div>

    <div class="bottom-footer">
      <p>
      This is a system-generated document and does not require a physical signature.
      </p>
    </div>
  </div>

  <div class="action-buttons">
    <button id="screenshotBtn">Save Order</button>
    <button id="printBtn">Print Page</button>
  </div>

  <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

  <script>
    // Get DOM elements
    const screenshotBtn = document.getElementById('screenshotBtn');
    const printBtn = document.getElementById('printBtn');
    const previewModal = document.getElementById('previewModal');
    const closeModalBtn = document.getElementById('closeModal');
    const confirmUploadBtn = document.getElementById('confirmUpload');
    const cancelUploadBtn = document.getElementById('cancelUpload');
    const screenshotPreview = document.getElementById('screenshotPreview');
    const screenshotInput = document.getElementById('screenshotInput');
    const screenshotForm = document.getElementById('screenshotForm');
    const loadingOverlay = document.getElementById('loadingOverlay');
    const captureContainer = document.getElementById('captureContainer');

    // Global variable to store the captured image data
    let capturedImageData = null;

    // Screenshot button click handler
    screenshotBtn.addEventListener('click', function() {
      showLoading(true);

      const element = document.getElementById('captureContainer');

      // Get the input value
      const refInput = document.querySelector('.ref_number');
      const refValue = refInput.value;

      // Store the value in data attribute for html2canvas
      refInput.setAttribute('data-value', refValue);

      // Temporarily hide action buttons for clean screenshot
      const actionButtons = document.querySelector('.action-buttons');
      actionButtons.style.display = 'none';

      // Add screenshot mode class to show borders
      captureContainer.classList.add('screenshot-mode');

      html2canvas(element, {
        scale: 2,
        useCORS: true,
        logging: false,
        backgroundColor: '#ffffff',
        allowTaint: true,
        onclone: function(clonedDoc) {
          // Remove any unwanted elements in the cloned document
          const clonedButtons = clonedDoc.querySelector('.action-buttons');
          if (clonedButtons) {
            clonedButtons.style.display = 'none';
          }

          // Add screenshot mode class to cloned document
          const clonedContainer = clonedDoc.getElementById('captureContainer');
          if (clonedContainer) {
            clonedContainer.classList.add('screenshot-mode');
          }

          // Handle the reference number input in cloned document
          const clonedInput = clonedDoc.querySelector('.ref_number');
          if (clonedInput) {
            // Get the stored value from data attribute
            const storedValue = clonedInput.getAttribute('data-value');
            if (storedValue) {
              // Create a span element to replace the input
              const span = clonedDoc.createElement('span');
              span.textContent = storedValue;
              span.style.cssText = `
                display: inline-block;
                min-width: 70px;
                font-weight: 600;
                font-size: 14px;
                text-align: left;
                direction: ltr;
                color: #000;
                padding: 0 2px;
              `;

              // Replace input with span containing the value
              clonedInput.parentNode.replaceChild(span, clonedInput);
            } else {
              // If no value, show empty space with same width
              const span = clonedDoc.createElement('span');
              span.textContent = '';
              span.style.cssText = `
                display: inline-block;
                min-width: 70px;
                font-weight: 600;
                font-size: 14px;
                text-align: left;
                direction: ltr;
                color: #000;
                padding: 0 2px;
              `;
              clonedInput.parentNode.replaceChild(span, clonedInput);
            }
          }
        }
      }).then(canvas => {
        // Remove screenshot mode class
        captureContainer.classList.remove('screenshot-mode');

        // Restore action buttons
        actionButtons.style.display = 'flex';

        capturedImageData = canvas.toDataURL('image/png');

        // Show the image in preview modal
        screenshotPreview.src = capturedImageData;

        // Show the modal
        previewModal.style.display = 'block';
        document.body.style.overflow = 'hidden';

        showLoading(false);
      }).catch(error => {
        console.error('Error capturing screenshot:', error);
        captureContainer.classList.remove('screenshot-mode');
        actionButtons.style.display = 'flex';
        showLoading(false);
        alert('اسکرین شاٹ لینے میں خرابی آئی ہے۔ براہ کرم دوبارہ کوشش کریں۔');
      });
    });

    // Print button click handler
    printBtn.addEventListener('click', function() {
      document.querySelector('.bottom-footer').style.width = '53%';
      window.print();
      setTimeout(()=>{
      document.querySelector('.bottom-footer').style.width = '95%';

      },1000);
    });

    // Close modal button click handler
    closeModalBtn.addEventListener('click', function() {
      previewModal.style.display = 'none';
      document.body.style.overflow = 'auto';
      capturedImageData = null;
    });

    // Cancel upload button click handler
    cancelUploadBtn.addEventListener('click', function() {
      previewModal.style.display = 'none';
      document.body.style.overflow = 'auto';
      capturedImageData = null;

      // Show a message to user
      showNotification('آرڈر محفوظ کرنے کا عمل منسوخ کر دیا گیا ہے۔', 'warning');
    });

    // Confirm upload button click handler
    confirmUploadBtn.addEventListener('click', function() {
      if (!capturedImageData) {
        showNotification('کوئی تصویر موجود نہیں ہے۔', 'error');
        return;
      }

      // Show loading overlay
      showLoading(true);

      // Set the captured image data to hidden input
      screenshotInput.value = capturedImageData;

      // Close the modal
      previewModal.style.display = 'none';
      document.body.style.overflow = 'auto';

      // Submit the form after a short delay
      setTimeout(() => {
        screenshotForm.submit();
      }, 500);
    });

    // Close modal when clicking outside of it
    window.addEventListener('click', function(event) {
      if (event.target === previewModal) {
        previewModal.style.display = 'none';
        document.body.style.overflow = 'auto';
        capturedImageData = null;
      }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape' && previewModal.style.display === 'block') {
        previewModal.style.display = 'none';
        document.body.style.overflow = 'auto';
        capturedImageData = null;
      }
    });

    // Show/hide loading overlay
    function showLoading(show) {
      if (show) {
        loadingOverlay.style.display = 'flex';
      } else {
        loadingOverlay.style.display = 'none';
      }
    }

    // Show notification function
    function showNotification(message, type = 'info') {
      // Create notification element
      const notification = document.createElement('div');
      notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 25px;
        border-radius: 5px;
        color: white;
        font-weight: bold;
        z-index: 10001;
        animation: slideInRight 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        gap: 10px;
      `;

      // Set background color based on type
      if (type === 'success') {
        notification.style.backgroundColor = '#28a745';
      } else if (type === 'error') {
        notification.style.backgroundColor = '#dc3545';
      } else if (type === 'warning') {
        notification.style.backgroundColor = '#ffc107';
        notification.style.color = '#212529';
      } else {
        notification.style.backgroundColor = '#007bff';
      }

      // Add icon based on type
      let icon = 'info-circle';
      if (type === 'success') icon = 'check-circle';
      if (type === 'error') icon = 'exclamation-circle';
      if (type === 'warning') icon = 'exclamation-triangle';

      notification.innerHTML = `
        <i class="fas fa-${icon}"></i>
        <span>${message}</span>
      `;

      document.body.appendChild(notification);

      // Remove notification after 3 seconds
      setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => {
          document.body.removeChild(notification);
        }, 300);
      }, 3000);

      // Add CSS animations if not already present
      if (!document.querySelector('#notification-styles')) {
        const style = document.createElement('style');
        style.id = 'notification-styles';
        style.textContent = `
          @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
          }
          @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
          }
        `;
        document.head.appendChild(style);
      }
    }

    // Handle form submission to show loading
    screenshotForm.addEventListener('submit', function() {
      showLoading(true);
    });
  </script>
</body>
</html>
