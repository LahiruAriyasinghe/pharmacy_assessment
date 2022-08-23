<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <title>Pharmacy Invoice | {{ $invoice->id }}</title>
    <style>
    @page {
        margin: 0pt;
    }

    body {
        margin: 20pt;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    p,
    span,
    div {
        font-size: 10px;
        font-weight: normal;
        font-family: 'courier';
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        padding: 0px;
        margin: 10px;
    }

    th,
    td {
        font-size: 10px;
    }

    .panel {
        margin-bottom: 5px;
        background-color: #fff;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .panel-default {
        border-color: #ddd;
    }

    .panel-body {
        padding: 5px;
    }

    table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 0px;
        border-spacing: 0;
        border-collapse: collapse;
        background-color: transparent;
    }

    thead {
        text-align: left;
        display: table-header-group;
        vertical-align: middle;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 2px;
    }
    </style>
</head>

<body>
    <div>
        <div style="position:absolute;">
            <img width="70pt" src="{{ public_path('img/logo.png') }}">
        </div>
        <div style="margin-left:120pt;">
            <div style="font-size: 12px; margin-bottom: 4pt; font-weight: bold;">Invoice Pharmacy</div>
            <b>Date: </b>{{ Carbon\Carbon::parse($invoice->issued_at)->format('Y/m/d g:i:s a') }}<br /><br>
            <b>Address: </b>{!! $hospital->address!!}<br />
            <b>Tel: </b>{{ $hospital->contact }}<br />
            <b>Invoice: </b>{{ $invoice->id }}<br />
        </div>
    </div>
    <div style="margin-top: 24pt;">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="text-align: left;">#</th>
                    <th style="text-align: left;">ITEM DESCRIPTION</th>
                    <th style="text-align: right;">QTY</th>
                    <th style="text-align: right;">AMOUNT (LKR)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $key => $report)

                <tr>
                    <td style="text-align: left;">{{ $key + 1 }}</td>
                    <td style="text-align: left;">{{ $report->name }}</td>
                    <td style="text-align: right;">{{ $report->quantity }}</td>
                    <td style="text-align: right;">Rs. {{ number_format( $report->price, 2, '.', ',') }}</td>
                </tr>

                @endforeach

            </tbody>
        </table>
        <br>
        <div style="clear:both; position:relative;">
            <div style="margin-left: 100pt;">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Gross Amount</td>
                            <td style="text-align: right;">Rs. {{ number_format($invoice->total, 2, '.', ',') }}</td>
                        </tr>
                        <tr>
                            <td><b>Net Amount</b></td>
                            <td style="text-align: right;"><b>Rs. {{ number_format($invoice->total, 2, '.', ',') }}</b>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div style="width:100%; text-align:center; margin:20pt 0 0 0; color: #444;">
            - THANK YOU FOR PURCHASING FROM US -
        </div>
        <div style="margin-top: 4pt;text-align: center;">Powered by AyuboHealth</div>
    </div>



</body>

</html>