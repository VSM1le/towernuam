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
            font-size: 16px;
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
            line-height: 10px;
        }
        .border-bottom{
            border-collapse: collapse;
            border-bottom: 1px solid #000;
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
                        รายงานสัญญาการเช่า
                    </p>
                </td>
                <td class="blank-column" style="vertical-align : top">
                </td>
            </tr>
        </table> 
        <table style="margin-bottom: 10px">
            <tr>
                <td>
                    <p class="desc">Report Date: {{$reportDate}} </p>
                </td>
            </tr> 
            <tr>
                <td>
                    <p class="desc">Building : อาคารนวม</p>
                </td>

            </tr>
            <tr>
                <p class="desc">Customer Code : {{ $customer->cust_name_th }}</p>
            </tr>
        </table>
        @if (isset($customer->customercontract))
        <table class="content-table">
            <thead>
                <tr style="text-align: center;">
                    <th style="text-align: center;padding:10px; line-height:8px; border: 1px solid #000;border-top: none;">contract number</th>
                    <th style="text-align: center; padding:10px; line-height:8px;border: 1px solid #000;border-top: none;">real contract number</th>
                    <th style="text-align: center; padding:10px; line-height:8px;border: 1px solid #000;border-top: none;">begin contract</th>
                    <th style="text-align: center; padding:10px; line-height:8px;border: 1px solid #000;border-top: none;">end contract</th>
                    <th style="text-align: center; padding:10px; line-height:8px;border: 1px solid #000;border-top: none;">contract year</th>
                    <th style="text-align: center; padding:10px; line-height:8px;border: 1px solid #000;border-top: none;">Unit</th>
                    {{-- <th style="text-align: center; padding:10px; line-height:8px;border: 1px solid #000;border-top: none;">Price/unit</th> --}}
                    {{-- <th style="text-align: center; padding:10px; line-height:8px;border: 1px solid #000;border-top: none;">Amount</th> --}}
                </tr>
            </thead>
            <tbody style="border: 1px solid #000;">
                @foreach ($customer->customercontract as $contract)
                <tr style="">
                    <td class="td-border" style="text-align: center">{{ $contract->custr_contract_no}}</td>
                    <td class="td-border" style="text-align: center">{{ $contract->custr_contract_no_real}}</td>
                    <td class="td-border" style="text-align: center">{{ $contract->custr_begin_date2}}</td>
                    <td class="td-border" style="text-align: center">{{ $contract->custr_end_date2}}</td>
                    <td class="td-border" style="text-align: center">{{ $contract->custr_contract_year}}</td>
                    <td class="td-border" style="text-align: center; word-wrap: break-word; white-space: normal;">
                        {{ $contract->custr_unit }}
                    </td>
                    {{-- <td class="td-border" style="text-align: right">{{ number_format($bill->price_unit,2,'.',',') }}</td> --}}
                    {{-- <td class="td-border" style="text-align: right">{{ number_format($bill->amt,2,'.',',') }}</td> --}}
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div> 
</body>
</html>