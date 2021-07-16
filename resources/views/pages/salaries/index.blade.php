@extends("layouts.master")
@section("page-heading",$heading)
@section("title",$title)

@section("content")
    <section class="section">
        <div class="row" id="basic-table">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{$title}}</h4>
                    </div>
                    <div class="card-body">

                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="input-group mb-3">
                                    <label class="input-group-text"
                                        for="inputGroupSelect01">Bulan</label>
                                    <select class="form-select" id="month">
                                        <option selected>Pilih...</option>
                                        <option {{date('m')==1 ? "selected" : ""}} value="01">Januari</option>
                                        <option {{date('m')==2 ? "selected" : ""}} value="02">Febuari</option>
                                        <option {{date('m')==3 ? "selected" : ""}} value="03">Maret</option>
                                        <option {{date('m')==4 ? "selected" : ""}} value="04">April</option>
                                        <option {{date('m')==5 ? "selected" : ""}} value="05">Mei</option>
                                        <option {{date('m')==6 ? "selected" : ""}} value="06">Juni</option>
                                        <option {{date('m')==7 ? "selected" : ""}} value="07">Juli</option>
                                        <option {{date('m')==8 ? "selected" : ""}} value="08">Agustus</option>
                                        <option {{date('m')==9 ? "selected" : ""}} value="09">September</option>
                                        <option {{date('m')==10 ? "selected" : ""}} value="10">Oktober</option>
                                        <option {{date('m')==11 ? "selected" : ""}} value="11">November</option>
                                        <option {{date('m')==12 ? "selected" : ""}} value="12">Desember</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                {{-- <h6>Pilih Bulan</h6> --}}
                                <div class="input-group mb-3">
                                    <select class="form-select" id="year">
                                        <option selected>Pilih...</option>
                                        <option {{date('Y')==2021 ? "selected" : ""}} value="2021">2021</option>
                                        <option {{date('Y')==2022 ? "selected" : ""}} value="2022">2022</option>
                                        <option  {{date('Y')==2023 ? "selected" : ""}} value="2023">2023</option>
                                    </select>
                                    <label class="input-group-text"
                                        for="inputGroupSelect01">Tahun</label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                            <button type="button" class="btn btn-primary btn-filter">
                                Filter
                            </button>
                        </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="data-table" class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Karyawan</th>
                                        <th>Nama Karyawan</th>
                                        <th>Bulan</th>
                                        <th>Tahun</th>
                                        <th>Total Hari Kerja</th>
                                        <th>Total Jam Kerja</th>
                                        <th>Total Jam Lembur</th>
                                        <th>Total Tunjangan</th>
                                        <th>Total Gaji Lembur</th>
                                        <th>Total Gaji Keseluruhan</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody class="">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push("js")
    @include('layouts.plugins.datatables')
    <script>

        openModalAdd = () => {
            $('#modal-add').modal('show')
        }

        $('.btn-filter').click(function(){
            table.draw()
        })

        var table = $('#data-table').DataTable({
            pageLength: 10,
            lengthMenu: [10, 20],
            processing: true,
            serverSide: true,
            dom: "lBfrtip",
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel"></i> Excel',
                    className: 'btn btn-success',
                    title: 'Reporting Penggajian',
                    filename: 'Reporting-Penggajian-{{date('d F Y')}}',
                    footer: true
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf"></i> PDF',
                    titleAttr: 'PDF',
                    className: 'btn btn-danger',
                    title: 'Reporting Penggajian',
                    filename: 'Reporting-Penggajian-{{date('d F Y')}}',
                    customize: function (doc) {
                        doc.styles.tableHeader.alignment = 'left'; //giustifica a sinistra titoli colonne
                        doc.content[1].table.widths = [30, 30, 30,30,20,20,20,50,50,50,50,50]; //costringe le colonne ad occupare un dato spazio per gestire il baco del 100% width che non si concretizza mai
                    },
                }
            ],
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            ajax: {
                url: "/salaries/json",
                data:function(data){
                    data.month= $('#month').val()
                    data.year= $('#year').val()
                },
                dataSrc: function (res) {
                    if (res.code == 5500) {
                        return InternalServerEror()

                    } else {
                        return res.data
                    }
                },
                error: function () {
                    return InternalServerEror()
                }
            },
            columns: [
                {
                    "data": "DT_RowIndex",
                    orderable: false,
                    searchable: false
                },
                {
                    "data": "employee_code"
                },
                {
                    "data": "employee_name"
                },
                {
                    "data": "month_name"
                },
                {
                    "data": "year"
                },
                {
                    "data" : "t_days"
                },
                {
                    "data":"th"
                },
                {
                    "data":"th_overtime"
                },
                {
                    "data": "t_allowance"
                },
                {
                    "data":"t_s_overtime"
                },
                {
                    "data": "t_salary"
                },
            ],
            columnDefs: [
                {
                    targets: 11,
                    render: function (data, type, row, meta) {
                        var button = `

                    <a class="btn btn-sm btn-danger float-left" href="/salaries/slip_pdf?month=${$('#month').val()}&year=${$('#year').val()}&employee_code=${row.employee_code}" class="btn btn-primary"
                    target="_blank">Cetak PDF</a>
                    `
                        return button
                    }
                },],
        });

    </script>
@endpush
