$(document).ready(function() {
    init_packet();
} );

function init_packet() {
    let athtml = $('html');

    table = $('#tablePacket').DataTable({
        'paging'        : true,
        'lengthChange'  : true,
        'searching'     : true,
        'ordering'      : true,
        'info'          : true,
        'processing'    : false,
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
            "url"       : getPacket,
            "type"      : "POST",
            "data"      : {"_token": csrfToken},
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
                        '<button type="button" class="badge badge-danger" title="Hapus packet \'' + data.name + '\'"\n' +
                        'data-name="' + data.name + '" onclick="return hapus_packet(this)">-</button>\n';
                }
            },
            { 'data': 'name' },
            { 'data': 'shared',
                render: function ( data, type, full, meta ) {
                    return data + ' voucher';
                }
            },
            { 'data': 'idle' },
            { 'data': 'rate-limit' },
            { 'data': 'mac-address',
                render: function ( data, type, full, meta ) {
                    if (data.added) {
                        return data.timeout;
                    } else {
                        return 'temporary';
                    }
                }
            }
        ]
    });
}

function reload_packet() {
    table.ajax.reload(null, false);
}

function hapus_packet(a) {
    let name = $(a).data('name');

    swal({
        title: 'Apa anda yakin??',
        text: "Packet '" + name +"' akan dihapus?!",
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
                url      : delPacket,
                type     : "DELETE",
                dataType : "json",
                data     : { '_token': csrfToken, 'del_id': name },
                beforeSend:function(request) {
                    goBlockUI( true )
                },
                success: function( response ) {
                    $.unblockUI();
                    if (response.status) {
                        reload_packet();
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
                'Proses penghapusan packet dibatalkan.',
                'error'
            )
        }
    })
}
