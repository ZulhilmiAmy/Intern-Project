<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        body {
            background: #f4f6fb;
            font-family: 'Segoe UI', sans-serif;
            padding-bottom: 40px;
        }

        .header {
            background: #0d6efd;
            color: white;
            padding: 15px;
            border-radius: 12px;
        }

        .card {
            border-radius: 14px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        }

        .stat-card {
            text-align: center;
            padding: 15px;
        }

        .chart-box {
            height: 260px;
        }

        .btn {
            border-radius: 8px;
        }

        .modal-content {
            animation: fadeInScale 0.3s ease;
        }

        @keyframes fadeInScale {
            from {
                transform: scale(0.95);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .card+.card {
            margin-top: 20px;
        }

        .stat-total {
            background: linear-gradient(135deg, #0d6efd, #3d8bfd);
            color: white;
        }

        .stat-pending {
            background: linear-gradient(135deg, #ffc107, #ffcd39);
            color: #212529;
        }

        .stat-approved {
            background: linear-gradient(135deg, #198754, #20c997);
            color: white;
        }

        .stat-rejected {
            background: linear-gradient(135deg, #dc3545, #ff6b6b);
            color: white;
        }

        .stat-card {
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            transition: 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .location-col {
            max-width: 180px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* ===============================
        MOBILE RESPONSIVE ADMIN PAGE
        ================================= */
        @media (max-width: 768px) {

            body {
                padding-bottom: 20px;
            }

            .container {
                padding-left: 12px;
                padding-right: 12px;
            }

            /* HEADER */
            .header {
                flex-direction: column;
                align-items: stretch !important;
                gap: 10px;
                text-align: center;
            }

            .header h4 {
                font-size: 1.2rem;
            }

            .header form button {
                width: 100%;
            }

            /* CARD */
            .card {
                border-radius: 12px;
            }

            .card.p-3 {
                padding: 15px !important;
            }

            /* TABLE */
            .table-responsive {
                overflow-x: auto;
            }

            table {
                min-width: 800px;
            }

            /* DATATABLE TOP */
            .dataTables_wrapper .row {
                gap: 10px;
            }

            .dataTables_filter,
            .dataTables_length {
                text-align: left !important;
                width: 100%;
            }

            .dataTables_filter input,
            .dataTables_length select {
                width: 100% !important;
                margin-top: 5px;
            }

            /* STATISTIC */
            .stat-card {
                padding: 15px;
            }

            .stat-card h2 {
                font-size: 1.6rem;
            }

            .stat-card h3 {
                font-size: 1.3rem;
            }

            .stat-card h6 {
                font-size: 0.9rem;
            }

            /* SMALL CARDS */
            .col-4 {
                width: 100%;
            }

            /* CHART */
            .chart-box {
                height: 250px;
            }

            /* BUTTON */
            .btn {
                font-size: 0.95rem;
                padding: 8px 10px;
            }

            #toggleChart {
                width: 100%;
                margin-bottom: 10px;
            }

            /* MODAL */
            .modal-dialog {
                margin: 10px;
            }

            .modal-body .row>div {
                margin-bottom: 12px;
            }
        }
    </style>
</head>

<body>

    <div class="container mt-4">

        <!-- HEADER -->
        <div class="header d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Dashboard Tempahan Bilik</h4>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-light btn-sm">Logout</button>
            </form>
        </div>

        <!-- ALERT (fallback) -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- TABLE -->
        <div class="card p-3 mb-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="fw-bold text-primary mb-0">📋 Senarai Tempahan</h5>
                    <small class="text-muted">Semua permohonan tempahan bilik</small>
                </div>
            </div>

            <div class="table-responsive">
                <table id="bookingsTable" class="table table-hover align-middle w-100">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>No</th>
                            <th>No Tiket</th>
                            <th>Nama</th>
                            <th>Tarikh</th>
                            <th>Masa</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($bookings->reverse()->values() as $i => $b)
                            <tr id="row-{{ $b->id }}">
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $b->ticket_no }}</td>
                                <td>{{ $b->nama_penuh }}</td>

                                <td>
                                    {{ \Carbon\Carbon::parse($b->tarikh_mula)->format('d/m/Y') }} -
                                    {{ \Carbon\Carbon::parse($b->tarikh_tamat)->format('d/m/Y') }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($b->masa_mula)->format('g:i A') }} -
                                    {{ \Carbon\Carbon::parse($b->masa_tamat)->format('g:i A') }}
                                </td>

                                <td class="location-col" title="{{ $b->location->location_name ?? '-' }}">
                                    {{ $b->location->location_name ?? '-' }}
                                </td>

                                <td class="text-center">
                                    <span class="badge 
                                                    @if($b->status == 'pending') bg-warning
                                                    @elseif($b->status == 'approved') bg-success
                                                    @else bg-danger @endif">
                                        {{ ucfirst($b->status) }}
                                    </span>
                                </td>

                                <td class="text-center">

                                    @if($b->status == 'pending')

                                        <button class="btn btn-success btn-sm approveBtn" data-id="{{ $b->id }}">
                                            Lulus
                                        </button>

                                        <button class="btn btn-danger btn-sm rejectBtn" data-id="{{ $b->id }}">
                                            Tolak
                                        </button>

                                    @endif

                                    <button class="btn btn-info btn-sm viewBtn" data-bs-toggle="modal"
                                        data-bs-target="#detailModal" data-ticket="{{ $b->ticket_no }}"
                                        data-nama="{{ $b->nama_penuh }}" data-title="{{ $b->kegunaan ?? '-' }}"
                                        data-tarikh="{{ \Carbon\Carbon::parse($b->tarikh_mula)->format('d/m/Y') }}"
                                        data-masa="{{ \Carbon\Carbon::parse($b->masa_mula)->format('g:i A') }} - {{ \Carbon\Carbon::parse($b->masa_tamat)->format('g:i A') }}"
                                        data-lokasi="{{ $b->location->location_name ?? '-' }}" data-status="{{ $b->status }}"
                                        data-catatan="{{ $b->catatan ?? '-' }}">
                                        Lihat
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- DASHBOARD -->
        <div class="card p-3">

            <!-- HEADER CHART -->
            <div class="mb-3 border-bottom pb-2">
                <h5 class="fw-bold text-primary mb-1">
                    📊 Statistik Tempahan Tahunan
                </h5>
                <small class="text-muted">
                    Paparan jumlah tempahan mengikut bulan bagi tahun semasa
                </small>
            </div>

            <div class="d-flex justify-content-between mb-3">
                @php
                    $months = [
                        1 => 'January',
                        2 => 'February',
                        3 => 'March',
                        4 => 'April',
                        5 => 'May',
                        6 => 'June',
                        7 => 'July',
                        8 => 'August',
                        9 => 'September',
                        10 => 'October',
                        11 => 'November',
                        12 => 'December'
                    ];
                @endphp

                <button id="toggleChart" class="btn btn-primary btn-sm">
                    Tukar Jenis Carta
                </button>
            </div>

            <div class="row align-items-start g-3">

                <!-- CHART -->
                <div class="col-md-5">
                    <div class="chart-box">
                        <canvas id="bookingChart"></canvas>
                    </div>

                    <!-- BUTTON BAWAH CHART -->
                    <div class="mt-3 p-2 bg-light rounded text-center">
                        <a href="{{ route('admin.report') }}" class="text-decoration-none fw-semibold">
                            📊 Buka Laporan Bulanan →
                        </a>
                    </div>
                </div>

                <!-- SUMMARY -->
                <div class="col-md-7">

                    <!-- TOTAL -->
                    <div class="card stat-card stat-total mb-3">
                        <h6 class="mb-1">Jumlah Tempahan</h6>
                        <h2 class="mb-0">{{ $bookings->count() }}</h2>
                    </div>

                    <!-- 3 SMALL CARDS -->
                    <div class="row g-3">

                        <div class="col-4">
                            <div class="card stat-card stat-pending h-100">
                                <h6 class="mb-1">Menunggu</h6>
                                <h3 class="mb-0">{{ $bookings->where('status', 'pending')->count() }}</h3>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="card stat-card stat-approved h-100">
                                <h6 class="mb-1">Diluluskan</h6>
                                <h3 class="mb-0">{{ $bookings->where('status', 'approved')->count() }}</h3>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="card stat-card stat-rejected h-100">
                                <h6 class="mb-1">Ditolak</h6>
                                <h3 class="mb-0">{{ $bookings->where('status', 'rejected')->count() }}</h3>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- MODAL -->
    <div class="modal fade" id="detailModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">

                <!-- HEADER -->
                <div class="modal-header bg-primary text-white rounded-top-4">
                    <h5 class="modal-title fw-semibold">
                        📄 Maklumat Tempahan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <!-- BODY -->
                <div class="modal-body p-4">

                    <div class="mb-3">
                        <span class="text-muted small">No Tiket</span>
                        <div class="fw-bold fs-5" id="m_ticket"></div>
                    </div>

                    <div class="mb-3">
                        <span class="text-muted small">Nama Pemohon</span>
                        <div class="fw-semibold fs-6" id="m_nama"></div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-6">
                            <span class="text-muted small">Tajuk</span>
                            <div class="fw-semibold" id="m_title"></div>
                        </div>
                        <div class="col-6">
                            <span class="text-muted small">Lokasi</span>
                            <div class="fw-semibold" id="m_lokasi"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <span class="text-muted small">Tarikh</span>
                            <div id="m_tarikh"></div>
                        </div>
                        <div class="col-6">
                            <span class="text-muted small">Masa</span>
                            <div id="m_masa"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <span class="text-muted small">Status</span>
                        <div id="m_status" class="mt-1"></div>
                    </div>

                    <div>
                        <span class="text-muted small">Catatan</span>
                        <div class="bg-light p-2 rounded mt-1" id="m_catatan"></div>
                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer border-0">
                    <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function () {

            $('#bookingsTable').DataTable({
                language: {
                    paginate: {
                        previous: "Sebelum",
                        next: "Seterus"
                    },
                    search: "Cari:",
                    lengthMenu: "Papar _MENU_ rekod",
                    info: "Paparan _START_ hingga _END_ dari _TOTAL_ rekod",
                    infoEmpty: "Tiada rekod"
                }
            });

            // VIEW MODAL
            $(document).on('click', '.viewBtn', function () {

                $('#m_ticket').text($(this).data('ticket'));
                $('#m_nama').text($(this).data('nama'));
                $('#m_title').text($(this).data('title'));
                $('#m_tarikh').text($(this).data('tarikh'));
                $('#m_masa').text($(this).data('masa'));
                $('#m_lokasi').text($(this).data('lokasi'));
                $('#m_catatan').text($(this).data('catatan'));

                let status = $(this).data('status');
                let badge = '';

                if (status === 'approved') {
                    badge = '<span class="badge bg-success">✅ Diluluskan</span>';
                } else if (status === 'rejected') {
                    badge = '<span class="badge bg-danger">❌ Ditolak</span>';
                } else {
                    badge = '<span class="badge bg-warning text-dark">⏳ Menunggu Kelulusan</span>';
                }

                $('#m_status').html(badge);
            });

            // APPROVE
            $(document).on('click', '.approveBtn', function () {
                let id = $(this).data('id');

                Swal.fire({
                    title: "Luluskan tempahan?",
                    icon: "question",
                    showCancelButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post("/admin/approve/" + id, {
                            _token: "{{ csrf_token() }}"
                        }, function () {
                            Swal.fire("Berjaya!", "Tempahan diluluskan", "success")
                                .then(() => location.reload());
                        });
                    }
                });
            });

            // REJECT
            $(document).on('click', '.rejectBtn', function () {
                let id = $(this).data('id');

                Swal.fire({
                    title: "Tolak tempahan?",
                    icon: "warning",
                    showCancelButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post("/admin/reject/" + id, {
                            _token: "{{ csrf_token() }}"
                        }, function () {
                            Swal.fire("Berjaya!", "Tempahan ditolak", "success")
                                .then(() => location.reload());
                        });
                    }
                });
            });

        });
    </script>

    <script>
        const colors = [
            '#0d6efd',
            '#198754',
            '#ffc107',
            '#dc3545',
            '#6610f2',
            '#20c997',
            '#fd7e14',
            '#0dcaf0'
        ];

        let type = 'pie';

        const ctx = document.getElementById('bookingChart');

        let chart = buildChart(type);

        function buildChart(type) {
            return new Chart(ctx, {
                type: type,
                data: {
                    labels: @json($data->pluck('month')),
                    datasets: [{
                        label: 'Jumlah Tempahan',
                        data: @json($data->pluck('total')),
                        backgroundColor: colors,
                        borderColor: type === 'bar' ? colors : undefined,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }

        document.getElementById('toggleChart').onclick = function () {
            chart.destroy();
            type = type === 'pie' ? 'bar' : 'pie';
            chart = buildChart(type);
        };
    </script>

</body>

</html>