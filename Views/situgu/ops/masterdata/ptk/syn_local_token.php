<form id="formTarikDataLocalModalData" method="post">
    <div class="modal-body" style="padding-top: 0px; padding-bottom: 0px;">
        <div class="mb-3">
            <label for="_token" class="form-label">Token Api Local Dapodik</label>
            <input type="text" class="form-control token" <?= isset($data) ? ($data->token === NULL || $data->token === "" ? '' : 'value="' . $data->token . '"') : '' ?> id="_token" name="_token" placeholder="Token Api Dapodik Local..." onfocusin="inputFocus(this);" />
            <!-- <p style="padding: 5px 0px;">Silah isi Nomor Whatsapp dengan format: 08xxxxxxxxxx (Contoh: 081208120812)</p> -->
            <div class="help-block _token"></div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="button" onclick="getSyncDapoLocal(this)" class="btn btn-primary waves-effect waves-light">Tarik Riwayat Kepangkatan Dari Dapodik Local</button>
    </div>
</form>

<script>
    function getSyncDapoLocal(event) {
        const token = document.getElementsByName('_token')[0].value;
        const npsn = '<?= isset($data) ? $data->npsn : '' ?>';

        if (token === "") {
            Swal.fire(
                'PERINGATAN!',
                "Token Api Dapodik tidak valid. Silahkan hubungi Operator Sekolah anda.",
                'warning'
            );
        }

        fetch('http://localhost:5774/WebService/getGtk?npsn=' + npsn, {
                method: 'GET',
                headers: new Headers({
                    'Authorization': 'Bearer ' + token
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
            })
            .catch(error => {
                console.log(error);
            });

        // $.ajax({
        //     url: "http://localhost:5774/WebService/getGtk?npsn=" + npsn + "&callback=myFunctionCallBack",
        //     type: 'GET',
        //     // method: 'GET',
        //     headers: {
        //         'Authorization': "Bearer " + token,
        //         // 'Origin': "http://localhost:5774",
        //     },
        //     // beforeSend: function(xhr) {
        //     //     xhr.setRequestHeader("Authorization", "Bearer " + token);
        //     //     xhr.setRequestHeader("Origin", "http://localhost");
        //     // },
        //     dataType: 'jsonp',
        //     jsonpCallback: 'myFunctionCallBack',
        //     // crossDomain: true,
        //     beforeSend: function(xhr) {
        //         // xhr.setRequestHeader("Authorization", "Bearer " + token);
        //         $('div.modal-content-loading-aktivasi').block({
        //             message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
        //         });
        //     },
        //     success: function(resul) {
        //         $('div.modal-content-loading-aktivasi').unblock();

        //         console.log(resul);

        //         // if (resul.status !== 200) {
        //         //     if (resul.status === 401) {
        //         //         Swal.fire(
        //         //             'Failed!',
        //         //             resul.message,
        //         //             'warning'
        //         //         ).then((valRes) => {
        //         //             reloadPage();
        //         //         });
        //         //     } else {
        //         //         Swal.fire(
        //         //             'PERINGATAN!',
        //         //             resul.message,
        //         //             'warning'
        //         //         );
        //         //     }
        //         // } else {
        //         //     $('.contentAktivasiBodyModal').html(resul.data);
        //         // }
        //     },
        //     error: function(err) {
        //         console.log(err);
        //         $('div.modal-content-loading-aktivasi').unblock();
        //         Swal.fire(
        //             'PERINGATAN!',
        //             "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
        //             'warning'
        //         );
        //     }
        // });

    };

    function myFunctionCallBack(data) {
        console.log(data);
    }
</script>