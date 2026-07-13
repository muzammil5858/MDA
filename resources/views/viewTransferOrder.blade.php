<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>A4 Image Print</title>
<style>
/* ===============================
   BROWSER BACKGROUND & CENTERING
================================ */
body {
    margin: 0;
    padding: 20px;
    background-color: #f5f5f5;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    font-family: Arial, sans-serif;
}

/* ===============================
   A4 PAGE CONTAINER (WITH SHADOW)
================================ */
.a4-container {
    width: 210mm;
    height: 297mm;
    margin: 0 auto;
    background: white;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    border-radius: 2px;
    overflow: hidden;
    position: relative;
    /* Optional: adds a subtle border to mimic paper edge */
    border: 1px solid #e0e0e0;
}

/* ===============================
   PAGE MARGINS INSIDE A4
================================ */
.print-page {
    width: 100%;
    height: 100%;
    padding: 15mm; /* Optional inner margin */
    box-sizing: border-box;
    /* display: flex; */
    /* justify-content: center; */
    /* align-items: center; */
    background: white;
}

/* ===============================
   IMAGE STYLING
================================ */
.print-page img {
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
    object-fit: contain;
    display: block;
    border-radius: 1px;
}

/* ===============================
   A4 PAGE SIZE FOR PRINT
================================ */
@page {
    size: A4;
    margin: 0;
}

/* ===============================
   PRINT VISIBILITY & RESET
================================ */
@media print {
    body {
        background: none;
        padding: 0;
        margin: 0;
    }

    .a4-container {
        box-shadow: none;
        border: none;
        border-radius: 0;
        margin: 0;
        width: 210mm;
        height: 297mm;
    }

    .print-page {
        padding: 0;
    }

    /* Hide everything except the A4 content */
    body * {
        visibility: hidden;
    }

    .a4-container,
    .a4-container * {
        visibility: visible;
    }
}

/* ===============================
   MEDIA QUERY FOR SCREEN PREVIEW
================================ */
@media screen and (max-width: 230mm) {
    body {
        padding: 10px;
    }
    
    .a4-container {
        transform: scale(0.95);
    }
}

@media screen and (max-width: 210mm) {
    .a4-container {
        transform: scale(0.85);
    }
}
</style>
</head>

<body>


<!-- ===============================
     CENTERED A4 PAGE WITH SHADOW
================================ -->
<div class="a4-container">
    <div class="print-page">
        <img id="printImage" src="{{asset('/'.$document->file_path)}}" alt="A4 Screenshot">
    </div>
</div>

<!-- ===============================
     PRINT SCRIPT
================================ -->
<script>
    // OPTIONAL: Auto print on load
    window.onload = function () {
        // Comment out the next line if you don't want auto-print
        // window.print();
    };
</script>

</body>
</html>