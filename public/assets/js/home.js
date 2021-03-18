
$(document).ready(function() {
    init_count();
    init_index();
    setInterval( function () { reload_index() }, 1000);
});

function init_count() {
    $.ajax({
        cache    : false,
        url      : cntHome,
        type     : "GET",
        dataType : "json",
        beforeSend:function(request) {
            // goBlockUI( true )
            $('#pengguna').html();
            $('#client').html();
            $('#voucher').html();
            $('#packet').html();
        },
        success: function( response ) {
            // $.unblockUI();
            $('#pengguna').html(response.data.jml_user_active + " Pengguna");
            $('#client').html(response.data.jml_hosts + " Klien");
            $('#voucher').html(response.data.jml_user + " Voucher");
            $('#packet').html(response.data.jml_user_profile + " Packet");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            //$.unblockUI();
            console.log(errorThrown)
        }
    })
}

function init_index() {
    let athtml = $('html');

    table = $('#activeUser').DataTable({
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
                'width'     : "3%"
            },
            {
                'targets'   : 3,
                'className' : "text-right",
                'width'     : "10%"
            },
            {
                'targets'   : 4,
                'className' : "text-right",
                'width'     : "14%"
            },
            {
                'targets'   : 5,
                'className' : "text-center"
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
        'ajax'          : getHome,
        'columns'       : [
            { 'data': 'id',
                render: function ( data, type, full, meta ) {
                    return '\n' +
                        '<button type="button" class="badge badge-danger" title="Hapus \'' + data.comment + '\'"\n' +
                        'data-id="' + data.mac + '" data-name="' + data.comment + '" onclick="return hapus_index(this)">-</button>\n';
                }
            },
            { 'data': 'server' },
            { 'data': 'user' },
            { 'data': 'uptime' },
            { 'data': 'address' },
            { 'data': 'mac' },
            { 'data': 'comment' }
        ]
    });
}

function reload_index() {
    init_count();
    table.ajax.reload(null, false);
}

function hapus_index(a) {
    let mac = $(a).data('id'),
        name = $(a).data('name');

    swal({
        title: 'Apa anda yakin??',
        text: "User: '" + name + "' akan dipaksa logout?!",
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
                url      : delHome,
                type     : "DELETE",
                dataType : "json",
                data     : { '_token': csrfToken, 'del_id': mac, 'del_name': name },
                beforeSend:function(request) {
                    goBlockUI( true )
                },
                success: function( response ) {
                    $.unblockUI();
                    if (response.status) {
                        reload_index();
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
