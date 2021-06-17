<div class="modal" id="modal-edit" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit {{$title}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-edit">
                    @csrf
                    <input name="id" type="hidden">
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="col-form-label">Kode</label>
                            <input autocomplete="off" placeholder="Kode" type="text" readonly class="form-control" name="employee_code"/>
                        </div>
                        <div class="col-sm-12">
                            <label class="col-form-label">Nama</label>
                            <input autocomplete="off" placeholder="Nama" type="text" class="form-control" name="employee_name"/>
                        </div>
                        <div class="col-sm-12">
                            <label class="col-form-label">Jabatan</label>
                                <select name="position_id" class="form-control">
                                    <option>--pilih--</option>
                                        @foreach ($jabatan as $item)
                                      <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                </select>
                        </div>
                        <div class="col-sm-12">
                            <label class="col-form-label">Divisi</label>
                                <select name="division_id" class="form-control">
                                    <option>--pilih--</option>
                                        @foreach ($divisi as $item)
                                      <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                </select>
                        </div>
                    </div>
                </form>
            </div>
            <div style="border-top: 0px" class="modal-footer">
                <button type="submit" form="form-edit" class="btn-submit btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>


@push("js")
    <script>
        editData = (id) => {
            $.ajax({
                url: "/master/karyawan/edit/" + id + "/json",
                beforeSend: () => {

                }
            }).then((res) => {
                if (res.code == 2200) {
                    $('#modal-edit').modal('show')
                    $("input[name='id']").val(res.data.id)
                    $("input[name='employee_code']").val(res.data.employee_code)
                    $("input[name='employee_name']").val(res.data.employee_name)
                    $("input[name='jabatan_name']").val(res.data.jabatan_name)
                } else {
                    return BadResponse(res.message)
                }
            }).catch((err) => {
                return InternalServerEror()
            }).always(() => {
                unloader()
            })
        }
        var form = $("#form-edit").validate({
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
                    url: "/master/karyawan/update/json",
                    method: "POST",
                    data: $('#form-edit').serialize(),
                    beforeSend: function () {
                        LoaderSubmit()
                    }
                }).then(res => {
                    if (res.code == 2200) {
                        $('#modal-edit').modal('hide')
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

