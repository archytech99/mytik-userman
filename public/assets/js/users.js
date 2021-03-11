$(document).ready(function() {
    init_user();
} );

function init_user() {
    let athtml = $('html');

    table = $('#tableUsers').DataTable({
        'paging'        : true,
        'lengthChange'  : true,
        'searching'     : true,
        'ordering'      : true,
        'info'          : true,
        'processing'    : true,
        'serverSide'    : false,
        'autoWidth'     : false,
        'pagingType'    : 'full',
        'lengthMenu'    : [ 10, 15, 25, 50, 75, 100, 500 ],
        'displayLength' : 10,
        'columnDefs': [
            {
                'targets'   : 0,
                'className' : "text-center",
                'width'     : "4%"
            }
        ],
        'language'      : {
            'search'      : '<span>Pencarian:</span> _INPUT_',
            'searchPlaceholder': 'Pencarian',
            'lengthMenu'  : '<span>Tampilkan :</span> _MENU_',
            'paginate'    : {
                'first'   : 'Awal',
                'last'    : 'Akhir',
                'next'    : athtml.attr('dir') === 'rtl' ? '&larr;' : '&rarr;',
                'previous': athtml.attr('dir') === 'rtl' ? '&rarr;' : '&larr;'
            }
        },
        'ajax'          : {
            "url"       : getUsers,
            "type"      : "GET",
            beforeSend  : function() {
                goBlockUI(false);
            },
            complete    : function () {
                $.unblockUI();
            }
        },
        'columns'       : [
            { 'data': 'id',
                render: function ( data, type, full, meta ) {
                    return '\n' +
                        '<button type="button" class="badge badge-danger" title="Hapus voucher \'' + data.name + '\'"\n' +
                        'data-name="' + data.name + '" data-desc="' + data.comment + '" onclick="return hapus_user(this)">-</button>\n';
                }
            },
            { 'data': 'name',
                render: function ( data, type, full, meta ) {
                    return data + '\n' +
                        '<form class="d-inline" action="' + qrCode + '" method="post">\n' +
                        '<input type="hidden" name="_token" value="' + csrfToken + '">\n' +
                        '<input type="hidden" name="username" value="' + data + '">\n' +
                        '<button type="submit" class="badge badge-primary" \n' +
                        'title="Lihat voucher \'' + data + '\'"><span class="mdi mdi-file-find"></span></button>\n' +
                        '</form>';
                }
            },
            { 'data': 'uptime' },
            { 'data': 'comment' }
        ]
    });
}

function reload_user() {
    table.ajax.reload(null, false);
}

function hapus_user(a) {
    let name = $(a).data('name'),
        desc = $(a).data('desc');

    swal({
        title: 'Apa anda yakin??',
        text: "Voucher '" + name +"' akan dihapus?!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yakin!',
        cancelButtonText: 'Batal!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger ml-2',
        buttonsStyling: false
    }).then(function (confirmDelete) {
        if (confirmDelete.value) {
            $.ajax({
                cache    : false,
                url      : delUsers,
                type     : "DELETE",
                dataType : "json",
                data     : { '_token': csrfToken, 'del_id': name, 'del_desc': desc },
                beforeSend:function(request) {
                    goBlockUI( true )
                },
                success: function( response ) {
                    $.unblockUI();
                    if (response.status) {
                        reload_user();
                        swal(
                            response.title,
                            response.text,
                            response.icon
                        );
                    } else {
                        swal(
                            response.title,
                            response.text,
                            response.icon
                        )
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $.unblockUI();
                    swal(
                        textStatus,
                        'Internal Server Error!',
                        'error'
                    );
                }
            });
        } else {
            swal(
                'Ditanggugkan!',
                'Proses penghapusan voucher dibatalkan.',
                'error'
            )
        }
    })
}
