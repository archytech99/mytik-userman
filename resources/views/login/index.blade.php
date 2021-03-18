<x-layouts.base>

<x-slot name="page_container">
    <div class="accountbg"></div>

    <div class="wrapper-page">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-5">
                    <div class="card card-pages shadow-none mt-4">
                        <div class="card-body">
                            <div class="text-center mt-0 mb-3">
                                <img src="{{ asset('assets/images/logo-dark.png') }}" class="mt-3" alt="" height="26">
                                <p class="text-muted w-75 mx-auto mb-4 mt-4">Silahkan Login untuk bisa akses Panel Admin Dashboard.</p>
                            </div>

                            <form id="formLogin" class="form-horizontal mt-4">
                                @csrf

                                <div class="form-group">
                                    <div class="col-12">
                                        <label for="hosts">IP. Address</label>
                                        <input class="form-control" type="text" id="hosts" name="hosts" value="192.168.88.1" placeholder="192.168.88.1" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-12">
                                        <label for="username">Username</label>
                                        <input class="form-control" type="text" id="username" name="username" value="admin" placeholder="admin" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-12">
                                        <label for="password">Password</label>
                                        <input class="form-control" type="password" id="password" name="password" placeholder="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-12">
                                        <label for="port">Port</label>
                                        <input class="form-control" type="text" id="port" name="port" value="8728" placeholder="8728">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-12">
                                        <div class="checkbox checkbox-primary">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="session" name="session">
                                                <label class="custom-control-label" for="session"> Simpan Login</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group text-center mt-3">
                                    <div class="col-12">
                                        <button type="button" class="btn btn-primary btn-block waves-effect waves-light" onclick="formSubmit();">Log In</button>
                                    </div>
                                </div>

                            </form>

                            <div class="text-center">
                                <p class="mt-4 text-muted">Atau</p>
                                <form action="{{ route('session') }}" method="post" id="formSession" class="form-horizontal mt-4">
                                    @csrf

                                    <div class="form-group row">
                                        <div class="col-sm-9">
                                            <select class="custom-select" id="session" name="session">
                                                @if(session_route())
                                                @foreach(session_route() as $key=> $item)
                                                <option value="{{ $item }}">{{ $item }} [{{ $key }}]</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <button type="submit" class="btn btn-outline-primary">Log In</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-slot>

<x-slot name="scripts">
    <script type="application/javascript">
        function formSubmit() {
            let form = $('#formLogin').serialize();
            $.ajax({
                url : "{{ route('login') }}",
                type: "POST",
                data: form,
                cache: false,
                dataType: "json",
                beforeSend: function() {
                    goBlockUI( true );
                },
                success: function( response ) {
                    $.unblockUI();
                    if (! response.status ) {
                        swal({
                            title: response.title,
                            text: response.text,
                            type: response.icon,
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-warning'
                        });
                    } else {
                        swal({
                            title: response.title,
                            text: response.text,
                            type: response.icon,
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-success'
                        }).then(function () {
                            window.location.replace("{{ url('/') }}");
                        });
                    }
                },
                error: function ( jqXHR, textStatus, errorThrown ) {
                    $.unblockUI();
                    console.log( textStatus + ' >< ' + errorThrown );
                    swal({
                        title: textStatus,
                        text: errorThrown,
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonClass: 'btn btn-success'
                    });
                }
            });
        }
    </script>
</x-slot>

</x-layouts.base>
