@extends('admin.layouts.app')

@section('title', 'Notifications')

@section('content')

    <div class="container-fluid">
        <h2 class="title mt-3"><i class="fas fa-bell"></i> Notifications</h2>

        <!-- Actions -->
        <div class="d-flex justify-content-between mb-3">
            <button class="btn btn-success mark-all-read"><i class="fas fa-check-circle"></i> Mark All as Read</button>
            <button class="btn btn-danger delete-all"><i class="fas fa-trash"></i> Delete All</button>
        </div>

        <!-- Notifications List -->
        @if($notifications->isEmpty())
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> No notifications at the moment.
            </div>
        @else
            <div class="row">
                @foreach($notifications as $notification)
                    <div class="col-md-12">
                        <div class="card shadow-sm mb-3 {{ !$notification->is_read ? 'bg-light' : 'bg-white' }}">
                            <div class="card-body d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas {{ getNotificationIcon($notification->type) }} fa-2x text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-1">{{ $notification->type }}</h5>
                                    <p class="card-text text-muted mb-0">{{ $notification->content }}</p>
                                    <small class="text-muted">{{ date('Y-m-d h:i A', strtotime($notification->date)) }}</small>
                                </div>
                                <div class="text-end">
                                    <button class="btn btn-warning btn-sm mark-read" data-id="{{ $notification->notification_id }}" {{ $notification->is_read ? 'disabled' : '' }}>
                                        <i class="fas fa-check"></i> Mark as Read
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-notification" data-id="{{ $notification->notification_id }}">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

@endsection

@push('js')
    <script>
        // Mark Notification as Read
        document.querySelectorAll('.mark-read').forEach(button => {
            button.addEventListener('click', function () {
                let notificationId = this.getAttribute('data-id');
                fetch("{{ route('admin.notifications.read') }}", {
                    method: "POST",
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                    body: JSON.stringify({ notification_id: notificationId })
                }).then(response => response.json()).then(data => {
                    if (data.success) location.reload();
                    else alert('Error updating notification.');
                });
            });
        });

        // Delete Notification
        document.querySelectorAll('.delete-notification').forEach(button => {
            button.addEventListener('click', function () {
                let notificationId = this.getAttribute('data-id');
                fetch("{{ route('admin.notifications.delete') }}", {
                    method: "POST",
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                    body: JSON.stringify({ notification_id: notificationId })
                }).then(response => response.json()).then(data => {
                    if (data.success) location.reload();
                    else alert('Error deleting notification.');
                });
            });
        });

        // Mark All as Read
        document.querySelector('.mark-all-read').addEventListener('click', function () {
            fetch("{{ route('admin.notifications.readAll') }}", {
                method: "POST",
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': "{{ csrf_token() }}" }
            }).then(response => response.json()).then(data => {
                if (data.success) location.reload();
                else alert('Error marking notifications as read.');
            });
        });

        // Delete All Notifications
        document.querySelector('.delete-all').addEventListener('click', function () {
            if (confirm('Are you sure you want to delete all notifications?')) {
                fetch("{{ route('admin.notifications.deleteAll') }}", {
                    method: "POST",
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': "{{ csrf_token() }}" }
                }).then(response => response.json()).then(data => {
                    if (data.success) location.reload();
                    else alert('Error deleting notifications.');
                });
            }
        });
    </script>
@endpush
