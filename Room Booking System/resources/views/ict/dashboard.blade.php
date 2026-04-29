<!DOCTYPE html>
<html>

<head>
    <title>ICT Inventory Dashboard</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6fb;
            font-family: 'Segoe UI', sans-serif;
        }

        .header-box {
            background: linear-gradient(135deg, #0d6efd, #4e7bd9);
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin: 20px auto;
            max-width: 1100px;
        }

        #calendar {
            max-width: 1100px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .badge-status {
            font-size: 12px;
            padding: 5px 10px;
            border-radius: 20px;
        }
    </style>
</head>

<body>

    <div class="header-box text-center">
        <h3>📦 ICT Inventory System</h3>
        <p class="mb-0">Rekod keluar masuk peralatan ICT</p>
    </div>

    <div id="calendar"></div>

    <!-- MODAL -->
    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content p-3">

                <h5>➕ Tambah Rekod Pinjaman</h5>

                <input type="text" id="item_name" class="form-control mb-2" placeholder="Item (Laptop / Projector)">
                <input type="text" id="borrower" class="form-control mb-2" placeholder="Nama peminjam">
                <input type="text" id="department" class="form-control mb-2" placeholder="Jabatan">
                <input type="text" id="position" class="form-control mb-2" placeholder="Jawatan">
                <textarea id="purpose" class="form-control mb-2" placeholder="Tujuan"></textarea>

                <label>Tarikh Keluar</label>
                <input type="datetime-local" id="out_date" class="form-control mb-2">

                <label>Tarikh Pulang</label>
                <input type="datetime-local" id="return_date" class="form-control mb-3">

                <button class="btn btn-primary w-100" onclick="saveEvent()">Simpan Rekod</button>

            </div>
        </div>
    </div>

    <!-- DETAIL MODAL -->
    <div class="modal fade" id="viewModal">
        <div class="modal-dialog">
            <div class="modal-content p-3">

                <h5>📄 Detail Rekod</h5>

                <div id="detailBox"></div>

                <button class="btn btn-danger mt-3 w-100" id="deleteBtn">Padam</button>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>

        let selectedId = null;

        document.addEventListener('DOMContentLoaded', function () {

            let calendarEl = document.getElementById('calendar');

            let calendar = new FullCalendar.Calendar(calendarEl, {

                initialView: 'dayGridMonth',
                height: "auto",
                selectable: true,

                events: '/ict/events',

                // CLICK DATE
                dateClick: function (info) {
                    $('#out_date').val(info.dateStr + "T09:00");
                    $('#return_date').val(info.dateStr + "T17:00");
                    $('#addModal').modal('show');
                },

                // CLICK EVENT
                eventClick: function (info) {

                    selectedId = info.event.id;

                    let data = info.event;

                    $('#detailBox').html(`
                <p><b>Item:</b> ${data.title}</p>
                <p><b>Tarikh Mula:</b> ${data.start}</p>
                <p><b>Tarikh Pulang:</b> ${data.end ?? '-'}</p>
            `);

                    $('#viewModal').modal('show');
                }
            });

            calendar.render();

            // DELETE
            $('#deleteBtn').click(function () {

                if (!selectedId) return;

                $.post('/ict/delete/' + selectedId, {
                    _token: "{{ csrf_token() }}"
                }, function () {
                    alert('Rekod dipadam');
                    location.reload();
                });

            });

        });

        function saveEvent() {

            $.ajax({
                url: "/ict/store",
                method: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    item_name: $('#item_name').val(),
                    borrower: $('#borrower').val(),
                    department: $('#department').val(),
                    position: $('#position').val(),
                    purpose: $('#purpose').val(),
                    out_date: $('#out_date').val(),
                    return_date: $('#return_date').val(),
                },
                success: function () {
                    alert('Berjaya simpan!');
                    location.reload();
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    alert('Error simpan data');
                }
            });

        }

    </script>

</body>

</html>