$(document).ready(function() {
    const notificationList = $('#notification-list');

    // Function to fetch and display notifications
    function fetchNotifications() {
        $.ajax({
            url: 'get_notifications.php',
            method: 'GET',
            success: function(notifications) {
                notificationList.empty(); // Clear previous notifications
                const notificationItems = JSON.parse(notifications);
                if (notificationItems.length > 0) {
                    notificationItems.forEach(notification => {
                        const notificationItem = $(`
                            <div class="notification-item">
                                <p>${notification.message}</p>
                                <button class="btn btn-primary mark-as-read" data-notification-id="${notification.notification_id}">Marquer comme lu</button>
                            </div>
                        `);
                        notificationList.append(notificationItem);
                    });
                } else {
                    notificationList.append('<p>Aucune notification</p>');
                }
            },
            error: function() {
                notificationList.html('<p>Erreur lors du chargement des notifications</p>');
            }
        });
    }

    // Fetch notifications when the page loads
    fetchNotifications();

    // Event listener for marking notifications as read
    notificationList.on('click', '.mark-as-read', function() {
        const notificationId = $(this).data('notification-id');
        $.ajax({
            url: 'mark_notification_as_read.php',
            method: 'POST',
            data: { notification_id: notificationId },
            success: function(response) {
                if (response.success) {
                    fetchNotifications(); // Refresh notifications after marking as read
                } else {
                    alert('Erreur lors du marquage de la notification comme lue');
                }
            },
            error: function() {
                alert('Erreur lors du marquage de la notification comme lue');
            }
        });
    });
});
