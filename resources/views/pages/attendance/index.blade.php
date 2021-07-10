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
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="data-table" class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Karyawan</th>
                                        <th>Waktu Masuk</th>
                                        <th>Waktu Keluar</th>
                                        <th>Tanggal</th>
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
                    "data": "employee_name"
                },
                {
                    "data": "time_in"
                },
                {
                    "data": "time_out"
                },
                {
                    "data": "date"
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
