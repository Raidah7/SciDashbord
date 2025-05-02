@extends('front.layouts.app')

@section('title', 'Contact Us')

@section('content')

    <div class="container my-5">
        <h2 class="text-center fw-bold text-primary mb-4"><i class="fas fa-phone-alt"></i> Contact Us</h2>

        <!-- Contact Information Boxes -->
        <div class="row text-center">
            <!-- Phone -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm p-4">
                    <i class="fas fa-phone fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold">Phone</h5>
                    <p class="text-muted">+966 55 123 4567</p>
                </div>
            </div>

            <!-- Email -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm p-4">
                    <i class="fas fa-envelope fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold">Email</h5>
                    <p class="text-muted">info@example.com</p>
                </div>
            </div>

            <!-- Location -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm p-4">
                    <i class="fas fa-map-marker-alt fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold">Location</h5>
                    <p class="text-muted">Najran, Saudi Arabia</p>
                </div>
            </div>
        </div>

        <!-- Google Map -->
        <div class="card shadow-sm p-4 mt-4">
            <h5 class="fw-bold mb-3"><i class="fas fa-map"></i> Find Us on the Map</h5>
            <div id="map" style="height: 400px;">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3005.2367621442486!2d44.52965027517059!3d17.633929883295906!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x15ff2e6dbbb00b4b%3A0xa42cb1175c145d9e!2sNajran%20University!5e1!3m2!1sen!2seg!4v1744540358250!5m2!1sen!2seg" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
    {{--    function initMap() {--}}
    {{--        var najran = { lat: 17.4933, lng: 44.1277 }; // Najran coordinates--}}
    {{--        var map = new google.maps.Map(document.getElementById('map'), {--}}
    {{--            zoom: 12,--}}
    {{--            center: najran--}}
    {{--        });--}}
    {{--        var marker = new google.maps.Marker({--}}
    {{--            position: najran,--}}
    {{--            map: map,--}}
    {{--            title: "Najran, Saudi Arabia"--}}
    {{--        });--}}
    {{--    }--}}
    {{--</script>--}}

    {{--<!-- Google Maps API -->--}}
    {{--<script src="https://maps.googleapis.com/maps/api/js?&callback=initMap" async defer></script>--}}
@endpush
