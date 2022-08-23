<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>OPD Invoice | {{ $invoice->id }}</title>
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
            margin-bottom: 4px;
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
            padding: 4px;
        }
    </style>
</head>

<body>
    <div>
        <div style="position:absolute;">
            <img width="70pt" src="{{ public_path('img/logo.png') }}">
        </div>
        <div style="margin-left:120pt;">
            <div style="font-size: 12px; margin-bottom: 4pt; font-weight: bold;">Invoice OPD</div>
            <b>Date: </b>{{ Carbon\Carbon::parse($invoice->issued_at)->format('Y/m/d g:i:s a') }}<br />
            {{-- <b>Due date:
			</b>{{ Carbon\Carbon::parse($invoice->printed_at)->isoFormat('MMMM Do YYYY, h:mm:ss a') }}<br /> --}}
        </div>
    </div>
    <div style="margin-top: 24pt;">
        <div style="position:absolute; width:100pt;">
            <h4>Hospital Details:</h4>
            <div class="panel panel-default">
                <div class="panel-body">
                    {{ $invoice->id }}<br />
                    {{ $hospital->name }}<br />
                    {!! preg_replace("/,/", "<br />", $hospital->address) !!}<br />
                    {{ $hospital->contact }}<br />
                </div>
            </div>
        </div>
        <div style="margin-left: 130pt;">
            <h4>Patient Details:</h4>
            <div class="panel panel-default">
                <div class="panel-body">
                    {{ $patient->id }}<br /><br />
                    {{ $patient->first_name }}<br />
                    {{ $patient->age }} {{ Illuminate\Support\Str::plural('year', $patient->age) }}<br />
                    {{ config('constants.gender.' . $patient->gender) }}<br />
                    {{ $patient->contact }}<br />
                </div>
            </div>
        </div>
        <table class="table table-bordered" style="margin-top: 16pt;">
            <thead>
                <tr>
                    <th style="text-align: left;">Description</th>
                    <th style="text-align: right;">Amount (LKR)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: left;">Doctor Fee</td>
                    <td style="text-align: right;">{{ number_format($invoice->doctor_fee, 2, '.', ',') }}</td>
                </tr>
                @if ($invoice->drug_fee > 0)
                <tr>
                    <td style="text-align: left;">Drug Fee</td>
                    <td style="text-align: right;">{{ number_format($invoice->drug_fee, 2, '.', ',') }}</td>
                </tr>
                @endif
                <tr>
                    <td style="text-align: left;">Hospital Fee</td>
                    <td style="text-align: right;">{{ number_format($invoice->hospital_fee, 2, '.', ',') }}</td>
                </tr>
            </tbody>
        </table>
        <div style="clear:both; position:relative;">
            <div style="margin-left: 100pt;">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Gross Amount</td>
                            <td style="text-align: right;">{{ number_format($invoice->total, 2, '.', ',') }}</td>
                        </tr>
                        <tr>
                            <td><b>Net Amount</b></td>
                            <td style="text-align: right;"><b>{{ number_format($invoice->total, 2, '.', ',') }}</b>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div style="width:100%; text-align:left; margin-top: 8pt;">
            <h4>Doctor Details:</h4>
            @php
            $doctorUser = $doctor->user;
            @endphp
            <div>
                {{ $doctorUser->title }} {{ $doctorUser->first_name }} {{ $doctorUser->last_name }}<br />
                {{ $doctor->specialty->name }}<br />
                *{{ $doctor->note }}<br />
            </div>
        </div>
        <div style="width:100%; text-align:center; margin-top: 12pt;">
            Your health is our priority<br>
            Powered by AyuboHealth
        </div>
    </div>
</body>

</html>