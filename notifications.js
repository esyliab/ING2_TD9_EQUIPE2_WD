$(document).ready(function() {
    const notificationList = $('#notification-list');

    // Function to fetch and display notifications
    function fetchNotifications() {
        $.ajax({
            url: 'notifications.php',
            method: 'GET',
            success: function(notifications) {
                notificationList.empty(); // Clear previous notifications
                const notificationItems = JSON.parse(notifications);
                if (notificationItems.length > 0) {
                    notificationItems.forEach(notification => {
                        const notificationItem = $(`
                            <div class="notification-item">
                                <p>${notification.message || 'Demande d\'ami en attente'}</p>
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
});
