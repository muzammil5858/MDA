<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Request Submitted</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>
<body style="font-family: Arial, sans-serif; padding: 40px;">
    <h2>Request Submitted</h2>
    <p>Your request has been successfully submitted.</p>
    <p>Please visit our office on <strong>10th November 2025</strong> for verification and further processing.</p>

    <button onclick="downloadPDF()">Download PDF</button>

    <script>

    function downloadPDF(customDate = "10 November 2025") {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({
            orientation: "portrait",
            unit: "pt",
            format: "a4"
        });

        // Set font size and style
        doc.setFont("helvetica", "normal");
        doc.setFontSize(12);

        // Title
        doc.text(" Request Confirmation", 40, 60);

        // Body text
        doc.text("Dear Applicant,", 40, 90);
        doc.text("Your request has been successfully submitted.", 40, 110);
        doc.text("Please visit our office on the following date for verification and further processing:", 40, 130);

        // Custom Date
        doc.setFont("helvetica", "bold");
        doc.text(`Date: ${customDate}`, 40, 150);

        // Footer
        doc.setFont("helvetica", "normal");
        doc.text("Please bring all required original documents for verification.", 40, 180);
        doc.text("Thank you for your cooperation.", 40, 200);
        doc.text("— Mangla Dam Housing Authority", 40, 230);

        // Save file
        doc.save("verification_notice.pdf");
    }
</script>


</body>
</html>
