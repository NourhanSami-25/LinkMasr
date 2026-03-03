document.addEventListener("DOMContentLoaded", function () {
    const notificationsContainer = document.getElementById("notifications-container");
    const notificationCountElement = document.getElementById("notification-count");
    const unreadCountElement = document.getElementById("unread-notifications-count");
    const markAsReadButton = document.getElementById("markAsReadButton");

    // Function to fetch notifications
    async function fetchNotifications() {
        try {
            const response = await fetch('/notifications/latest');
            const notifications = await response.json();

            // Filter unread notifications
            const unreadNotifications = notifications.filter(notification => notification.read_at == null);

            // Update notification count
            const unreadCount = unreadNotifications.length;
            notificationCountElement.innerText = unreadCount;
            unreadCountElement.innerText = `${unreadCount} unread`;

            // Add red circle with new unread count
            if (unreadCount > 0) {
                notificationCountElement.classList.add('badge', 'badge-circle', 'badge-danger');
            } else {
                notificationCountElement.style.display = 'none';
            }



            // Render notifications list
            notificationsContainer.innerHTML = unreadCount > 0 ? '' : '<span class="text-muted">No unread notifications</span>';
            for (let i = 0; i < Math.min(20, notifications.length); i++) {
                const notification = notifications[i];
                const isRead = notification.read_at !== null; // Check if the notification is read
                const textColorClass = isRead ? 'text-gray-500' : 'text-gray-800'; // Different class for read/unread

                notificationsContainer.innerHTML += `
                    <div class="d-flex flex-stack py-4 notification-item ${isRead ? 'read' : 'unread'}" data-id="${notification.id}">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-35px me-4">
                                <span class="symbol-label bg-light-primary">
                                    <i class="ki-outline ki-notification fs-2 text-primary"></i>
                                </span>
                            </div>
                            <div class="mb-0 me-2">
                                <div class="fs-6 ${textColorClass} fw-semibold">
                                    <span class="badge ${notification.read_at == null ? 'bg-danger' : 'bg-secondary'} text-white me-2">
                                        ${notification.read_at == null ? 'Unread' : 'Read'}
                                    </span> ${notification.data['subject']}
                                </div>
                                <div class="${textColorClass} fs-12 fw-semibold">
                                    ${new Date(notification.created_at).toLocaleTimeString()}
                                    <a href="${notification.data['url']}" target="_blank">
                                        ${notification.data['url'] == 'none' ? '' : ''}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
        } catch (error) {
            console.error("Error fetching notifications:", error);
        }
    }

    // Mark the latest 20 notifications as read
    async function markNotificationsAsRead() {
        try {
            const response = await fetch('/notifications/mark-as-read-latest', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            });

            if (response.ok) {
                // Update UI: Mark the first 20 notifications in the list as read
                const notificationItems = document.querySelectorAll('.notification-item.unread');
                for (let i = 0; i < Math.min(20, notificationItems.length); i++) {
                    const item = notificationItems[i];
                    item.classList.remove('unread');
                    item.classList.add('read');
                    const textElements = item.querySelectorAll('.text-gray-800');
                    textElements.forEach(el => {
                        el.classList.remove('text-gray-800'); // Remove unread class
                        el.classList.add('text-gray-500'); // Add read class
                    });
                }

                console.log('Notifications marked as read.');
            } else {
                console.error('Failed to mark notifications as read.');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    // Attach event listener to the "Mark As Read" button
    if (markAsReadButton) {
        markAsReadButton.addEventListener('click', markNotificationsAsRead);
    }

    // Fetch notifications every 30 seconds
    fetchNotifications(); // Initial fetch
    setInterval(fetchNotifications, 30000); // Fetch every 30 seconds
});
