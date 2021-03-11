<x-layouts.base>

    <x-slot name="page_container">
        <div class="error-bg"></div>

        <div class="home-btn d-none d-sm-block">
            <a href="{{ route('index') }}" class="text-white"><i class="mdi mdi-home h1"></i></a>
        </div>

        <div class="wrapper-page">

            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-5">
                        <div class="card card-pages shadow-none mt-4">

                            <div class="text-center p-3">

                                <div class="img mt-4">
                                    {{ QrCode::size(250)->generate(url_hotspot($username, $password)) }}
                                </div>

                                {{--<h1 class="error-page mt-5"><span>AW Hotspot!</span></h1>--}}

                                <h4 class="mb-4 mt-5">Scan QrCode diatas!</h4>

                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control text-center" id="username" value="{{ $username }}" placeholder="username ..." disabled>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="text" class="form-control text-center" id="password" value="{{ $password }}" placeholder="password ..." disabled>
                                </div>

                                <div class="form-group">
                                    <label for="limit_uptime">Durasi</label>
                                    <input type="text" class="form-control text-center" id="limit_uptime" value="{{ $limit_uptime ?? 'unlimited' }}" placeholder="durasi ..." disabled>
                                </div>

                                <div class="form-group">
                                    <label for="limit_bytes">Kuota</label>
                                    <input type="text" class="form-control text-center" id="limit_bytes" value="{{ $limit_bytes ?? 'unlimited' }}" placeholder="kuota ..." disabled>
                                </div>

                                <a class="btn btn-primary waves-effect waves-light mb-4 mt-4" href="{{ route('users') }}"><i class="fa fa-user"></i> Kembali</a>
                            </div>

                        </div>

                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>

    </x-slot>

    <x-slot name="scripts">
        <script type="application/javascript">
        </script>
    </x-slot>

</x-layouts.base>
