@extends('karyawan.layout.v-home', ['title' => 'Agenda Karyawan'])

@section('section-content')
    <style>
        .fc-event {
            cursor: pointer;
        }

        .fc-dayGrid-day.fc-day-today .fc-daygrid-day-top {
            color: #092c9f;
        }
    </style>
    @include('karyawan.layout.v-loader')
    <div class="appHeader text-light" style="background-color: #092c9f">
        <div class="left">
        </div>
        <div class="pageTitle">Agenda Karyawan</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section full mt-5">
            <div class="card">
                <div class="card-header">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="eventModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="eventModalLabel">Detail Acara</h5>
                </div>
                <form action="{{ route('employee.post.kunjungan') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <p>Mulai: <span id="startDate"></span></p>
                        <p>Selesai: <span id="endDate"></span></p>
                        <p>Lokasi: <span id="location"></span></p>
                        <p>Deskripsi: <span id="description"></span></p>
                        <input type="hidden" id="id_agenda" name="id_agenda">
                        <div id="fotoKunjunganContainer" style="display: none;">
                            <h5>Bukti Kunjungan</h5>
                            <img id="fotoKunjungan" src="" alt="" width="150px">
                        </div>
                        <div id="buktiKunjunganContainer">
                            <h5>Tambahkan Bukti Kunjungan:</h5>
                            <div class="mb-3">
                                <input type="file" accept="image/*" class="form-control" id="buktiKunjungan" name="foto_kunjungan" capture="camera">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambahkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.11/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.11/index.global.min.js'></script>
    <script src="/js/fullcalendar/locales/id.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'id',
            initialView: 'dayGridMonth',
            slotMinTime: '09:00:00',
            slotMaxTime: '17:00:00',
            events: @json($events),
            eventClick: function(info) {
                $('#eventModal .modal-title').text(info.event.title);
                $('#startDate').text(info.event.start.toLocaleString('id-ID', {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                    hour: 'numeric',
                    minute: 'numeric',
                    hour12: true
                }));
                $('#endDate').text(info.event.end.toLocaleString('id-ID', {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                    hour: 'numeric',
                    minute: 'numeric',
                    hour12: true
                }));
                $('#location').text(info.event.extendedProps.alamat);
                $('#description').text(info.event.extendedProps.description);
                $('#id_agenda').val(info.event.extendedProps.id_agenda);
                if (info.event.extendedProps.foto_kunjungan) {
                    $('#fotoKunjungan').attr('src', "{{ asset('') }}" + info.event.extendedProps.foto_kunjungan);
                    $('#fotoKunjunganContainer').show();
                    $('#buktiKunjunganContainer').hide();
                } else {
                    $('#fotoKunjunganContainer').hide();
                    $('#buktiKunjunganContainer').show();
                }
                $('#eventModal').modal('show');
            },
            buttonText: {
                today: 'Hari Ini'
            },
        });
        calendar.render();
    });
    </script>
    
@endsection
