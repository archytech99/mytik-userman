<x-layouts.base>

    <x-slot name="styles">
        <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/vendor/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/vendor/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    </x-slot>

    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center ">
                    <div class="col-md-8">
                        <div class="page-title-box">
                            <h4 class="page-title">Dashboard</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active">MyTIK - User Manager Hotspot</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center p-1">
                                <div class="col-lg-12">
                                    <h5 class="font-16">User Aktif</h5>
                                    <h4 class="text-primary pt-1 mb-0" id="pengguna"></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center p-1">
                                <div class="col-lg-12">
                                    <h5 class="font-16">Client Hotspot</h5>
                                    <h4 class="text-danger pt-1 mb-0" id="client"></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center p-1">
                                <div class="col-lg-12">
                                    <h5 class="font-16">Total Voucher</h5>
                                    <h4 class="text-info pt-1 mb-0" id="voucher"></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center p-1">
                                <div class="col-lg-12">
                                    <h5 class="font-16">Total Packet</h5>
                                    <h4 class="text-warning pt-1 mb-0" id="packet"></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-0 header-title mb-4">Daftar Pengguna Hotspot <sup class="badge badge-secondary"><small> Aktif</small></sup></h4>
                            <div class="table-responsive">
                                <table id="activeUser" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Host</th>
                                            <th scope="col">User</th>
                                            <th scope="col">Uptime</th>
                                            <th scope="col">IP Address</th>
                                            <th scope="col">Mac Address</th>
                                            <th scope="col">Description</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                        </div>
                    </div>

                    <div class="alert alert-dark mb-0" role="alert">
                        <marquee behavior="" direction="">
                            <strong>Qoute Today!</strong>
                            {{ $quote ?? '' }}
                        </marquee>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body">
                        <h4 class="mt-0 header-title mb-4">GitHub Information</h4>
                            <img src="https://github-readme-stats.vercel.app/api?username=archytech99&show_icons=true&theme=tokyonight&line_height=27"
                                 alt="GitHub Stats" width="100%">
                            <img src="https://github-readme-stats.vercel.app/api/top-langs/?username=archytech99&langs_count=8&theme=tokyonight&layout=compact"
                                 class="mt-3" alt="Skills" width="100%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/datatables/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/datatables/responsive.bootstrap4.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                init_count();
                init_index();
                setInterval( function () { reload_index() }, 15000);
            });

            function init_count() {
                $.ajax({
                    cache    : false,
                    url      : "{{ url('/?cnt=index') }}",
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
                    'processing'    : true,
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
                    'ajax'          : {
                        "url"       : "{{ route('index.show') }}",
                        "type"      : "GET"
                    },
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
                            url      : "{{ route('index') }}",
                            type     : "DELETE",
                            dataType : "json",
                            data     : { '_token': "{{ csrf_token() }}", 'del_id': mac, 'del_name': name },
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
        </script>
    </x-slot>
</x-layouts.base>
