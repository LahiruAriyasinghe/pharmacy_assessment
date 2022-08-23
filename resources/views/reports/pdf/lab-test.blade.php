<!DOCTYPE html>
<html lang="en">
<!-- Bootstrap core CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<style>
    page {
        background: white;
        display: block;
        margin: 0 auto;
        font-family: 'courier';
        color: rgb(45, 73, 100);
    }

    page[size="A4"] {
        width: 21cm;
        /* height: 29.7cm; */
        /* avoid extra blank page  */
        height: 26cm;
    }

    .page-header-signature {
        display: flex;
        justify-content: space-between;
        margin-bottom: 16pt;
    }

    .confidential-text {
        font-size: 16pt;
        text-decoration: underline;
        color: #2D4964;
        margin-bottom: 4pt;
    }

    .address-text {
        font-size: 10pt;
    }

    .report-details {
        font-size: 10pt;
        margin-bottom: 12pt;
    }

    .bottom-line {
        position: fixed;
        bottom: 0;
        width: 100%;
    }

    .report-type {
        margin-top: 8pt;
        text-decoration: underline;
    }


    .report-info table {
        width: 100%;
    }

    .report-info table th {
        padding: 4pt 0pt;
        background-color: #eeeeee;
    }

    .report-info table tr td {
        padding: 2pt 0pt;
    }

    .sub-table-header {
        padding-top: 12pt !important;
        font-style: italic;
        font-weight: 800;
    }

    .report-end {
        text-align: center;
        margin: 16pt 0pt;
    }

    .bottom-seperator-line {
        background-color: #1ca0f4;
        height: 10px;
        bottom: 0;
        position: fixed;
    }

    .margin-zero {
        margin: unset !important;
    }
</style>

<body>
    <page size="A4" style="width: 100%;">
        <div class="page-header-signature">
            <div>
                <div class="confidential-text">CONFIDENTIAL LABORATORY REPORT</div>
                <div style="margin-bottom: 8pt;"><b>{{$reportCategory }}</b></div>
                <div class="row address-text">
                    <div class="col-xs-1">
                        <div>Address</div>
                        <div>Tel</div>
                    </div>
                    <div class="col-xs-10">
                        <div>: <span>{{ $hospital->address }}</span></div>
                        <div>: <span>{{ $hospital->contact }}</span></div>
                    </div>
                </div>
            </div>
            <div><img width="100pt" style="float: right;clear: both;" src="{{ public_path('img/logo.png') }}"></div>
        </div>

        <div class="report-details">
            <div class="row" style="margin-bottom: 2pt;">
                <div class="col-xs-6">
                    PATIENT NAME : <span><b>{{ $patient->title }}. {{ $patient->first_name }}
                            {{ $patient->last_name }}</b></span>
                </div>
                <div class="col-xs-6">
                    AGE : <span> {{ $patient->age }} Y</span>
                </div>
            </div>
            <div class="row" style="margin-bottom: 2pt;">
                <div class="col-xs-6">
                    SAMPLE COLLECTED DATE :
                    <span>{{ Carbon\Carbon::parse($invoice->issued_at)->format('Y/m/d g:i:s a') }}</span>
                </div>
                <div class="col-xs-6">
                    REPORT DATE : <span>{{ Carbon\Carbon::now()->format('Y/m/d g:i:s a') }}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    SAMPLE REF.NO : <span>{{$result->sample_no}}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    SERVICE REF.NO : <span>{{$result->invoice_lab_id}}</span>
                </div>
            </div>
            <div class="report-type"><b><span>{{$labReport->name}}</span></b></div>
        </div>
        <div class="report-info">
            <table>
                <tr>
                    <th class="table-header">TEST</th>
                    <th class="table-header">RESULT</th>
                    <th class="table-header">UNITS</th>
                    <th class="table-header">AB.COUNT</th>
                    <th class="table-header">REF.RANGE</th>
                </tr>
                @php
                $category = 0;
                @endphp
                @foreach ($result->result->data as $data)
                @if ($data->category_id != $category)
                @php
                $category = $data->category_id
                @endphp
                <tr>
                    <td class="sub-table-header">{{$data->category}}</td>
                </tr>
                @endif
                <tr>
                    <td>{{ $data->name }}</td>
                    <td>{{ isset($data->ranges) ? $data->result . ' ' . $data->ranges->condition : $data->result }}</td>
                    <td>{{ $data->unit}}</td>
                    <td></td>
                    <td>{{ isset($data->ranges) ? $data->ranges->range_min . " - " . $data->ranges->range_max : '' }}
                    </td>
                </tr>
                @endforeach
            </table>
        </div>

        @if ($result->result->note)

        <div style="margin-top: 12pt">
            Note : {{$result->result->note}}
        </div>

        @endif

        <div class="report-details" style="margin-top: 12pt">
            <div class="row" style="margin-bottom: 2pt;">
                <div class="col-xs-12">
                    APPROVED BY
                </div>
            </div>
            @if ($result->result->mlt)

            <div class="row" style="margin-bottom: 2pt;">
                <div class="col-xs-12">
                    {{$result->result->mlt}}
                </div>
            </div>
            <div class="row" style="margin-bottom: 2pt;">
                <div class="col-xs-12">
                    Medical Laboratory Technician
                </div>
            </div>

            @else

            <div class="row" style="margin-top: 48pt;">
            </div>

            @endif
        </div>
        <div class="report-end" style="margin-top: 12pt">- END OF REPORT -</div>
        <div class="bottom-seperator-line"></div>
    </page>
</body>

</html>