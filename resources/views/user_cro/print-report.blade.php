


<!doctype html>
<html lang="en">
    <head>
        <style>
            table, td, th {
            border: .8px solid black;
            text-align: center;
            }

            table {
            width: 100%;
            border-collapse: collapse;
            }    
        </style>
    </head>
    <body data-topbar="dark" data-layout="horizontal">
        <div style="font-family:Arial, Helvetica, sans-serif">
            <center style="font-size: 10px;">{{ $agency->name }}</center>
            <center style="font-size: 12px;"><b>REGIONAL STANDARDS AND TESTING LABORATORIES</b></center>
            <center style="font-size: 10px;">{{ $agency->mainaddress()->address }}, {{ $agency->mainaddress()->municipality->name }} </center>
            <center style="font-size: 9px;">Contact No. (062) 991-1024, (062) 992-1114</center>
            <br>
            <center><b>Accomplishment Report for {{ $agency->acronym }} </b></center>
            <br>

            <table class="table table-centered table-nowrap mb-0">
                <thead class="thead-light">
                    <tr class="text-center" style="font-size: 10px;">
                        <th>Month</th>
                        <th>No. of Requests</th>
                        <th>No. of Samples</th>
                        <th>No. of Analyses</th>
                        <th>Gratis</th>
                        <th>Discount</th>
                        <th>Gross</th>
                        <th>Income Generated</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($dataset as $data)
                    <tr class="text-center" style="font-size: 10px;">
                        <td>{{$data['month']}}</td>
                        <td>{{$data['requests']}}</td>
                        <td>{{$data['samples']}}</td>
                        <td>{{$data['analysis']}}</td>
                        <td>{{$data['gratis']}}</td>
                        <td>{{$data['discount']}}</td>
                        <td>{{$data['gross']}}</td>
                        <td>{{$data['income']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </body>
</html>
