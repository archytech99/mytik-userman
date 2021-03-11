<div class="modal fade bs-add-packet" tabindex="-1" role="dialog" aria-labelledby="modalPacket" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Buat Paket Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAddPacket" action="{{ route('packet') }}" method="post" novalidate="">
                    @csrf

                    <input type="hidden" name="add_id" value="new">
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <label for="name">Nama</label>
                            <div>
                                <input type="text" class="form-control" id="name" name="name" required="" placeholder="Nama dari paket voucher">
                                <small class="form-text text-muted">Isi nama packet voucher.</small>
                            </div>
                        </div>
                        <input type="hidden" name="idle-timeout" value="00:05:00">
                        <input type="hidden" name="keepalive-timeout" value="00:05:00">
                        <input type="hidden" name="status-autorefresh" value="00:01:00">
                        <div class="col-sm-4">
                            <label for="shared-users">Limit Pengguna</label>
                            <div>
                                <input type="number" class="form-control" id="shared-users" name="shared-users" required="" value="1" placeholder="0 for unlimited">
                                <small class="form-text text-muted">0 => untuk unlimited voucher.</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label for="upload-limit">Upload Limit</label>
                            <select class="custom-select" id="upload-limit" name="upload-limit">
                                <option value="128k">128 kbps</option>
                                <option value="256k" selected>256 kbps</option>
                                <option value="384k">384 kbps</option>
                                <option value="512k">512 kbps</option>
                                <option value="768k">768 kbps</option>
                                <option value="1M">1 Mbps</option>
                                <option value="2M">2 Mbps</option>
                                <option value="3M">3 Mbps</option>
                                <option value="4M">4 Mbps</option>
                                <option value="5M">5 Mbps</option>
                                <option value="6M">6 Mbps</option>
                                <option value="7M">7 Mbps</option>
                                <option value="8M">8 Mbps</option>
                                <option value="9M">9 Mbps</option>
                                <option value="10M">10 Mbps</option>
                                <option value="11M">11 Mbps</option>
                                <option value="12M">12 Mbps</option>
                                <option value="13M">13 Mbps</option>
                                <option value="14M">14 Mbps</option>
                                <option value="15M">15 Mbps</option>
                                <option value="20M">20 Mbps</option>
                                <option value="25M">25 Mbps</option>
                                <option value="30M">30 Mbps</option>
                                <option value="40M">40 Mbps</option>
                                <option value="50M">50 Mbps</option>
                                <option value="100M">100 Mbps</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="download-limit">Download Limit</label>
                            <select class="custom-select" id="download-limit" name="download-limit">
                                <option value="128k">128 kbps</option>
                                <option value="256k">256 kbps</option>
                                <option value="384k">384 kbps</option>
                                <option value="512k" selected>512 kbps</option>
                                <option value="768k">768 kbps</option>
                                <option value="1M">1 Mbps</option>
                                <option value="2M">2 Mbps</option>
                                <option value="3M">3 Mbps</option>
                                <option value="4M">4 Mbps</option>
                                <option value="5M">5 Mbps</option>
                                <option value="6M">6 Mbps</option>
                                <option value="7M">7 Mbps</option>
                                <option value="8M">8 Mbps</option>
                                <option value="9M">9 Mbps</option>
                                <option value="10M">10 Mbps</option>
                                <option value="11M">11 Mbps</option>
                                <option value="12M">12 Mbps</option>
                                <option value="13M">13 Mbps</option>
                                <option value="14M">14 Mbps</option>
                                <option value="15M">15 Mbps</option>
                                <option value="20M">20 Mbps</option>
                                <option value="25M">25 Mbps</option>
                                <option value="30M">30 Mbps</option>
                                <option value="40M">40 Mbps</option>
                                <option value="50M">50 Mbps</option>
                                <option value="100M">100 Mbps</option>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" name="mac-cookie-timeout" value="24:00:00">

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
