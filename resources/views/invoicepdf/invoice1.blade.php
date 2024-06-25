<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .invoice-container {
            width: 100%;
            max-width: 800px;
            margin: auto;
            /* padding: 20px; */
            border: 1px solid #ddd;
             box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header img {
            max-width: 100px;
            margin-left: 50px; /* Adjust the margin here to move the logo to the right */
        }
        .company-details {
            flex: 1;
            padding: 10px 20px;
            /* text-align: center; */
        }
        .company-details h2, .company-details h4, .company-details p {
            margin: 5px 0; /* Adjusted margins to reduce space between elements */
        }
        .blank-column {
            text-align: end;
            align-self: flex-start
        }
        .invoice-details, .customer-details {
            margin: 20px 0;
        }
        .invoice-details {
            text-align: center; /* Center align text content */
            margin: 20px 0;
        }
        .grid-container {
            display: grid;
            grid-template-columns: 1fr 1fr; /* Two columns of equal width */
             /* Gap between columns and rows */
        }
        .grid-container2 {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* 4 columns of equal width */
            gap: 0px; /* Gap between columns and rows */
            margin-bottom: 20px; /* Example margin between grid containers */
        }
        .column {
            border: 1px solid #ccc;
        }
        .row {
            border: 1px solid #ccc; /* Border for each row */
            padding: 10px;
        }
        .flex {
            display: flex;
            align-items: flex-start;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        p{
            font-size: 14px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .total {
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <img src="{{ asset('path/to/logo.png') }}" alt="Company Logo">
            <div class="company-details">
                <h2>บริษัท นวม จำกัด</h2>
                <h4>NUAM CO., LTD</h4>
                <p>185/2 ซอยสุขุมวิท 31 ถนนสุขุมวิท แขวงคลองตันเหนือ เขตวัฒนา กรุงเทพมหานคร</p>
                <p>185/2 Soi Sukhumvit 31 Rd. Nort Khlongton, Watthana, Bangkok, Thailand 10110</p>
                <p>Tel: 0-2264-2245-7 Fax: 0-2264-2248</p>
                <p>เลขประจำตัวผู้เสียภาษี 0105565185083&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สำนักงานใหญ่(Head Office)</p>
            </div>
            <div class="blank-column">
                <p>Page: <span class="page-number"></span></p>
            </div>
        </div>
        <div class="invoice-details align-items: center">
            <p><strong>สำเนาใบเสร็จรับเงิน/สำเนาใบกำกับภาษี</strong></p>
            <p><strong>COPY RECEIPT/TAX INVOICE</strong></p>
        </div>
         <div class="grid-container">
        <div class="column" style="width: 500px;">
            <div class="flex">
            <div style="width: 80px;">
                <p>ได้รับเงินจาก</p> 
                <p>Recieved&nbsp;From</p> 
            </div>
            <div style="margin-left: 50px;">
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Natus at amet ipsum officiis molestiae velit!</p>
            </div>
        </div>
         <div class="flex">
            <div style="width: 130px;">
                <p>ที่อยู่</p> 
                <p>Address</p> 
            </div>
            <div style="margin-left: 50px;">
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Natus at amet ipsum officiis molestiae velit!</p>
            </div>
        </div>
        </div>
        <div class="column">
            <div class="row">
                <!-- Content for the first row in the second column -->
                <p style="margin: 0; font-size: 14px;">เลขที่ใบเสร็จ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OPRV AS231120064</p>
                No.<br>
            </div>
            <div class="row">
            <p style="margin: 0; font-size: 14px;">วันที่&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;12/01/2222</p>
                Date.<br>
            </div>
            <div class="row">
                <p style="margin: 0; font-size: 14px;">แปลนเลขที่&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1501,1502</p>
                Plan No.<br>
            </div>
        </div>
    </div>
     <div class="grid-container2">
        <div class="grid-item">
            <div class="row">
                <p>Row 1</p>
            </div>
            <div class="row">
                <p>Row 1</p>
            </div>
            <div class="row">
                <p>Row 1</p>
            </div>
            
        </div>
        <div class="grid-item">
           
            <div class="row">
                <p>Row 1</p>
            </div>
            <div class="row">
                <p>Row 1</p>
            </div>
            <div class="row">
                <p>Row 1</p>
            </div>
        </div>
        <div class="grid-item">
            
            <div class="row">
                <p>Row 1</p>
            </div>
            <div class="row">
                <p>Row 1</p>
            </div>
            <div class="row">
                <p>Row 1</p>
            </div>
        </div>
        <div class="grid-item">
            
            <div class="row">
                <p>Row 1</p>
            </div>
            <div class="row">
                <p>Row 1</p>
            </div>
            <div class="row">
                <p>Row 1</p>
            </div>
        </div>
    </div> 
        <div class="footer">
            <p class="total">Total: 78979</p>
            <p>Thank you for your business!</p>
        </div>
    </div>
</body>
</html>