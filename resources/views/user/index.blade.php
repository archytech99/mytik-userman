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
                            <h4 class="page-title">Daftar Voucher <sup class="badge badge-secondary"><small> User</small></sup></h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active">MyTIK - User Manager Hotspot</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target=".bs-add-users">Baru</button>
                    <button type="button" class="btn btn-warning mb-3" data-toggle="modal" data-target=".bs-generate-users">Generate Voucher</button>
                    <button type="button" class="btn btn-info mb-3" onclick="reload_user()" title="Refresh data"><i class="ion ion-ios-refresh"></i></button>

                    <x-modal.users :profile="$profile" />

                    <x-modal.generate :profile="$profile" />

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            {{ session('success') }}
                        </div>

                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            {{ session('error') }}
                        </div>

                    @endif
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-0 header-title mb-4">Voucher</h4>
                            <div class="table-responsive">
                                <table id="tableUsers" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Uptime</th>
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
        <script src="{{ asset('assets/js/users.js') }}"></script>
        <script>
            const getUsers = "{{ route('users.show') }}",
                delUsers = "{{ route('users') }}",
                csrfToken = "{{ csrf_token() }}",
                qrCode = "{{ route('qrcode') }}";
        </script>
    </x-slot>
</x-layouts.base>
