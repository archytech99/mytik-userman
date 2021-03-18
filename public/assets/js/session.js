$(document).ready(function() {
    init_session();
});

function init_session() {
    let athtml = $('html');

    table = $('#tbSession').DataTable({
        'paging'        : true,
        'lengthChange'  : true,
        'searching'     : true,
        'ordering'      : true,
        'info'          : true,
        'processing'    : false,
        'serverSide'    : false,
        'autoWidth'     : false,
        'pagingType'    : 'full',
        'lengthMenu'    : [ 5, 10, 25, 50, 75, 100, 500 ],
        'displayLength' : 5,
        'columnDefs'    : [
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
        'ajax'          : getSession,
        'columns'       : [
            { 'data': 'id',
                render: function ( data, type, full, meta ) {
                    return '\n' +
                        '<button type="button" class="badge badge-danger" data-id="' + data + '" \n' +
                        'onclick="return hapus_session(this)">-</button>\n';
                }
            },
            { 'data': 'hosts' },
            { 'data': 'username' },
            { 'data': 'port' },
            { 'data': 'last_log' }
        ]
    });
}

function reload_session() {
    table.ajax.reload(null, false);
}

function hapus_session(a) {
    let id = $(a).data('id');

    swal({
        title: 'Apa anda yakin??',
        text: "Session akan dihapus?!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yakin!',
        cancelButtonText: 'Batal!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger ml-2',
        buttonsStyling: false
    }).then(function (cDel) {
        if (cDel.value) {
            $.ajax({
                cache    : false,
                url      : delSession,
                type     : "DELETE",
                dataType : "json",
                data     : { '_token': csrfToken, 'del_id': id },
                beforeSend:function(request) {
                    goBlockUI( true )
                },
                success: function( response ) {
                    $.unblockUI();
                    if (response.status) {
                        reload_session();
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
            })
        }
    })
}
