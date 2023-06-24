<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

    <style>
        .vertical-line {
            border-left: 1px solid #ccc; /* Измените цвет и стиль черты по вашему выбору */
            height: 100%;
        }

        .members_title {
            display: none;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <p class="animation__shake">Restful API</p>
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
            <span class="brand-text font-weight-light">Restful API</span>
        </a>
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="d-flex align-items-center justify-content-end">
            <span class="mr-3 text-nowrap">Имя пользователя</span>
            <a class="dropdown-item text-primary" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                {{ __('Выйти') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
        <div class="content-wrapper">
            <div class="row">
                <div class="col">
                    <h3>Все события</h3>
                    <div id="event-list">
                        @foreach($events as $event)
                                <?php $isMember = false; ?>
                            @foreach($event->members as $member)
                                @if($member->id == auth()->id())
                                        <?php $isMember = true; ?>
                                @endif
                            @endforeach
                            <div><a class="text-primary"
                                    onclick="showEvent('{{ $event->id }}', '{{ $event->title }}', '{{ $event->text }}', '{{ $event->created_at }}',  {{ $event->members }}, {{ $isMember }})">{{ $event->title }}</a>
                            </div>
                        @endforeach
                    </div>
                    <h3>Мои события</h3>
                    @foreach($myEvents as $myEvent)
                            <?php $isMember = false; ?>
                        @foreach($myEvent->members as $member)
                            @if($member->id == auth()->id())
                                    <?php $isMember = true; ?>
                            @endif
                        @endforeach
                        <div><a class="text-primary"
                                onclick="showEvent('{{ $event->id }}', '{{ $myEvent->title }}', '{{ $myEvent->text }}', '{{ $myEvent->created_at }}', {{ $myEvent->members }}, {{ $isMember }})">{{ $myEvent->title }}</a>
                        </div>
                    @endforeach
                </div>
                <div class="col d-flex align-items-center">
                    <div class="vertical-line"></div>
                </div>
                <div class="col">
                    <h3 class="title_event"></h3>
                    <p class="text_event"></p>
                    <p class="date_event"></p>
                    <h3 class="members_title" id="members_title">Участники</h3>
                    <div class="members_list"></div>

                    <button style="display: none" id="join_button" onclick="joinEvent(eventId)">Принять
                        участие
                    </button>

                    <button style="display: none" id="leave_button" onclick="leaveEvent(eventId)">Отказаться от участия
                    </button>

                </div>
                <div class="col d-flex align-items-center">
                    <div class="vertical-line"></div>
                </div>
                <div class="col" id="member-info">
                    <h2 id="member-name"></h2>
                    <p id="member-email"></p>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2014-{{ now()->year }} <a href="#">RestFul API</a>.</strong>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    var eventMembersAll = [];
    var eventId;

    function updateMemberInfo(memberId) {
        var member = eventMembersAll.find(function (member) {
            return member.id == memberId;
        });

        $('#member-name').text(member.name + ' ' + member.last_name);
        $('#member-email').text(member.email);

        $('#member-info').show();
    }

    $('.members_list').on('click', '.member-link', function () {
        console.log(1111)
        var memberId = $(this).data('id');
        updateMemberInfo(memberId);
    });

    function showEvent(eventId, eventTitle, eventText, eventDate, eventMembers, isMember) {
        $('.title_event').text(eventTitle);
        $('.text_event').text(eventText);
        $('.date_event').text(eventDate);
        $('.members_list').html('');
        $('#member-info').hide();
        eventMembersAll = eventMembers;
        window.eventId = eventId;

        var membersTitle = document.getElementById("members_title");
        membersTitle.style.display = "block";

        var joinButton = document.getElementById("join_button");
        var leaveButton = document.getElementById("leave_button");

        if (isMember) {
            joinButton.style.display = "none";
            leaveButton.style.display = "block";
        } else {
            joinButton.style.display = "block";
            leaveButton.style.display = "none";
        }

        for (var i = 0; i < eventMembers.length; i++) {
            var member = eventMembers[i];
            var memberHtml = '<div><a class="text-primary member-link" data-id="' + member.id + '">' + member.name + ' ' + member.last_name + '</a></div>';
            $('.members_list').append(memberHtml);
        }
    }

    function joinEvent(eventId) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/join-event',
            method: 'POST',
            dataType: 'json',
            data: {
                eventId: eventId
            },
            success: function(data) {
                var joinButton = document.getElementById("join_button");
                var leaveButton = document.getElementById("leave_button");
                joinButton.style.display = "none";
                leaveButton.style.display = "block";
                showEvent(data.eventId, data.eventTitle, data.eventText, data.eventDate, data.eventMembers, data.isMember)
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    function leaveEvent(eventId) {
        console.log(eventId)
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/leave-event',
            method: 'POST',
            dataType: 'json',
            data: {
                eventId: eventId
            },
            success: function(data) {
                var joinButton = document.getElementById("join_button");
                var leaveButton = document.getElementById("leave_button");
                joinButton.style.display = "block";
                leaveButton.style.display = "none";
                showEvent(data.eventId, data.eventTitle, data.eventText, data.eventDate, data.eventMembers, data.isMember)
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    function updateEventList() {
        $.ajax({
            url: '/events',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var eventList = $('#event-list');
                eventList.empty();
                $.each(data.events, function(i, event) {
                    var isMember = false;
                    $.each(event.members, function(j, member) {
                        if (member.id == data.currentUserId) {
                            isMember = true;
                        }
                    });
                    var link = $('<a>').addClass('text-primary')
                        .attr('onclick', `showEvent('${event.id}', '${event.title}', '${event.text}', '${event.created_at}', ${JSON.stringify(event.members)}, ${isMember})`)
                        .text(event.title);
                    var item = $('<div>').append(link);
                    eventList.append(item);
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Ошибка при обновлении списка событий: ', errorThrown);
            }
        });
    }

    setInterval(updateEventList, 10000);
</script>
</body>
</html>
