<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Daily Cash In Hand</title>
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
        /* margin: 10px; */
    }

    th,
    td {
        font-size: 9px;
    }

    .panel {
        background-color: #fff;
        border: 1px solid transparent;
        border-radius: 4pt;
    }

    .panel-default {
        border-color: #ddd;
    }

    .panel-body {
        padding: 2pt;
    }

    table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 0pt;
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
        border: 1pt solid #ddd;
        padding: 4pt;
    }
    </style>
</head>

<body>
    <div style="margin-bottom: 12pt;">
        <div style="position:absolute;">
            <img width="70pt" src="{{ public_path('img/logo.png') }}">
        </div>
        <div style="margin-left:120pt;">
            <div style="font-size: 12px; margin-bottom: 4pt; font-weight: bold;">Daily Cash Report</div>
            <b>Date: </b>{{ Carbon\Carbon::now()->isoFormat('MMMM Do YYYY, h:mm:ss a') }}<br />
        </div>
    </div>
    <div style="margin-top: 24pt;">
        <div style="position:absolute; width:100pt;">
            <h4>Hospital Details:</h4>
            <div class="panel panel-default">
                <div class="panel-body">
                    {{ $hospital->name }}<br />
                    {!! preg_replace("/,/", "<br />", $hospital->address) !!}<br />
                </div>
            </div>
        </div>
        <div style="margin-left: 130pt;">
            <h4>Employee Details:</h4>
            <div class="panel panel-default">
                <div class="panel-body">
                    {{ $employee->username }}<br />
                    {{ $employee->first_name . " " . $employee->last_name }}<br />
                    {{ $employee->contact }}<br />
                </div>
            </div>
        </div>
    </div>
    <br>
    <table class="table table-bordered" style="margin-top: 20pt;">
        <tbody>
            <tr>
                <td style="text-align: left;">Cash in hand</td>
                <td style="text-align: right;">{{number_format( $cashInHand , 2, '.', ',')}}</td>
            </tr>
            <tr>
                <td style="text-align: left;">Cash Reversed</td>
                <td style="text-align: right;">({{number_format( $cashReversed , 2, '.', ',')}})</td>
            </tr>
            <tr>
                <td style="text-align: left;">Card transactions</td>
                <td style="text-align: right;">{{number_format( $cashInCards , 2, '.', ',')}}</td>
            </tr>
            <tr>
                <td style="text-align: left;">Card Reversed</td>
                <td style="text-align: right;">({{number_format( $cardReversed , 2, '.', ',')}})</td>
            </tr>
            <tr>
                <td style="text-align: left;"><b>Total transaction amount</b></td>
                <td style="text-align: right;"><b>LKR
                        {{number_format( ($cashInCards + $cashInHand - $cashReversed - $cardReversed) , 2, '.', ',')}}</b>
                </td>
            </tr>
        </tbody>
    </table>
    <br />
    <div style="width:100%; text-align:center;">
        - Powered by AyuboHHealth -
    </div>
</body>

</html>