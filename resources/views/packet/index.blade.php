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
                            <h4 class="page-title">Daftar Packet Voucher <sup class="badge badge-secondary"><small> Profile</small></sup></h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active">MyTIK - User Manager Hotspot</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target=".bs-add-packet">Baru</button>
                    <button type="button" class="btn btn-info mb-3" onclick="reload_packet()" title="Refresh data"><i class="ion ion-ios-refresh"></i></button>

                    <x-modal.packet/>

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
                            <div class="d-inline-flex">
                                <h4 class="mr-auto mt-0 header-title mb-4 d-inline-block">Packet Voucher</h4>
                            </div>

                            <div class="table-responsive">
                                <table id="tablePacket" class="table table-naked dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead class="text-center">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Voucher</th>
                                        <th scope="col">Idle Time</th>
                                        <th scope="col">Byte Up/Down</th>
                                        <th scope="col">Mac Address Timeout</th>
                                    </tr>
                                    </thead>
                                    <tfoot class="text-center">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Voucher</th>
                                        <th scope="col">Idle Time</th>
                                        <th scope="col">Byte Up/Down</th>
                                        <th scope="col">Mac Address Timeout</th>
                                    </tr>
                                    </tfoot>
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
        <script src="{{ asset('assets/js/packet.js') }}"></script>
        <script>
            const getPacket = "{{ route('packet.show') }}",
                delPacket = "{{ route('packet') }}",
                csrfToken = "{{ csrf_token() }}";
        </script>
    </x-slot>
</x-layouts.base>
