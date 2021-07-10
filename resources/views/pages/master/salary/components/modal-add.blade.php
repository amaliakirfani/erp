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
                        <div class="col-sm-12">
                            <label class="col-form-label">Divisi</label>
                                <select name="division_id" class="form-control">
                                    <option>--pilih--</option>
                                        @foreach ($divisi as $item)
                                      <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                </select>
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
                            <label class="col-form-label">Gaji Per Jam</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp</div>
                                    </div>
                                    <input type="text" autocomplete="off" onkeyup="this.value=formatRupiah(this.value)" class="form-control" placeholder="Jumlah Gaji per Jam"
                                           name="sallary_per_hour">
                                </div>
                                <div class="invalid-feedback-payment-amount"></div>
                        </div>
                        <div class="col-sm-12">
                            <label class="col-form-label">Gaji Lembur Per Jam</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp</div>
                                    </div>
                                    <input type="text" autocomplete="off" onkeyup="this.value=formatRupiah(this.value)" class="form-control" placeholder="Jumlah Gaji Lembur"
                                           name="sallary_overtime">
                                </div>
                                <div class="invalid-feedback-payment-amount"></div>
                        </div>
                        <div class="col-sm-12">
                            <label class="col-form-label">Gaji Tunjangan Per Hari</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp</div>
                                    </div>
                                    <input type="text" autocomplete="off" onkeyup="this.value=formatRupiah(this.value)" class="form-control" placeholder="Jumlah Gaji Tunjangan"
                                           name="allowance">
                                </div>
                                <div class="invalid-feedback-payment-amount"></div>
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
                    url: "/master/salary/create/json",
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
