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
                        <button onclick="openModalAdd()" type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#modal-add">
                            Tambah
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="input-group mb-3">
                                    <label class="input-group-text"
                                        for="inputGroupSelect01">Bulan</label>
                                    <select class="form-select" id="inputGroupSelect01">
                                        <option selected>Pilih...</option>
                                        <option value="01">Januari</option>
                                        <option value="02">Febuari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                {{-- <h6>Pilih Bulan</h6> --}}
                                <div class="input-group mb-3">
                                    <select class="form-select" id="inputGroupSelect01">
                                        <option selected>Pilih...</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                    </select>
                                    <label class="input-group-text"
                                        for="inputGroupSelect01">Tahun</label>
                                </div>
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
                                        <th>Total Gaji</th>
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

    @include("pages.attendance.components.modal-add")
@endsection

@push("js")
    @include('layouts.plugins.datatables')
    <script>

        openModalAdd = () => {
            $('#modal-add').modal('show')
        }

        var table = $('#data-table').DataTable({
            pageLength: 10,
            lengthMenu: [10, 20],
            processing: true,
            serverSide: true,
            ajax: {
                url: "/attendance/json",
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
                    "data": "month"
                },
                {
                    "data": "year"
                },
                {
                    "data": "total_salary"
                },
            ],
            columnDefs: [
                {
                    targets: 4,
                    // render: function (data, type, row, meta) {
                    //     var button = `

                    // <button onclick="editData('` + row.id + `')" class="btn btn-sm btn-warning">
                    // <i class="fa fa-edit"></i>
                    // Edit</button>
                    // <button onclick="deleteData('` + row.id + `')" class="btn btn-sm btn-danger">
                    // <i class="fa fa-trash"></i>
                    // Delete</button>
                    // `
                    //     return button
                    // }
                },],
        });

    </script>
@endpush
