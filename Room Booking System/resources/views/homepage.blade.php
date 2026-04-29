<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Tempahan Bilik</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
        }

        .dropdown-item {
            cursor: pointer;
            user-select: none;
        }

        /* Hero section */
        .hero {
            background: linear-gradient(rgba(13, 110, 253, 0.7), rgba(13, 110, 253, 0.7)), url('https://images.unsplash.com/photo-1581091870621-7755c287a223?auto=format&fit=crop&w=1950&q=80') center/cover no-repeat;
            color: white;
            height: 55vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-top: 0px;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .hero .btn {
            margin: 5px;
            padding: 12px 25px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 8px;
        }

        /* Features section */
        .features {
            padding: 60px 20px;
            background-color: #ffffff;
        }

        .features .feature-box {
            text-align: center;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            background-color: #fff;
            transition: transform 0.3s;
        }

        .features .feature-box:hover {
            transform: translateY(-5px);
        }

        .features i {
            font-size: 2.5rem;
            color: #0d6efd;
            margin-bottom: 15px;
        }

        /* FullCalendar Custom Styles */
        .fc-toolbar-title {
            font-size: 1.8rem !important;
            font-weight: 700;
            color: #0d6efd;
        }

        .fc .fc-daygrid-day {
            min-height: 80px;
            /* asal lebih kurang 100px */
        }

        .fc .fc-toolbar button {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            color: white;
            border: none;
            border-radius: 6px;
            padding: 6px 12px;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .fc .fc-toolbar button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .fc-daygrid-event .fc-event-title {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
            display: block;
        }

        .fc-daygrid-event {
            border-radius: 6px;
            padding: 2px 4px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            max-width: 100%;
        }

        .fc-daygrid-day.fc-day-has-event {
            background-color: #cfe2ff;
            /* ringan biru */
            border-radius: 6px;
        }

        .fc-daygrid-event:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .fc-day-today {
            background-color: #b6d4fe !important;
            border-radius: 6px;
        }

        .fc-event {
            color: #fff !important;
            font-size: 0.9rem;
        }

        .fc-event-title {
            white-space: normal;
        }

        @media (max-width: 768px) {
            .fc-toolbar-title {
                font-size: 1.3rem !important;
            }
        }

        /* Footer */
        footer {
            background: linear-gradient(rgba(13, 110, 253, 0.7), rgba(13, 110, 253, 0.7)), url('https://images.unsplash.com/photo-1581091870621-7755c287a223?auto=format&fit=crop&w=1950&q=80') center/cover no-repeat;
            color: white;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        footer a {
            color: #ffc107;
            text-decoration: none;
        }

        /* ===============================
   MOBILE RESPONSIVE
================================= */
        @media (max-width: 768px) {

            /* HERO */
            .hero {
                height: auto;
                padding: 60px 20px;
            }

            .hero h1 {
                font-size: 1.7rem;
                line-height: 1.4;
            }

            .hero p {
                font-size: 1rem;
            }

            .hero .btn {
                width: 100%;
                margin-bottom: 10px;
            }

            /* SEARCH MOBILE FIX */
            .search-status-section .input-group {
                display: flex;
            }

            @media (max-width:768px) {

                .search-status-section .input-group {
                    flex-wrap: wrap;
                    border-radius: 12px !important;
                    overflow: hidden;
                    background: white;
                }

                .search-status-section .form-control {
                    width: 100%;
                    flex: 0 0 100%;
                    border-radius: 12px 12px 0 0 !important;
                    min-height: 48px;
                }

                .search-status-section button {
                    width: 100%;
                    flex: 0 0 100%;
                    border-radius: 0 0 12px 12px !important;
                    min-height: 48px;
                }
            }

            /* CALENDAR */
            .fc-toolbar {
                flex-direction: column;
                gap: 10px;
            }

            .fc-toolbar-title {
                font-size: 1.2rem !important;
                text-align: center;
            }

            .fc .fc-button {
                font-size: 0.8rem;
                padding: 5px 8px;
            }

            .fc .fc-daygrid-day {
                min-height: 55px;
            }

            .fc-event {
                font-size: 0.7rem;
            }

            /* FILTER */
            .dropdown button {
                font-size: 0.95rem;
            }

            /* FEATURES */
            .feature-box {
                margin-bottom: 15px;
            }

            /* MODAL */
            .modal-dialog {
                margin: 10px;
            }

            .modal-body p {
                font-size: 0.95rem;
            }

            footer {
                font-size: 0.9rem;
                padding: 15px;
            }
        }
    </style>
</head>

<body>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <img src="{{ asset('images/logo-kkm.png') }}" alt="Logo KKM" style="height:90px; margin-bottom:15px;">
            <h1>Selamat Datang ke Sistem Tempahan Bilik <br>Hospital Enche' Besar Hajjah Khalsom Kluang</h1>
            <p>Buat tempahan bilik dengan mudah, pantas dan selamat</p>
            <div class="d-md-inline-block">
                <a href="{{ route('booking.create') }}" class="btn btn-warning text-dark">
                    Tempah Bilik Sekarang
                </a>

                <a href="{{ route('login') }}" class="btn btn-light text-dark">
                    Login Admin
                </a>
            </div>
        </div>
    </section>

    <!-- Search Status Section -->
    <section class="search-status-section py-4" style="background-color: #f0f7ff;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="input-group shadow-sm rounded-pill overflow-hidden">
                        <input type="text" id="ticketNo" class="form-control border-0"
                            placeholder="Masukkan No. Tiket anda..." autocomplete="off">
                        <button class="btn btn-primary" id="checkStatusBtn"
                            style="border-radius: 0 50px 50px 0; font-weight: 600;">
                            Semak
                        </button>
                    </div>
                    <small class="text-muted d-block mt-2 text-center">Masukkan nombor tiket untuk semak status tempahan
                        bilik anda</small>
                </div>
            </div>
        </div>
    </section>

    <!-- Calendar Section -->
    <section class="calendar-section py-5" style="background-color: #e9f2ff;">
        <div class="container">
            <h2 class="mb-4 text-center" style="font-weight: 700; color: #0d6efd;">Jadual Tempahan Bilik</h2>
            <div class="row">

                <!-- FILTER LOKASI -->
                <div class="col-md-3 mb-3">

                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white fw-bold">
                            Tapis Lokasi
                        </div>

                        <div class="card-body">

                            <div class="dropdown">

                                <button class="btn btn-light w-100 dropdown-toggle" id="locationDropdown"
                                    data-bs-toggle="dropdown">

                                    Semua Lokasi

                                </button>

                                <ul class="dropdown-menu w-100" id="locationMenu">
                                    <li>
                                        <a class="dropdown-item location-item" data-location="">
                                            <span class="badge bg-secondary me-2">●</span>
                                            Semua Lokasi
                                        </a>
                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li>
                                        <a class="dropdown-item location-item"
                                            data-location="Bilik Mesyuarat Alamanda (Aras 5)">
                                            <span style="color:#0d6efd">●</span> Bilik Mesyuarat Alamanda (Aras 5)
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item location-item"
                                            data-location="Bilik Seminar Teratai (Aras 5)">
                                            <span style="color:#20c997">●</span> Bilik Seminar Teratai (Aras 5)
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item location-item"
                                            data-location="Bilik Bincang Iris (Aras 5)">
                                            <span style="color:#6610f2">●</span> Bilik Bincang Iris (Aras 5)
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item location-item"
                                            data-location="Bilik Seminar Acacia (Aras 3)">
                                            <span style="color:#fd7e14">●</span> Bilik Seminar Acacia (Aras 3)
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item location-item"
                                            data-location="Bilik Seminar Lavender (Aras 2)">
                                            <span style="color:#6f42c1">●</span> Bilik Seminar Lavender (Aras 2)
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item location-item" data-location="Auditorium Raflesia">
                                            <span style="color:#dc3545">●</span> Auditorium Raflesia
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item location-item" data-location="Bilik Latihan IT(1)">
                                            <span style="color:#ffc107">●</span> Bilik Latihan IT(1)
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item location-item" data-location="Bilik Latihan IT(2)">
                                            <span style="color:#adb5bd">●</span> Bilik Latihan IT(2)
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item location-item" data-location="Lobi Utama">
                                            <span style="color:#0dcaf0">●</span> Lobi Utama
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item location-item" data-location="Lobi Klinik Pakar">
                                            <span style="color:#198754">●</span> Lobi Klinik Pakar
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <small class="text-muted">
                                Pilih lokasi untuk lihat tempahan bilik tertentu sahaja.
                            </small>

                        </div>
                    </div>

                </div>

                <!-- CALENDAR -->
                <div class="col-md-9">
                    <div id="bookingCalendar"
                        style="background-color:#fff;border-radius:12px;box-shadow:0 8px 20px rgba(0,0,0,0.1);padding:15px;">
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-box">
                        <i class="bi bi-check-circle"></i>
                        <h5>Tempahan Mudah</h5>
                        <p>Buat tempahan bilik dengan beberapa klik sahaja, tanpa borang manual.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <i class="bi bi-clock-history"></i>
                        <h5>Pantau Tempahan</h5>
                        <p>Semak tempahan anda dengan cepat dan dapatkan nombor tiket automatik.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <i class="bi bi-shield-lock"></i>
                        <h5>Selamat & Terjamin</h5>
                        <p>Maklumat pengguna dilindungi, tempahan dikendalikan secara selamat.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        &copy; {{ date('Y') }} Sistem Tempahan Bilik. Semua Hak Terpelihara.
        <br>
        Dibangunkan oleh <a href="#">Unit Teknologi Maklumat</a>
    </footer>

    <!-- Modal untuk event -->
    <div class="modal fade" id="eventDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="eventTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Tarikh & Masa:</strong> <span id="eventTime"></span></p>
                    <p><strong>Nama Pemohon:</strong> <span id="eventApplicant"></span></p>
                    <p><strong>Lokasi:</strong> <span id="eventLocation"></span></p>
                    <p><strong>Catatan / Kegunaan:</strong> <span id="eventNotes"></span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ticketResultModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Maklumat Tempahan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>No Tiket:</strong> <span id="resTicket"></span></p>
                    <p><strong>Tajuk:</strong> <span id="resTitle"></span></p>
                    <p><strong>Tarikh:</strong> <span id="resDate"></span></p>
                    <p><strong>Masa:</strong> <span id="resTime"></span></p>
                    <p><strong>Lokasi:</strong> <span id="resLocation"></span></p>
                    <p><strong>Status:</strong> <span id="resStatus"></span></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales/ms.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            var calendarEl = document.getElementById('bookingCalendar');

            let selectedLocation = "";

            const locationColors = {
                "Bilik Mesyuarat Alamanda (Aras 5)": "#0d6efd",
                "Bilik Seminar Teratai (Aras 5)": "#20c997",
                "Bilik Bincang Iris (Aras 5)": "#6610f2",
                "Bilik Seminar Acacia (Aras 3)": "#fd7e14",
                "Bilik Seminar Lavender (Aras 2)": "#6f42c1",
                "Auditorium Raflesia": "#dc3545",
                "Lobi Utama": "#0dcaf0",
                "Lobi Klinik Pakar": "#198754",
                "Bilik Latihan IT(1)": "#ffc107",
                "Bilik Latihan IT(2)": "#adb5bd"
            };

            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'ms',
                initialView: 'dayGridMonth',
                headerToolbar: window.innerWidth < 768 ? {
                    left: 'prev,next',
                    center: 'title',
                    right: ''
                } : {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },

                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulan',
                    week: 'Minggu',
                    day: 'Hari',
                    list: 'Senarai'
                },

                events: function (fetchInfo, successCallback, failureCallback) {
                    fetch('/booking-events')
                        .then(response => response.json())
                        .then(data => {
                            let filtered = data;
                            if (selectedLocation !== "") {
                                filtered = data.filter(event =>
                                    (event.location === selectedLocation) ||
                                    (event.extendedProps && event.extendedProps.location === selectedLocation)
                                );
                            }
                            successCallback(filtered);
                        });
                },

                eventDidMount: function (info) {
                    let lokasi = info.event.extendedProps.location;
                    if (locationColors[lokasi]) {
                        info.el.style.backgroundColor = locationColors[lokasi];
                    }
                },

                eventClick: function (info) {
                    const event = info.event;
                    document.getElementById('eventTitle').innerText = event.title;
                    document.getElementById('eventTime').innerText =
                        event.start.toLocaleString('ms-MY', { dateStyle: 'short', timeStyle: 'short' }) +
                        ' - ' +
                        (event.end ? event.end.toLocaleString('ms-MY', { dateStyle: 'short', timeStyle: 'short' }) : '');
                    document.getElementById('eventApplicant').innerText = event.extendedProps.nama_pemohon || 'Tidak Diketahui';
                    document.getElementById('eventLocation').innerText = event.extendedProps.location || 'Tidak Ditetapkan';
                    document.getElementById('eventNotes').innerText = event.extendedProps.notes || 'Tiada catatan';
                    new bootstrap.Modal(document.getElementById('eventDetailModal')).show();
                }

            });

            calendar.render();

            // FILTER LOKASI
            document.querySelectorAll(".location-item").forEach(item => {
                item.addEventListener("click", function () {
                    selectedLocation = this.dataset.location;
                    document.getElementById("locationDropdown").innerText =
                        this.innerText;
                    calendar.refetchEvents();
                });
            });
            // SEMAK TIKET
            document.getElementById('checkStatusBtn').addEventListener('click', function () {
                let ticketNo = document.getElementById('ticketNo').value.trim();

                if (ticketNo === "") {
                    alert("Sila masukkan No. Tiket!");
                    return;
                }

                fetch('/check-ticket/' + ticketNo)
                    .then(res => res.json())
                    .then(data => {

                        if (!data.found) {
                            document.getElementById("resTicket").innerText = ticketNo;
                            document.getElementById("resTitle").innerText = "-";
                            document.getElementById("resDate").innerText = "-";
                            document.getElementById("resTime").innerText = "-";
                            document.getElementById("resLocation").innerText = "-";
                            document.getElementById("resStatus").innerHTML =
                                '<span class="badge bg-danger">No tiket ini tidak wujud dalam sistem kami</span>';

                            new bootstrap.Modal(document.getElementById("ticketResultModal")).show();
                            return;
                        }

                        document.getElementById("resTicket").innerText = data.ticket_no;
                        document.getElementById("resTitle").innerText = data.title;
                        document.getElementById("resDate").innerText = data.date;
                        document.getElementById("resTime").innerText = data.time;
                        document.getElementById("resLocation").innerText = data.location;

                        let statusBadge = "";
                        if (data.status === "approved") {
                            statusBadge = '<span class="badge bg-success">✅ Diluluskan</span>';
                        } else if (data.status === "rejected") {
                            statusBadge = '<span class="badge bg-danger">❌ Ditolak</span>';
                        } else {
                            statusBadge = '<span class="badge bg-warning text-dark">⏳ Menunggu Kelulusan</span>';
                        }

                        document.getElementById("resStatus").innerHTML = statusBadge;

                        new bootstrap.Modal(document.getElementById("ticketResultModal")).show();
                    });
            });
        });
    </script>
</body>

</html>