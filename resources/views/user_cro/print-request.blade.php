


<!doctype html>
<html lang="en">
    <head>
        <style>
            table, td, th {
            border: 1px solid black;
            }

            table {
            width: 100%;
            border-collapse: collapse;
            }    
        </style>
    </head>
    <body data-topbar="dark" data-layout="horizontal">
        <div style="font-family:Arial, Helvetica, sans-serif">
            <center style="font-size: 12px;">{{ $agency->name }}</center>
            <center style="font-size: 14px;"><b>REGIONAL STANDARDS AND TESTING LABORATORIES</b></center>
            <center style="font-size: 12px;">{{ $agency->mainaddress()->address }}, {{ $agency->mainaddress()->municipality->name }} </center>
            <center style="font-size: 10px;">Contact No. (062) 991-1024, (062) 992-1114</center>
            <br>
            <center><b>Request for {{ $agency->acronym }} RSTL Services</b></center>
            <br>

            <table>
                <tr>
                    <td >
                        aw
                    </td>
                    <td>
                        ew
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
