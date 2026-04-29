<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <title>Laporan Tempahan Bulanan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <style>
        body {
            background: #eef2f7;
            font-family: 'Segoe UI', sans-serif;
            padding-bottom: 40px;
        }

        .summary-card {
            border-radius: 14px;
            transition: 0.2s ease;
            color: white;
        }

        .summary-card:hover {
            transform: translateY(-4px);
        }

        .header-logo {
            width: 70px;
            height: 70px;
            object-fit: contain;
            margin-right: 15px;
        }

        .header-wrap {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .report-container {
            max-width: 1200px;
            margin: auto;
        }

        .card-box {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .header-title {
            font-weight: 700;
            color: #0d6efd;
        }

        .filter-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
        }

        .bg-total {
            background: #0d6efd;
        }

        .bg-approved {
            background: #198754;
        }

        .bg-rejected {
            background: #dc3545;
        }

        .table thead {
            background: #0d6efd;
            color: white;
        }

        .section-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }

        .footer {
            font-size: 12px;
            color: gray;
            text-align: right;
            margin-top: 15px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            transition: 0.2s ease;
        }
    </style>
</head>

<body>
    <div class="report-container mt-4">

        <!-- HEADER -->
        <div class="card-box mb-3">
            <div class="d-flex justify-content-between align-items-center">

                <div class="header-wrap">
                    <img src="{{ asset('images/logo-kkm.png') }}" class="header-logo">

                    <div>
                        <h4 class="header-title mb-1">
                            Laporan Tempahan Bilik
                        </h4>

                        <small class="text-muted">
                            Hospital Enche' Besar Hajjah Khalsom, Kluang
                        </small>
                    </div>
                </div>

                <div class="text-end">
                    <small class="text-muted">
                        {{ \Carbon\Carbon::now('Asia/Kuala_Lumpur')->format('d/m/Y h:i A') }}
                    </small>
                </div>

            </div>
        </div>

        <!-- FILTER -->
        <div class="card-box mb-3">
            <div class="section-title">🔎 Penapis Laporan</div>

            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Bulan</label>
                    <select name="month" class="form-select">
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Tahun</label>
                    <select name="year" class="form-select">
                        @for($y = date('Y'); $y >= 2024; $y--)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary w-100">Tapis</button>
                </div>
            </form>
        </div>

        <!-- CHART -->
        <div class="card-box mb-3">

            <div class="section-title mb-3">📊 Statistik Tempahan</div>

            <!-- CHART -->
            <div style="height:320px;" class="mb-4">
                <canvas id="reportChart"></canvas>
            </div>

            <hr class="mb-4">

            <!-- SUMMARY -->
            <div class="row g-3">

                <div class="col-md-4">
                    <div class="summary-card bg-total text-center py-4 shadow-sm">
                        <h6 class="mb-1">Jumlah Tempahan</h6>

                        <small class="d-block opacity-75 mb-2">
                            {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $year }}
                        </small>

                        <h2 class="fw-bold mb-0">{{ $summary['total'] }}</h2>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="summary-card bg-approved text-center py-4 shadow-sm">
                        <h6 class="mb-1">Diluluskan</h6>

                        <small class="d-block opacity-75 mb-2">
                            {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $year }}
                        </small>

                        <h2 class="fw-bold mb-0">{{ $summary['approved'] }}</h2>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="summary-card bg-rejected text-center py-4 shadow-sm">
                        <h6 class="mb-1">Ditolak</h6>

                        <small class="d-block opacity-75 mb-2">
                            {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $year }}
                        </small>

                        <h2 class="fw-bold mb-0">{{ $summary['rejected'] }}</h2>
                    </div>
                </div>

            </div>
        </div>

        <!-- TABLE BULAN -->
        <div class="card-box mb-3">
            <div class="section-title">📅 Laporan Mengikut Bulan</div>

            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Jumlah</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($chart as $d)
                        <tr>
                            <td>{{ $d->month }}</td>
                            <td><strong>{{ $d->total }}</strong></td>
                            <td>
                                <a href="{{ route('admin.report.pdf', ['month' => date('n', strtotime($d->month)), 'year' => $year]) }}"
                                    class="btn btn-sm btn-primary">
                                    📄 Print
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- DETAIL TABLE -->
        <div class="card-box">
            <div class="section-title">📄 Detail Tempahan ({{ date('F', mktime(0, 0, 0, $month, 1)) }})</div>

            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tarikh</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $i => $b)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $b->nama_penuh }}</td>
                            <td>{{ \Carbon\Carbon::parse($b->tarikh_mula)->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge
                                            @if($b->status == 'approved')
                                                bg-success
                                            @elseif($b->status == 'pending')
                                                bg-warning text-dark
                                            @else
                                                bg-danger
                                            @endif">

                                    {{ $b->status == 'approved' ? 'Diluluskan' : ($b->status == 'pending' ? 'Menunggu' : 'Ditolak') }}

                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-start mt-4">
                <a href="{{ route('admin.home') }}"
                    class="btn btn-primary px-4 py-2 shadow-sm rounded-pill fw-semibold">
                    ← Kembali ke Halaman Admin
                </a>
            </div>

            <div class="footer">
                Dijana pada: {{ \Carbon\Carbon::now('Asia/Kuala_Lumpur')->format('d/m/Y H:i') }}
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('reportChart');

        const colors = [
            '#0d6efd', // Jan
            '#198754', // Feb
            '#ffc107', // Mar
            '#dc3545', // Apr
            '#6610f2', // May
            '#20c997', // Jun
            '#fd7e14', // Jul
            '#0dcaf0', // Aug
            '#6f42c1', // Sep
            '#198754', // Oct
            '#fd7e14', // Nov
            '#dc3545'  // Dec
        ];

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chart->pluck('month')),
                datasets: [{
                    label: 'Jumlah Tempahan',
                    data: @json($chart->pluck('total')),
                    backgroundColor: colors,
                    borderColor: colors,
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return ' ' + context.raw + ' tempahan';
                            }
                        }
                    }
                },

                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        });
    </script>

</body>

</html>