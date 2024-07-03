<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Invoice</title>
    <style>
         @font-face {
            font-family: 'THSarabunNew';
            src: url('{{ url('/fonts/THSarabunNew.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
          @font-face {
            font-family: 'THSarabunNew';
            src: url('{{ url('/fonts/THSarabunNew Bold.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: bold;
        }
          @font-face {
            font-family: 'THSarabunNew';
            src: url('{{ url('/fonts/THSarabunNew Italic.ttf') }}') format('truetype');
            font-weight: italic;
            font-style: normal;
        }
          @font-face {
            font-family: 'THSarabunNew';
            src: url('{{ url('/fonts/THSarabunNew BoldItalic.ttf') }}') format('truetype');
            font-weight: italic;
            font-style: bold;
        }
         @page {
            margin: 2px; /* Adjust this value as needed */
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
            /* border: 1px solid #000000; */
            /* box-shadow: 0 0 10px rgb(0, 0, 0); */
        }
        .header {
            width: 100%;
            margin-bottom: 0px;
        }
        .header img {
            max-width: 100px;
            margin-left: 50px;
        }
        .company-details {
            padding: 10px 20px;
        }
        .company-details h2, .company-details h4, .company-details p {
            margin: 5px 0;
        }
        .invoice-details {
            text-align: center;
            margin: 5px 0;
        }
        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .content-table th, .content-table td {
            padding: 4px;
        }
        .content-table th {
            text-align: left;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table th, .details-table td {
            padding: 8px;
            text-align: left;
        }
        .signature-grid {
            width: 150px;
            height: 80px;
            margin-top: 10px;
            border-collapse: collapse;
        }
        .signature-cell {
            border: 1px solid #000;
            text-align: center;
            vertical-align: middle;
            font-size: 12px;
        }
        p {
            font-size: 14px;
            margin: 0;
        }
        .total {
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <table class="header">
            <tr>
                <td>
                    <img src="{{ asset('/nuam.jpg') }}" alt="Company Logo">
                </td>
                <td class="company-details">
                    <h2 style="margin: 0px">บริษัท นวม จำกัด</h2>
                    <h4 style="margin: 0px">NUAM CO., LTD</h4>
                    <p style="margin: 0px">185/2 ซอยสุขุมวิท 31 ถนนสุขุมวิท แขวงคลองตันเหนือ เขตวัฒนา กรุงเทพมหานคร</p>
                    <p style="margin: 0px">185/2 Soi Sukhumvit 31 Rd. Nort Khlongton, Watthana, Bangkok, Thailand 10110</p>
                    <p style="margin: 0px">Tel: 0-2264-2245-7 Fax: 0-2264-2248</p>
                    <p style="margin: 0px">เลขประจำตัวผู้เสียภาษี 0105565185083&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สำนักงานใหญ่(Head Office)</p>
                </td>
                <td class="blank-column">
                    <p><span class="page-number"></span></p>
                </td>
            </tr>
        </table>
        <div class="invoice-details">
            <p style="margin: 0px"><strong>ใบแจ้งหนี้</strong></p>
            <p style="margin: 0px"><strong>COPY INVOICE</strong></p>
            <p style="margin: 0px"><strong>(สำเนา)</strong></p>
        </div>
        <table style="width:100%; border: 1px solid #000; border-collapse: collapse;">
            <tbody>
                <tr >
                    <td style="width:80%; vertical-align:top;">
                    <p style="font-size: 17px">เลขที่สัญญา&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;N2304005</p> 
                    <p style="font-size: 17px; margin:0px">ชื่อลูกต้า&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;บริษัท ลุฟท์ฮันซ่าวิสเซส (ไทยแลนด์) จำกัด </p>
                    </td>

                    <td style="height: 2px; border:1px solid #000; margin:0px; vertical-align:top">
                        <p style="font-size: 17px">วันที่</p>
                        <p style="font-size: 17px">Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;12/02/2024</p>
                    </td>
                </tr>
                <tr>
                    <td style="height:60px; vertical-align:top;">
                    <p style="font-size: 17px">ที่อยู่&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lorem ipsum dolor sit amet consectetur adipisic</p>   
                    <p style="font-size: 17px">Address&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lorem ipsum dolor sit amet.</p>   
                    </td>
                    <td style="vertical-align:top;width: 40%; border:1px solid #000; margin:0px;">
                        <p style="font-size: 17px">เลชที่ใบแจ้งนี้</p>
                        <p style="font-size: 17px">No.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ISA24080001</p>
                    </td>
                </tr>
                <tr>
                    <td style="height: 60px; vertical-align:top;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เลขประจำตัวผู้เสียภาษี&nbsp;092341234234&nbsp;banch 0002</td>
                    <td style="vertical-align:top; width: 40%; border:1px solid #000; margin:0px;">
                        <p style="font-size: 17px">กำหนดชำระภายในวันที่</p>
                       <p style="font-size: 17px;">DUE DATE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;12/02/2024</p> 
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="content-table" style="border: 1px solid #000">
            <thead>
                <tr style="text-align: center;">
                    <th style="text-align: center;padding:10px; line-height:8px; border: 1px solid #000;border-top: none;">รายการ<br style="margin: 0">Description</th>
                    <th style="text-align: center; padding:10px; line-height:8px;border: 1px solid #000;border-top: none;">ประจำเดือน<br>Period</th>
                    <th style="text-align: center; padding:10px; line-height:8px;border: 1px solid #000;border-top: none;">จำนวนเงิน<br>Gross Amount</th>
                    <th style="text-align: center; padding:10px; line-height:8px;border: 1px solid #000;border-top: none;">ภาษีมูลค่าเพิ่ม<br>Value Added Tax</th>
                    <th style="text-align: center; padding:10px; line-height:8px;border: 1px solid #000;border-top: none;">จำนวนเงินสุทธิ<br>Net Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr style="height: 300px;">
                    <td style="height:400px;width: 280px; border-bottom: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;vertical-align:top; border-collapse: collapse;">
                        @foreach ( $Invoices->invoicedetail as $invoice )
                            <p>{{ $invoice->invd_product_name }}</p>
                        @endforeach
                    </td>
                    <td style="width: 140px; text-align: center; border-bottom: 1px solid #000;border-right:1px solid #000;vertical-align:top;">
                        @foreach ( $Invoices->invoicedetail as $invoice )
                            <p>{{ $invoice->invd_period }}</p>
                        @endforeach
                       </td>
                    <td style="width:100px;text-align: right; border-bottom: 1px solid #000;border-right:1px solid #000;vertical-align:top;">
                         @foreach ( $Invoices->invoicedetail as $invoice )
                            <p >{{ number_format($invoice->invd_amt,2,'.',',') }}</p>
                        @endforeach
                    </td>
                    <td style="text-align: right; border-bottom: 1px solid #000;border-right:1px solid #000;vertical-align:top;">
                         @foreach ( $Invoices->invoicedetail as $invoice )
                            <p >{{ number_format($invoice->invd_vat_amt,2,'.',',')}}</p>
                        @endforeach
                    </td>
                    <td style="text-align: right; border-bottom: 1px solid #000;border-right:1px solid #000;vertical-align:top;">
                         @foreach ( $Invoices->invoicedetail as $invoice )
                            <p >{{ number_format($invoice->invd_net_amt,2,'.',',')}}</p>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>Row 1</td>
                    <td style="border-left: none">Row 1</td>
                    <td>Row 1</td>
                    <td>Row 1</td>
                    <td>Row 1</td>
                </tr>
            </tbody>
        </table>
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
    </div>
</body>
</html>
