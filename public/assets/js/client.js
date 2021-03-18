$(document).ready(function() {
    init_client();
} );

function init_client() {
    let athtml = $('html');

    table = $('#tableClient').DataTable({
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
            },
            {
                'targets'   : 2,
                'className' : "text-right",
                'width'     : "10%"
            },
            {
                'targets'   : 3,
                'className' : "text-center",
                'width'     : "12%"
            },
            {
                'targets'   : 4,
                'className' : "text-center",
                'width'     : "16%"
            },
            {
                'targets'   : 5,
                'className' : "text-center",
                'width'     : "6%"
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
        'ajax'          : getClient,
        'columns'       : [
            { 'data': 'id',
                render: function ( data, type, full, meta ) {
                    return '\n' +
                        '<button type="button" class="badge badge-danger" title="Hapus client \'' + data.mac + '\'"\n' +
                        'data-name="' + data.mac + '" data-desc="' + data.comment + '" onclick="return hapus_client(this)">-</button>\n';
                }
            },
            { 'data': 'server' },
            { 'data': 'uptime' },
            { 'data': 'address' },
            { 'data': 'mac' },
            { 'data': 'authorized',
                render: function ( data, type, full, meta ) {
                    if (data === 'true') {
                        return '<i class="badge badge-success">Online</i>'
                    } else {
                        return '<i class="badge badge-danger">Offline</i>'
                    }
                }
            },
            { 'data': 'comment' }
        ]
    });
}

function reload_client() {
    table.ajax.reload(null, false);
}

function hapus_client(a) {
    let name = $(a).data('name'),
        desc = $(a).data('desc');

    swal({
        title: 'Apa anda yakin??',
        text: "Client '" + name +"' akan dihapus?!",
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
                url      : delClient,
                type     : "DELETE",
                dataType : "json",
                data     : { '_token': csrfToken, 'del_id': name, 'del_desc': desc },
                beforeSend:function(request) {
                    goBlockUI( true )
                },
                success: function( response ) {
                    $.unblockUI();
                    if (response.status) {
                        reload_client();
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
