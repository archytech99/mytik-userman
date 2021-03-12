<div class="modal fade bs-generate-users" tabindex="-1" role="dialog" aria-labelledby="modalGenerateUsers" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Generate Voucher</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAddPacket" action="{{ route('users') }}" method="post" novalidate="">
                    @csrf

                    <input type="hidden" name="add_id" value="new">
                    <input type="hidden" name="server" value="{{ env('ROUTER_HOTSPOT_SERVER') }}">

                    <div class="form-group">
                        <label for="gen_voucher">Jumlah Voucher</label>
                        <div>
                            <input type="number" class="form-control" id="gen_voucher" name="gen_voucher" required="" placeholder="jumlah voucher ...">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="userpass">Jenis User</label>
                        <select class="custom-select" id="userpass" name="userpass">
                            <option value="0">User & Password sama</option>
                            <option value="1">User & Password beda</option>
                        </select>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label for="limit-uptime">Durasi</label>
                            <select class="custom-select" id="limit-uptime" name="limit-uptime">
                                <option value="0">Unlimited</option>
                                <option value="1h">1 Jam</option>
                                <option value="2h">2 Jam</option>
                                <option value="3h">3 Jam</option>
                                <option value="4h">4 Jam</option>
                                <option value="5h">5 Jam</option>
                                <option value="6h" selected>6 Jam</option>
                                <option value="7h">7 Jam</option>
                                <option value="8h">8 Jam</option>
                                <option value="9h">9 Jam</option>
                                <option value="10h">10 Jam</option>
                                <option value="11h">11 Jam</option>
                                <option value="12h">12 Jam</option>
                                <option value="13h">13 Jam</option>
                                <option value="14h">14 Jam</option>
                                <option value="15h">15 Jam</option>
                                <option value="16h">16 Jam</option>
                                <option value="17h">17 Jam</option>
                                <option value="18h">18 Jam</option>
                                <option value="19h">19 Jam</option>
                                <option value="20h">20 Jam</option>
                                <option value="21h">21 Jam</option>
                                <option value="22h">22 Jam</option>
                                <option value="23h">23 Jam</option>
                                <option value="1D">1 Hari</option>
                                <option value="2D">2 Hari</option>
                                <option value="3D">3 Hari</option>
                                <option value="4D">4 Hari</option>
                                <option value="5D">5 Hari</option>
                                <option value="6D">6 Hari</option>
                                <option value="7D">7 Hari</option>
                                <option value="8D">8 Hari</option>
                                <option value="9D">9 Hari</option>
                                <option value="10D">10 Hari</option>
                                <option value="11D">11 Hari</option>
                                <option value="12D">12 Hari</option>
                                <option value="13D">13 Hari</option>
                                <option value="14D">14 Hari</option>
                                <option value="15D">15 Hari</option>
                                <option value="20D">20 Hari</option>
                                <option value="30D">30 Hari</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="limit-bytes-total">Kuota</label>
                            <select class="custom-select" id="limit-bytes-total" name="limit-bytes-total">
                                <option value="0">Unlimited</option>
                                <option value="1">1 Gb</option>
                                <option value="2">2 Gb</option>
                                <option value="3">3 Gb</option>
                                <option value="4" selected>4 Gb</option>
                                <option value="5">5 Gb</option>
                                <option value="6">6 Gb</option>
                                <option value="7">7 Gb</option>
                                <option value="8">8 Gb</option>
                                <option value="9">9 Gb</option>
                                <option value="10">10 Gb</option>
                                <option value="20">20 Gb</option>
                                <option value="30">30 Gb</option>
                                <option value="40">40 Gb</option>
                                <option value="50">50 Gb</option>
                                <option value="100">100 Gb</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="profile">Packet</label>
                            <select class="custom-select" id="profile" name="profile">
                                @isset($profile)
                                    @foreach($profile as $item)
                                        <option value="{{ $item['name'] }}">{{ $item['name'] }}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                    </div>

                    <div class="form-group mt-2">
                        <div>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                Simpan
                            </button>
                            <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                Reset
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
