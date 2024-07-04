<!DOCTYPE html>
<html lang="en">
<head>
    {{-- <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> --}}
     <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
    <title>Invoice</title>
    <style>
       @font-face {
            font-family: 'THSarabunNew';
            src: url('{{ url('/fonts/THSarabunNew.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        body {
            font-family: 'THSarabunNew';
            margin: auto;
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
            grid-template-columns: 44% 14% 14% 14% 14%; /* 4 columns of equal width */
            gap: 0px; /* Gap between columns and rows */
        }
        .column {
            border: 1px solid #ccc;
        }
        .row {
            border: 1px solid #ccc; /* Border for each row */
        }
        .flex {
            display: flex;
            align-items: flex-start;
        }
         .checkbox-container {
            display: flex;
            align-items: center;
        }

        .checkbox-container input[type="checkbox"] {
            display: none; /* Hide the default checkbox */
        }

        .custom-checkbox {
            width: 20px;
            height: 20px;
            background-color: white;
            border: 2px solid #000;
            display: inline-block;
            position: relative;
        }
        .signature-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 1fr 1fr;
    width: 150px; /* Adjust overall grid width */
    height: 80px; /* Adjust overall grid height */
    margin-top: 10px; /* Add space from top if needed */
    border-collapse: collapse; /* Prevents double borders */
}

.signature-cell {
    border-collapse: collapse; /* Prevents double borders */
    border: 1px solid #000;
    justify-content: center;
    align-items: center;
    font-size: 12px; /* Adjust font size */
}
        table {
            width: 100%;
            border-collapse: collapse;
        }
        p{
            font-size: 14px;
            margin: 0px;
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
            <img src="{{ asset('/nuam.jpg') }}" alt="Company Logo">
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
            <p><strong>ใบแจ้งหนี้</strong></p>
            <p><strong>COPY INVOICE</strong></p>
            <p><strong>(สำเนา)</strong></p>
        </div>
         <div class="grid-container">
        <div class="column" style="width: 540px;">
             <div class="flex">
            <div style="width: 120px;">
                <p style="margin: 10px">ได้รับเงินจาก</p> 
            </div>
            <div style="margin-left: 50px;">
                <p style="margin: 10px">N2323233</p>
            </div>
            </div>

            <div class="flex">
            <div style="width: 120px;">
                <p style="margin: 10px">ได้รับเงินจาก</p> 
                <p style="margin: 10px">Recieved&nbsp;From</p> 
            </div>
            <div style="margin-left: 50px;">
                <p style="margin: 10px">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Natus at amet ipsum officiis molestiae velit!</p>
            </div>
        </div>
         <div class="flex">
            <div style="width: 175px;">
                <p style="margin: 10px">ที่อยู่</p> 
                <p style="margin: 10px">Address</p> 
            </div>
            <div style="margin-left: 50px;">
                <p style="margin: 10px">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Natus at amet ipsum officiis molestiae velit!</p>
            </div>
        </div>
        </div>
        <div class="column">
            <div class="row" style="display: flex; padding-bottom:5px;">
                <div style="width:35%;">
                    <p style="margin: 10px; font-size: 12px;">วันที่<br> Date </p>
                   
                </div>
               <div>
                <p style="padding-left: 10px; font-size:10px; margin:10px;">OPRV AS23120029</p>
               </div>
            </div>
            <div class="row" style="display: flex; padding-bottom:5px;">
                 <div style="width:35%;">
                    <p style="margin: 10px; font-size: 12px;">เลขที่ใบแจ้งนี้<br>No.</p>
                    
                </div>
               <div>
                <p style="padding-left: 10px; font-size:11px; margin:10px;">12/02/2222</p>
               </div>
            </div>
            <div class="row" style="display: flex;">
                 <div style="width:40%;">
                    <p style="margin: 10px; font-size: 12px;">กำหนดชำระวันที่<br>DUE DATE</p>
                </div>
               <div>
                <p style="padding-left: 14px; font-size:14px; margin:10px">1501</p>
               </div>
            </div>
        </div>
    </div>
     <div class="grid-container2">
        <div class="grid-item" >
            <div class="row" style="padding: 5px">
                <div  style="display: flex; padding: 4px; align-items: center; justify-content: center;">
                    <p style="margin: 0; padding-right: 10px; font-size:12px">รายการ</p>
                </div>
               <div  style="display: flex; padding: 4px; align-items: center; justify-content: center;">
                    <p style="margin: 0; font-size:11px"">Description</p>
                </div> 
            </div>
            <div class="row" style="height: 322px">
                <p>Row 1</p>
            </div>
              <div class="row" style="height: 30px">
                <p>Row 1</p>
            </div>
            
        </div>
        <div class="grid-item">
           
            <div class="row" style="padding: 5px">
                <div  style="display: flex; padding: 4px; align-items: center; justify-content: center;">
                    <p style="margin: 0; padding-right: 10px; font-size:12px">จำนวนเงิน</p>
                </div>
               <div  style="display: flex; padding: 4px; align-items: center; justify-content: center;">
                    <p style="margin: 0; font-size:11px"">Gross Amount</p>
                </div> 
            </div>
            <div class="row" style="height: 322px; text-align:right;">
                <p style="margin: 2px">Row 1</p>
            </div>
            <div class="row" style="height:30px">
                <p>Row 1</p>
            </div>
        </div>
        <div class="grid-item">
           
            <div class="row" style="padding: 5px">
                <div  style="display: flex; padding: 4px; align-items: center; justify-content: center;">
                    <p style="margin: 0; padding-right: 10px; font-size:12px">จำนวนเงิน</p>
                </div>
               <div  style="display: flex; padding: 4px; align-items: center; justify-content: center;">
                    <p style="margin: 0; font-size:11px"">Gross Amount</p>
                </div> 
            </div>
            <div class="row" style="height: 322px; text-align:right;">
                <p style="margin: 2px;">Row 1</p>
            </div>
            <div class="row" style="height:30px">
                <p>Row 1</p>
            </div>
        </div>
        <div class="grid-item">
            
            <div class="row" style="padding: 5px">
                <div  style="display: flex; padding: 4px; align-items: center; justify-content: center;">
                    <p style="margin: 0; padding-right: 10px; font-size:12px">ภาษีมูลค่าเพิ่ม</p>
                </div>
               <div  style="display: flex; padding: 4px; align-items: center; justify-content: center;">
                    <p style="margin: 0; font-size:11px">Value Added Tax</p>
                </div> 
            </div>
            <div class="row" style="height:322px; text-align:right;">
                <p style="margin: 2px;">Row 1</p>
            </div>
            <div class="row" style="height: 30px;">
                <p>Row 1</p>
            </div>
        </div>
        <div class="grid-item">
            
            <div class="row" style="padding: 5px">
                <div  style="display: flex; padding: 4px; align-items: center; justify-content: center;">
                    <p style="margin: 0; padding-right: 10px; font-size:12px">จำนวนเงินสุทธิ</p>
                </div>
               <div  style="display: flex; padding: 4px; align-items: center; justify-content: center;">
                    <p style="margin: 0; font-size:11px;">Net Amount</p>
                </div> 
            </div>
            <div class="row" style="height: 322px; text-align:right">
                <p style="margin: 2px">Row 1</p>
            </div>
            <div class="row" style="height: 30px">
                <p>Row 1</p>
            </div>
        </div>
    </div> 
        <div style="gap: 0px" >
            <div style="display:flex;">
                <div style="margin: 5px;">
                    <p>ชำระโดย</p>
                    <p>Payment of</p>
                </div>
                <div style="display:flex; justify-content:center; margin-left: 50px">
                     <div class="checkbox-container">
                        <input type="checkbox" id="checkbox">
                        <label for="checkbox" class="custom-checkbox"></label>
                    </div>
                    <div style="margin: 5px">
                        <p>เงินสด</p>
                        <p>Cash</p>
                    </div>
                    
                </div>
                     <div style="display:flex; justify-content:center; margin-left:100px">
                     <div class="checkbox-container">
                        <input type="checkbox" id="checkbox">
                        <label for="checkbox" class="custom-checkbox"></label>
                    </div>
                    <div style="margin: 5px;">
                        <p>เงินโอน</p>
                    </div>
                    <div style="margin: 5px; margin-left:100px;">
                        <p>100000</p>
                    </div>
                    
                </div> 
                
            </div>
            <div style="display:flex;">
                 <div style="display:flex; justify-content:center; margin-left: 130px">
                     <div class="checkbox-container">
                        <input type="checkbox" id="checkbox">
                        <label for="checkbox" class="custom-checkbox"></label>
                    </div>
                    <div style="margin: 5px">
                        <p>เข็คธนาคาร</p>
                        <p>Cheque Bank</p>
                    </div>
                    
                </div>
                  <div style="margin: 5px; margin-left:100px;">
                        <p>สาขา</p>
                        <p>Branch</p>
                    </div>
                      <div style="margin: 5px; margin-left:70px">
                        <p>เลขที่</p>
                        <p>No.</p>
                    </div>
                      <div style="margin: 5px; margin-left:70px">
                        <p>วันที่</p>
                        <p>Date</p>
                    </div>
                      <div style="margin: 5px; margin-left:70px">
                        <p>จำนวนเงิน</p>
                        <p>Amount</p>
                    </div>
            </div>
          <div style="display:flex;">
                 <div style="display:flex; justify-content:center; margin-left: 130px">
                     <div class="checkbox-container">
                        <input type="checkbox" id="checkbox">
                        <label for="checkbox" class="custom-checkbox"></label>
                    </div>
                    <div style="margin: 5px">
                        <p>เช็คหัก ณ ที่จ่าย</p>
                        <p>Withholding Tax</p>
                    </div>
                </div>
            </div>
        </div>
        <div style="display: flex; margin:5px">
            <div class="signature-grid">
                <div class="signature-cell">
                    <div style="display: flex; justify-content: center;">
                         <p>ผู้รับเงิน</p>
                    </div>
                    <div style="display: flex; justify-content: center;">
                    <p>Collector</p>
                    </div>
                </div>
                
                <div class="signature-cell">
                    <div style="display: flex; justify-content: center;">
                         <p>การเงิน</p>
                    </div>
                    <div style="display: flex; justify-content: center;">
                    <p>Cashier</p>
                    </div>
                </div>
                <div class="signature-cell"></div>
                <div class="signature-cell"></div>
            </div>
            <div style="margin: 5px; margin-top:15px;">
                <p style="font-size: 12px ">หมายเหตุ: ในกรณีชำระเป็น ใบเส็จรับเงินและใบกำกับภาษีฉบับนี้จะสมบูรณ์ต่อเมื่อบริษัทฯ ได้รับเงินตามเช็คแล้ว</p>
                <p style="font-size: 12px; margin-top:8px">REMARK: If payment is made by cheque. This receipt will be valid cheque has been cleared by the bank.</p>
            </div>
        </div>
    </div>
    <table class="details-table">
            <tr>
                <td>
                    <p>ชำระโดย</p>
                    <p>Payment of</p>
                </td>
                <td>
                    <input type="checkbox">
                    <p>เงินสด</p>
                    <p>Cash</p>
                </td>
                <td>
                    <input type="checkbox">
                    <p>เช็คธนาคาร</p>
                    <p>Cheque of Bank</p>
                </td>
                <td>
                    <input type="checkbox">
                    <p>เช็คธนาคาร</p>
                    <p>Cheque No.</p>
                </td>
            </tr>
        </table>
        <table class="details-table">
            <tr>
                <td>
                    <p>บาท(Baht) :</p>
                    <p>หมายเหตุ (Remark) :</p>
                    <p>฿23,232,323</p>
                </td>
                <td class="signature-cell">
                    <p>ในนาม</p>
                    <p>For</p>
                    <table class="signature-grid">
                        <tbody>
                            <tr>
                                <td class="signature-cell"> </td>
                            </tr>
                            <tr>
                                <td class="signature-cell">วันที่</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td class="signature-cell">
                    <p>ผู้รับเงิน</p>
                    <p>Receiver</p>
                    <table class="signature-grid">
                        <tbody>
                            <tr>
                                <td class="signature-cell"> </td>
                            </tr>
                            <tr>
                                <td class="signature-cell">วันที่</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
</body>
</html>