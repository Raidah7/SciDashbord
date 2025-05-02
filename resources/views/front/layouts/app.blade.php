<!doctype html>
<html>
<head>
    <title>SciDashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('logo.png') }}">
    <link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('front/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/fonts/icomoon/style.css') }}">
    <link rel="stylesheet" href="{{ asset('front/fonts/flaticon/font/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('front/custom.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    @stack('css')
    <style>
        .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
            color: #fff;
            background-color: #5e6d7d;
        }

        .chat-message.bot-message {
            margin-bottom: 10px;
        }
        #loading-msg i {
            margin-right: 5px;
        }

    </style>
</head>
<body>
@include('front.layouts.header')
<main>
    @yield('content')
</main>
@include('front.layouts.footer')
<!-- Floating Chat Button -->
<div id="chat-icon" class="chat-icon">
    <i class="fas fa-comment-dots"></i>
</div>

<!-- Chatbox -->
<div id="chat-box" class="chat-box">
    <div class="chat-header">
        <h5><i class="fas fa-robot"></i> Ask AI</h5>
        <button id="close-chat" class="close-chat">&times;</button>
    </div>
    <div class="chat-body">
        <div class="chat-message bot-message">
            <i class="fas fa-lightbulb"></i> You can ask about scientific research!
        </div>
        <div id="chat-messages"></div>
    </div>
    <div class="chat-footer">
        <input type="text" id="chat-input" class="chat-input" placeholder="Ask about scientific research...">
        <button id="send-chat" class="send-chat"><i class="fas fa-paper-plane"></i></button>
    </div>
</div>

<script src="{{ asset('front/js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('front/js/popper.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="{{ asset('front/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('front/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('front/js/jquery.animateNumber.min.js') }}"></script>
<script src="{{ asset('front/js/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('front/js/jquery.fancybox.min.js') }}"></script>
<script src="{{ asset('front/js/aos.js') }}"></script>
<script src="{{ asset('front/js/moment.min.js') }}"></script>
<script src="{{ asset('front/js/daterangepicker.js') }}"></script>
<script src="{{ asset('front/js/typed.js') }}"></script>
@stack('js')
<script src="{{ asset('front/js/custom.js') }}"></script>
<script>
    let lastScrollTop = 0;
    window.addEventListener("scroll", function () {
        let topHeader = document.getElementById("topHeader");
        let mainHeader = document.getElementById("mainHeader");
        let scrollTop = window.scrollY;

        if (scrollTop > lastScrollTop) {
            // Hide top header and make main header fixed
            topHeader.style.display = "none";
            mainHeader.classList.add("sticky-header");
        } else {
            // Show top header when scrolling up
            topHeader.style.display = "block";
            mainHeader.classList.remove("sticky-header");
        }
        lastScrollTop = scrollTop;
    });
</script>

<script>
    $(document).ready(function() {
        // Open chatbox
        $('#chat-icon').click(function() {
            $('#chat-box').fadeIn();
        });

        // Close chatbox
        $('#close-chat').click(function() {
            $('#chat-box').fadeOut();
        });

        $('#send-chat').click(function() {
            sendMessage();
        });

        $('#chat-input').keypress(function(e) {
            if (e.which === 13) { // Enter key
                sendMessage();
            }
        });
        function sendMessage() {
            let message = $('#chat-input').val().trim();
            if (message === '') return;

            $('#chat-messages').append(`<div class="chat-message user-message">${message}</div>`);
            $('#chat-input').val('');

            // Disable button and show loading spinner
            $('#send-chat')
                .prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin"></i>');

            // Show thinking message
            let loadingMsg = $('<div class="chat-message bot-message" id="loading-msg"><i class="fas fa-spinner fa-spin"></i> Thinking...</div>');
            $('#chat-messages').append(loadingMsg);

            $.ajax({
                url: "{{ route('chat.gemini') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "message": message
                },
                success: function(response) {
                    $('#loading-msg').remove();
                    $('#chat-messages').append(`<div class="chat-message bot-message">${response}</div>`);
                },
                error: function() {
                    $('#loading-msg').remove();
                    $('#chat-messages').append(`<div class="chat-message bot-message text-danger">Error processing request.</div>`);
                },
                complete: function() {
                    $('#send-chat')
                        .prop('disabled', false)
                        .html('<i class="fas fa-paper-plane"></i>');
                }
            });
        }


    });
</script>
@yield('scripts')
</body>
</html>
