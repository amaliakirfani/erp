<div class="modal" id="modal-add" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah {{$title}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-input">
                    @csrf
                    <div class="row">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Nama Karyawan</label>
                            <select name="employee_code" class="form-control">
                                <option>--pilih--</option>
                                    @foreach ($karyawan as $item)
                                  <option value="{{$item->employee_code}}">{{$item->employee_name}}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Pilih Bulan</label>
                            <input readonly value="{{date('m')}}" id="month"
                            style="background-color: #FFFFFF; border-radius: 10px" class="monthpicker form-control"
                            type="text" name="month">
                        </div>
                        <div class="form-group">
                            <label>Pilih Tahun</label>
                            <input value="{{date('Y')}}" id="year" readonly style="background-color: #FFFFFF; border-radius: 10px" class="yearpicker form-control"
                            type="text" name="year">
                        </div>
                        <div class="col-sm-12">
                            <label for="col-form-label">Tanggal</label>
                            <input type="date" name="date" class="form-control"
                                id="exampleInputPassword1">
                        </div>
                    </div>
                </form>
            </div>
            <div style="border-top: 0px" class="modal-footer">
                <button type="submit" form="form-input" class="btn-submit btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push("js")
    <script>
        var form = $("#form-input").validate({
            errorClass: "is-invalid",
            errorElement: 'invalid-feedback',
            ignore: [],
            rules: {
                name: {
                    required: true
                },
            },
            submitHandler: function (form, e) {
                e.preventDefault()
                $.ajax({
                    url: "/attendance/create/json",
                    method: "POST",
                    data: $('#form-input').serialize(),
                    beforeSend: function () {
                        LoaderSubmit()
                    }
                }).then(res => {
                    if (res.code == 2200) {
                        $('#modal-add').modal('hide')
                        table.draw()
                        return SuccessResponse(res.message)
                    } else {
                        return BadResponse(res.message)
                    }
                }).catch(err => {
                    if (err.status == 422) {
                        return BadResponse(err.responseJSON.Message[Object.keys(err.responseJSON
                            .Message)[0]])
                    }
                    return InternalServerEror()
                }).always(function () {
                    UnloaderSubmit()
                })

            }
        });
    </script>
@endpush
