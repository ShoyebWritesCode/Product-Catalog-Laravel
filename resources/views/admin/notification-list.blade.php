<ul class="list-group">
    @foreach ($notifications as $notification)
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
          <input type="checkbox" class="mr-2 notification-checkbox" data-id="{{ $notification->id }}">
          <form method="POST" action="{{ route('admin.notifications.markAsRead', $notification->id) }}" class="d-flex flex-grow-1 align-items-center">
            @csrf
            <button type="submit" class="btn btn-link p-0 text-left flex-grow-1" style="color: black;">
              <i class="fas fa-shopping-cart"></i>
              @if ($notification->read_at === null)
                <strong>Order no.#{{ $notification->data['order_id'] }} placed. Total: {{ $notification->data['order_total'] }} BDT </strong>
              @else
                Order no.#{{ $notification->data['order_id'] }} placed. Total: {{ $notification->data['order_total'] }} BDT
              @endif
            </button>
            <span class="text-muted text-sm ml-5">{{ $notification->created_at->diffForHumans() }}</span>
          </form>
        </div>
        <div>
          <a href="{{ route('admin.order.show', $notification->data['order_id']) }}" class="btn btn-link view-order" data-notification-id="{{ $notification->id }}">
            <i class="fas fa-eye"></i>
          </a>
          <form method="POST" action="{{ route('admin.notifications.delete', $notification->id) }}" class="inline delete-notification-form" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-link text-danger delete-notification-btn"><i class="fas fa-trash"></i></button>
          </form>          
        </div>
      </li>
    @endforeach
  </ul>

  @section('js')
  <script>

document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-notification-btn');

    deleteButtons.forEach(button => {
      button.addEventListener('click', function(event) {
        event.preventDefault();

        if (confirm('Are you sure you want to delete this notification?')) {
          const form = this.closest('form');
          const url = form.action;

          fetch(url, {
            method: 'DELETE',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
          })
          .then(response => {
            if (response.ok) {
              console.log('Notification deleted successfully');
              location.reload();
            } else {
              console.error('Failed to delete notification');
            }
          })
          .catch(error => {
            console.error('Error deleting notification:', error);
          });
        }
      });
    });
  });



    document.addEventListener('DOMContentLoaded', function() {
      const viewOrderLinks = document.querySelectorAll('.view-order');
  
      viewOrderLinks.forEach(link => {
        link.addEventListener('click', function(event) {
          event.preventDefault();
  
          // Get notification ID from data attribute
          const notificationId = this.getAttribute('data-notification-id');
          const markAsReadUrl = "{{ route('admin.notifications.markAsRead', ':notificationId') }}";
          const url = markAsReadUrl.replace(':notificationId', notificationId);
          const csrfToken = document.head.querySelector('meta[name="csrf-token"]').getAttribute('content');



          fetch(url, {
            method: 'POST', 
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({
              notification_id: notificationId
            })
          })
          .then(response => {
            console.log('Marked as read:', response);
            window.location.href = this.getAttribute('href');
          })
          .catch(error => {
            console.error('Error marking as read:', error);
            window.location.href = this.getAttribute('href');
          });
        });
      });
    });
  </script>
@stop    


