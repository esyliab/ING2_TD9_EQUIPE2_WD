$(document).ready(function() {
    const notificationList = $('#notification-list');

    // Fonction pour récupérer et afficher les notifications
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