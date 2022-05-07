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
                            <h4 class="page-title">Daftar Session Tersimpan</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active">MyTIK - User Manager Hotspot</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-8">
                    <button type="button" class="btn btn-info mb-3" onclick="reload_session()" title="Refresh data"><i class="ion ion-ios-refresh"></i></button>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-0 header-title mb-4">Session Saved</h4>
                            <div class="table-responsive">
                                <table id="tbSession" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Host</th>
                                            <th scope="col">User</th>
                                            <th scope="col">Port</th>
                                            <th scope="col">Last Login</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    {{-- <div class="card">
                        <div class="card-body">

                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/datatables/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/datatables/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/js/session.js') }}"></script>
        <script>
            const csrfToken = "{{ csrf_token() }}",
                getSession = { "url" : "{{ route('session.show') }}", "type" : "POST", "data" : {"_token": csrfToken} },
                delSession = "{{ route('session') }}";
        </script>
    </x-slot>
</x-layouts.base>
