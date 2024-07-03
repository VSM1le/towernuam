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
        body {
            font-family: 'THSarabunNew';
            margin: auto;
            padding: 20px;
        }
        .invoice-container {
            width: 100%;
            max-width: 800px;
            margin: auto;
            border: 1px solid #000000;
            box-shadow: 0 0 10px rgb(0, 0, 0);
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
            margin: 20px 0;
        }
        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .content-table th, .content-table td {
            border: 1px solid #ddd;
            padding: 8px;
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
                    <p>Page: <span class="page-number"></span></p>
                </td>
            </tr>
        </table>
        <div class="invoice-details">
            <p style="margin: 0px"><strong>ใบแจ้งหนี้</strong></p>
            <p style="margin: 0px"><strong>COPY INVOICE</strong></p>
            <p style="margin: 0px"><strong>(สำเนา)</strong></p>
        </div>
        <table class="details-table">
            <tr>
                <td>
                    <p>ได้รับเงินจาก</p>
                    <p>Recieved&nbsp;From</p>
                </td>
                <td>
                    <p>N2323233</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>ที่อยู่</p>
                    <p>Address</p>
                </td>
                <td>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Natus at amet ipsum officiis molestiae velit!</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>วันที่</p>
                    <p>Date</p>
                </td>
                <td>
                    <p>12/02/2222</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>เลขที่ใบแจ้งนี้</p>
                    <p>No.</p>
                </td>
                <td>
                    <p>OPRV AS23120029</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>กำหนดชำระวันที่</p>
                    <p>DUE DATE</p>
                </td>
                <td>
                    <p>1501</p>
                </td>
            </tr>
        </table>
        <table class="content-table">
            <thead>
                <tr>
                    <th>รายการ</th>
                    <th>จำนวนเงิน</th>
                    <th>จำนวนเงิน</th>
                    <th>ภาษีมูลค่าเพิ่ม</th>
                    <th>จำนวนเงินสุทธิ</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Row 1</td>
                    <td>Row 1</td>
                    <td>Row 1</td>
                    <td>Row 1</td>
                    <td>Row 1</td>
                </tr>
                <tr>
                    <td>Row 1</td>
                    <td>Row 1</td>
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
