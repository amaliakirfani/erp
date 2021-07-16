<!DOCTYPE html>
<html>

<head>
    <title>Slip Gaji Karyawan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

    <div class="container">
        <center>
            <h4>Slip Gaji Karyawan</h4>
            <h5><a target="_blank" href="https://www.malasngoding.com/membuat-laporan-…n-dompdf-laravel/">Perusahaan Kontraktor</a></h5>
        </center>
        <br><br>
        <p><b>Kode Karyawan</b> : {{$model[0]->employee_code}}</p>
        <p><b>Nama Karyawan</b> : {{$model[0]->employee_name}}</p>
        <p><b>Jabatan</b>       : {{$model[0]->jabatan_name}}</p>
        <p><b>Divisi</b>        : {{$model[0]->divisi_name}}</p>
        <p><b>Tahun</b>         : {{$model[0]->year}}</p>
        <p><b>Bulan</b>         : {{$model[0]->month_name}}</p>
        <br>
        <center>
            <p>Detail Gaji</p>
        </center>
        <table class='table table-bordered'>
            <thead>
                <tr>
                    <th>Gaji Pokok</th>
                    <th>Gaji Lembur</th>
                    <th>Tunjangan Per Hari</th>
                    <th>Total Hari Kerja</th>
                    <th>Total Jam Kerja</th>
                    <th>Total Jam Lembur</th>
                </tr>
            </thead>
            <tbody>

                @foreach($model as $item)
                <tr>
                    <td>Rp {{number_format($item->sallary_per_hour)}}</td>
                    <td>Rp {{number_format($item->sallary_overtime)}}</td>
                    <td>Rp {{number_format($item->allowance)}}</td>
                    <td>{{$item->t_days}}</td>
                    <td>{{$item->th}}</td>
                    <td>{{$item->th_overtime}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <p><b>Total Gaji Pokok</b>     : Rp {{number_format($model[0]->t_salary_per_hour)}}</p>
        <p><b>Total Tunjangan</b>     : Rp {{number_format($model[0]->t_allowance)}}</p>
        <p><b>Total Gaji Lembur</b>    : Rp {{number_format($model[0]->t_s_overtime)}}</p>
        <p><b>Total Gaji Keseluruhan</b>    : Rp {{number_format($model[0]->t_salary)}}</p>
    </div>
</body>

</html>
