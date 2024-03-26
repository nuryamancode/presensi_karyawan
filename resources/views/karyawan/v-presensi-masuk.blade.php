@extends('karyawan.layout.v-home', ['title' => 'Presensi Masuk'])

@section('section-content')
    <style>
        .image-flip {
            -webkit-transform: scaleX(-1);
            -moz-transform: scaleX(-1);
            -o-transform: scaleX(-1);
            transform: scaleX(-1);
            filter: FlipH;
            -ms-filter: "FlipH";
            width: 50% !important;
            height: 100% !important;

        }

        .camera,
        .camera video {
            display: inline-block;
            border-radius: 15px;
        }
    </style>
    @include('karyawan.layout.v-loader')
    <div class="appHeader text-light" style="background-color: #092c9f">
        <div class="left">
            <a href="{{ route('employee.dashboard') }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Presensi Masuk</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section full mt-2">
            <div class="wide-block pt-2 pb-2">

                <div class="row">
                    <div class="col">
                        <div class="camera justify-content-center d-flex" id="camera"></div>
                        <div class="text-center">
                            <button class="btn btn-warning mt-2 d-none" id="repeat" onclick="repeat()">
                                <ion-icon name="repeat-outline"></ion-icon></button>
                            <button class="btn btn-success mt-2" id="take" onclick="takePhoto()">Take
                                Photo</button>
                        </div>
                    </div>
                    <form action="{{ route('employee.post.presensi.masuk') }}" method="post">
                        @csrf
                        <div class="col">
                            <h2 class="mt-2">
                                <img src="{{ asset('image/map.png') }}" width="28px" alt="Map">
                                Lokasi
                            </h2>
                            <div id="lokasi" class="mb-3"></div>
                            <input type="hidden" class="form-control" id="kordinat" name="kordinat">
                            <input type="hidden" class="form-control" id="after_camera" name="foto">
                            <input type="hidden" class="form-control" name="jam" value="{{ date('H:i:s') }}">
                            <input type="hidden" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}">
                            <div class="d-grid gap-2 mb-5">
                                <button class="btn btn-primary" id="kirim" type="submit">Kirim</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
    <script language="JavaScript">
        var responsive = window.matchMedia("(max-width: 760px)")
        if (responsive.matches) {
            Webcam.set({
                width: 350,
                height: 240,
                image_format: 'jpeg',
                jpeg_quality: 90,
                flip_horiz: true,
            });
        } else {
            Webcam.set({
                width: 490,
                height: 380,
                image_format: 'jpeg',
                jpeg_quality: 90,
                flip_horiz: true,
            });
        }
        Webcam.attach('.camera');

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert('Geolokasi tidak didukung oleh browser Anda.');
            }
        }

        getLocation();

        function showPosition(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            var koor = document.getElementById('kordinat');
            koor.value = latitude + "," + longitude;
            var apiUrl = `https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json`;

            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        var addressDetails = data.address;
                        var village = addressDetails.village || addressDetails.hamlet || '';
                        var county = addressDetails.county || addressDetails.city || '';
                        var subdivision = addressDetails.suburb || addressDetails.town || '';
                        var postcode = addressDetails.postcode || '';
                        var country = addressDetails.country || '';

                        var locationText = '';
                        if (village) locationText += village + ', ';
                        if (subdivision) locationText += subdivision + ', ';
                        if (county) locationText += county + ', ';
                        if (postcode) locationText += postcode + ', ';
                        if (country) locationText += country;

                        document.getElementById('lokasi').textContent = locationText;
                    } else {
                        document.getElementById('lokasi').textContent = 'Tidak dapat menemukan detail lokasi.';
                    }
                })
                .catch(error => {
                    console.log('Error:', error);
                });
        }

        function takePhoto() {
            Webcam.snap(function(data_uri) {
                if (responsive.matches) {
                    document.getElementById('camera').innerHTML = '<img class="image-flip" src="' + data_uri +
                        '"/>';
                } else {
                    document.getElementById('camera').innerHTML = '<img class="image-flip" src="' + data_uri +
                        '"/>';
                }
                $("#after_camera").val(data_uri);
                var base64data = $("#after_camera").val();
                $('#take').addClass('d-none');
                $('#repeat').removeClass('d-none');
            });
        }

        function repeat() {
            Webcam.attach('.camera');
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert('Lokasi kamu bermasalah');
            }
            $('#take').removeClass('d-none');
            $('#repeat').addClass('d-none');
        }
    </script>
@endsection
