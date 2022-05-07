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
                            <h4 class="page-title">Daftar Klien Hotspot</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active">MyTIK - User Manager Hotspot</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <button type="button" class="btn btn-info mb-3" onclick="reload_client()" title="Refresh data"><i class="ion ion-ios-refresh"></i></button>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-0 header-title mb-4">Hotspot Client Session</h4>
                            <div class="table-responsive">
                                <table id="tableClient" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Host</th>
                                            <th scope="col">Uptime</th>
                                            <th scope="col">IP Address</th>
                                            <th scope="col">MAC Address</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Desc.</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
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
        <script src="{{ asset('assets/js/client.js') }}"></script>
        <script>
            const csrfToken = "{{ csrf_token() }}",
                getClient = { "url" : "{{ route('client.show') }}", "type" : "POST", "data" : {"_token": csrfToken} },
                delClient = "{{ route('client') }}";
        </script>
    </x-slot>
</x-layouts.base>
