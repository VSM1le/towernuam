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
        .report-container {
            width: 100%;
            max-width: 800px;
            /* margin: auto; */
            margin-bottom: none;
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
        .desc {
            font-size: 16px
        }
        .company-details {
            padding: 10px 5px;
        }
        /* .company-details h2, .company-details h4, .company-details p {
            margin: 5px 0;
        } */
        .invoice-details {
            text-align: center;
            margin: 5px 0;
        }
        .content-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
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
        .td-border{
            border-collapse: collapse;
            border: 1px solid #000;
            padding: 1px 
        }
         .adjacent-table {
            width: 100%;
            border: 1px solid #000;
            border-top: none;
            border-collapse: collapse;
            margin-top: -20px; /* Adjusts overlap of the borders */
        }
         .adjacent-table2 {
            width: 100%;
            border: 1px solid #000;
            border-top: none;
            border-collapse: collapse;
            margin-top: 0px; /* Adjusts overlap of the borders */
        }
         .cancel-overlay {
            position: fixed; /* Fixed position to cover the entire viewport */
            top: 250;
            left: 0;
            width: 100%;
            height: 100%;
            color: rgba(255, 0, 0); /* Red color for the text */
            opacity:0.8;
            font-size: 10em;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            z-index: 9999; /* Ensure it appears above all other content */
            pointer-events: none; /* Allow interaction with underlying content */
        } 
    </style>
</head>
<body>
    <div class="report-container">
         <table class="header" style="padding-bottom:15px">
            <tr>
                <td style="vertical-align: top; ">
                    <img style="margin-left:30px" src="{{ asset('/nuam.jpg') }}" alt="Company Logo">
                </td>
                <td class="company-details" style="vertical-align: top;padding-right:100px">
                    <p style="padding-right:10px;text-align:center; margin: 0px; font-weight: bold; font-size:28px;line-height:19px;">บริษัท นวม จำกัด</p>
                    <p style="text-align:center; margin: 0px; font-weight: bold; font-size:28px;line-height:19px;">
                        รายงานการใช้ไอเย็นล่วงเวลา 
                    </p>
                </td>
                <td class="blank-column" style="vertical-align : top">
                    <p><span class="page-number">page 1/1</span></p>
                </td>
            </tr>
        </table> 
        <table style="margin-bottom: 10px">
            <tr>
                <td>
                    <p class="desc">Due Date : </p>
                </td>
            </tr> 
            <tr>
                <td>
                    <p class="desc">Building :</p>
                </td>

            </tr>
            <tr>
                <p class="desc">Customer Code :</p>
            </tr>
        </table>
        <table class="content-table">
                <thead>
                <tr style="text-align: center;">
                    <th style="text-align: center;padding:10px; line-height:8px; border: 1px solid #000;border-top: none;">Transaction Date</th>
                    <th style="text-align: center; padding:10px; line-height:8px;border: 1px solid #000;border-top: none;">Unit</th>
                    <th style="text-align: center; padding:10px; line-height:8px;border: 1px solid #000;border-top: none;">Unit Air</th>
                    <th style="text-align: center; padding:10px; line-height:8px;border: 1px solid #000;border-top: none;">Open</th>
                    <th style="text-align: center; padding:10px; line-height:8px;border: 1px solid #000;border-top: none;">Close</th>
                    <th style="text-align: center; padding:10px; line-height:8px;border: 1px solid #000;border-top: none;">Hours of use</th>
                    <th style="text-align: center; padding:10px; line-height:8px;border: 1px solid #000;border-top: none;">Price/Hr</th>
                    <th style="text-align: center; padding:10px; line-height:8px;border: 1px solid #000;border-top: none;">Amount</th>
                </tr>
            </thead>
            <tbody style="border: 1px solid #000;">
                <tr style="">
                    <td class="td-border">test</td>
                    <td class="td-border">test</td>
                    <td class="td-border">test</td>
                    <td class="td-border">test</td>
                    <td class="td-border">test</td>
                    <td class="td-border">test</td>
                    <td class="td-border">test</td>
                    <td class="td-border">test</td>
                </tr>
                <tr>
                    <td class="td-border">test</td>
                    <td class="td-border">test</td>
                    <td class="td-border">test</td>
                    <td class="td-border">test</td>
                    <td class="td-border">test</td>
                    <td class="td-border">test</td>
                    <td class="td-border">test</td>
                    <td class="td-border">test</td>
                </tr>


            </tbody>
        </table>
    </div> 
</body>
</html>