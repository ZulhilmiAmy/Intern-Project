<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <title>Tempahan Bilik</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        body {
            background: #f8f9fa;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: 600;
        }

        .modal-header {
            background-color: #0d6efd;
            color: white;
        }

        .select2-container--default .select2-selection--single {
            height: 45px;
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid #ced4da;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 8px;
        }

        .calendar-link {
            font-weight: 600;
            color: #0d6efd;
            padding: 3px 8px;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .calendar-link:hover {
            background-color: #0d6efd;
            color: #ffffff;
            text-decoration: none;
        }

        .select2-container--default .select2-selection--single.is-invalid {
            border: 1px solid #dc3545 !important;
        }

        footer {
            background: linear-gradient(rgba(13, 110, 253, 0.7), rgba(13, 110, 253, 0.7)),
                url('https://images.unsplash.com/photo-1581091870621-7755c287a223?auto=format&fit=crop&w=1950&q=80') center/cover no-repeat;
            color: white;
            padding: 25px 0;
            text-align: center;
            margin-top: 60px;
            position: relative;
            left: 0;
            right: 0;
            width: 100vw;
            margin-left: calc(-50vw + 50%);
        }

        footer a {
            color: #ffc107;
            text-decoration: none;
        }

        /* =========================
       MOBILE RESPONSIVE
    ========================= */
        @media (max-width: 768px) {

            .container {
                padding-left: 12px;
                padding-right: 12px;
            }

            .container.mt-5 {
                margin-top: 20px !important;
            }

            .card.p-4 {
                padding: 18px !important;
            }

            h2 {
                font-size: 1.5rem;
            }

            p.text-center {
                font-size: 0.95rem;
            }

            .form-label {
                font-size: 0.95rem;
            }

            .form-control,
            .form-select,
            .select2-container--default .select2-selection--single {
                height: 44px;
                font-size: 16px;
            }

            textarea.form-control {
                height: auto;
                min-height: 100px;
            }

            .row>.col-md-6 {
                margin-bottom: 10px;
            }

            .card-header {
                font-size: 0.95rem;
                text-align: center;
            }

            .btn {
                font-size: 1rem;
                padding: 10px;
            }

            .modal-dialog {
                margin: 10px;
            }

            .modal-footer {
                flex-direction: column;
                gap: 10px;
            }

            .modal-footer .btn {
                width: 100%;
            }

            footer {
                font-size: 0.9rem;
                padding: 18px 10px;
            }

            ul {
                padding-left: 18px;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="card p-4 mx-auto" style="max-width: 800px;">
            <h2 class="mb-2 text-center">Tempahan Bilik</h2>

            <p class="text-center mb-4" style="font-style: italic; color:#b02a37;">
                *Sila semak kekosongan bilik yang dikehendaki terlebih dahulu melalui
                <a href="{{ route('home') }}" class="calendar-link">
                    [Kalendar Tempahan]
                </a>.
            </p>

            <form action="{{ route('booking.store') }}" method="POST">
                @csrf

                <!-- Maklumat Pemohon -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        ① Maklumat Pemohon
                    </div>

                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label">No Kad Pengenalan</label>
                            <input type="text" name="no_ic" maxlength="12" value="{{ old('no_ic') }}"
                                class="form-control @error('no_ic') is-invalid @enderror"
                                placeholder="Masukkan 12 digit IC"
                                oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                            @error('no_ic')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Penuh</label>
                            <input type="text" name="nama_penuh"
                                class="form-control @error('nama_penuh') is-invalid @enderror"
                                value="{{ old('nama_penuh') }}">
                            @error('nama_penuh')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jabatan / Unit</label>
                            <select name="jabatan_id" class="form-select @error('jabatan_id') is-invalid @enderror">
                                <option value="">-- Pilih Jabatan --</option>
                                @foreach(\App\Models\Department::all() as $dept)
                                    <option value="{{ $dept->id }}" {{ old('jabatan_id') == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->department_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jabatan_id')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jawatan</label>
                            <input type="text" name="jawatan" value="{{ old('jawatan') }}"
                                class="form-control @error('jawatan') is-invalid @enderror">
                            @error('jawatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No Telefon (Bimbit)</label>
                                <input type="text" name="no_tel_bimbit" value="{{ old('no_tel_bimbit') }}"
                                    class="form-control @error('no_tel_bimbit') is-invalid @enderror"
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                                @error('no_tel_bimbit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">No Telefon (Pejabat)</label>
                                <input type="text" name="no_tel_pejabat" value="{{ old('no_tel_pejabat') }}"
                                    class="form-control @error('no_tel_pejabat') is-invalid @enderror"
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                                @error('no_tel_pejabat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>


                <!-- Butiran Acara -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        ② Butiran Acara & Logistik
                    </div>

                    <div class="card-body">

                        <!-- Lokasi -->
                        <div class="mb-3">
                            <label class="form-label">Lokasi Tempahan</label>
                            <select name="location_id" class="form-select @error('location_id') is-invalid @enderror">
                                <option value="">-- Pilih Lokasi --</option>
                                @foreach(\App\Models\Location::all() as $loc)
                                    <option value="{{ $loc->id }}" {{ old('location_id') == $loc->id ? 'selected' : '' }}>
                                        {{ $loc->location_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('location_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row">

                            <!-- Tarikh Mula -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tarikh Mula</label>
                                <input type="text" name="tarikh_mula" value="{{ old('tarikh_mula') }}"
                                    class="form-control datepicker @error('tarikh_mula') is-invalid @enderror" readonly>
                                @error('tarikh_mula')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Masa Mula -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Masa Mula</label>
                                <input type="time" name="masa_mula" value="{{ old('masa_mula') }}"
                                    class="form-control @error('masa_mula') is-invalid @enderror">
                                @error('masa_mula')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tarikh Tamat -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tarikh Tamat</label>
                                <input type="text" name="tarikh_tamat" value="{{ old('tarikh_tamat') }}"
                                    class="form-control datepicker @error('tarikh_tamat') is-invalid @enderror"
                                    readonly>
                                @error('tarikh_tamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Masa Tamat -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Masa Tamat</label>
                                <input type="time" name="masa_tamat" value="{{ old('masa_tamat') }}"
                                    class="form-control @error('masa_tamat') is-invalid @enderror">
                                @error('masa_tamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <!-- Kegunaan -->
                        <div class="mb-3">
                            <label class="form-label">Kegunaan</label>
                            <input type="text" name="kegunaan" value="{{ old('kegunaan') }}"
                                class="form-control @error('kegunaan') is-invalid @enderror">
                            @error('kegunaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Catatan -->
                        <div class="mb-3">
                            <label class="form-label">Catatan</label>
                            <textarea name="catatan"
                                class="form-control @error('catatan') is-invalid @enderror">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <!-- Notes / Peringatan -->
                    <div class="card mb-4 border-warning">
                        <div class="card-header bg-warning text-dark">
                            <center>⚠️ Perhatian</center>
                        </div>
                        <div class="card-body">
                            <ul class="mb-0">
                                <li>Permohonan ini akan dihantar kepada Admin untuk disahkan.</li>
                                <li>Sila pastikan semua maklumat adalah tepat dan lengkap sebelum menghantar.</li>
                                <li>No. tiket akan dihantar ke email yang diberikan selepas permohonan disahkan.</li>
                                <li>No tiket adalah untuk pengguna dapat melihat status tempahan.
                                </li>
                            </ul>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Hantar Tempahan
                    </button>

            </form>
        </div>
    </div>

    <!-- Success Modal -->
    @if(session('success'))
        <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tempahan Berjaya!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>No. Tiket anda: <strong>{{ session('ticket_no') }}</strong></p>
                        <p>Tempahan anda telah disimpan dan menunggu pengesahan admin.</p>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('home') }}" class="btn btn-primary">Ke Halaman Utama</a>
                        <a href="{{ route('booking.create') }}" class="btn btn-secondary">Buat Tempahan Baru</a>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <!-- Footer -->
    <footer>
        &copy; {{ date('Y') }} Sistem Tempahan Bilik. Semua Hak Terpelihara.
        <br>
        Dibangunkan oleh <a href="#">Unit Teknologi Maklumat</a>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {

            // Initialize Select2
            $('select[name="jabatan_id"], select[name="location_id"]').select2({
                width: '100%'
            });

            @if ($errors->has('jabatan_id'))
                $('.select2-selection').addClass('is-invalid');
            @endif

            // IC validation + autofill
            $('input[name="no_ic"]').on('input', function () {

                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').hide();

                this.value = this.value.replace(/[^0-9]/g, '');
                let ic = $(this).val();

                if (ic.length === 12) {
                    $.get('/autofill', { no_ic: ic }, function (data) {

                        if (data.nama_penuh) {
                            $('input[name="nama_penuh"]').val(data.nama_penuh);
                            $('input[name="email"]').val(data.email);
                            $('select[name="jabatan_id"]').val(data.jabatan_id).trigger('change');
                            $('input[name="jawatan"]').val(data.jawatan);
                            $('input[name="no_tel_bimbit"]').val(data.no_tel_bimbit);
                            $('input[name="no_tel_pejabat"]').val(data.no_tel_pejabat);
                        }

                    });
                }

            });

            // Tarikh Mula
            $('input[name="tarikh_mula"]').datepicker({
                dateFormat: 'dd-mm-yy',
                minDate: 0,
                changeMonth: true,
                changeYear: true,
                onSelect: function (dateText) {

                    let startDate = $(this).datepicker('getDate');

                    // Set minDate untuk Tarikh Tamat
                    $('input[name="tarikh_tamat"]').datepicker('option', 'minDate', startDate);

                }
            });

            // Tarikh Tamat
            $('input[name="tarikh_tamat"]').datepicker({
                dateFormat: 'dd-mm-yy',
                minDate: 0,
                changeMonth: true,
                changeYear: true
            });

            // Autofocus error field
            @if ($errors->any())
                $('html, body').animate({
                    scrollTop: $('.is-invalid').first().offset().top - 120
                }, 500);
                $('.is-invalid').first().focus();
            @endif

            // Hilangkan error bila user mula isi
            $('input, textarea').on('input', function () {

                if ($(this).val().trim() !== '') {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').hide();
                }

            });

            // Untuk dropdown
            $('select').on('change', function () {

                if ($(this).val() !== '') {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').hide();
                }

            });

            // Untuk Select2
            $('select').on('change', function () {

                if ($(this).val() !== '') {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').hide();

                    $(this).next('.select2-container').find('.select2-selection')
                        .removeClass('is-invalid');
                }

            });

        });
    </script>

    @if(session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var myModal = new bootstrap.Modal(document.getElementById('successModal'));
                myModal.show();
            });
        </script>
    @endif
</body>

</html>