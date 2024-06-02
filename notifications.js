$(document).ready(function() {
    const notificationList = $('#notification-list');
    const userId = $('#user-id').val(); // Utilisateur connecté, récupéré de la session

    // Fetch and display notifications
    function fetchNotifications() {
        $.ajax({
            url: 'get_notifications.php',
            method: 'GET',
            data: { user_id: userId },
            success: function(notifications) {
                notificationList.empty(); // Clear previous notifications
                const notificationItems = JSON.parse(notifications);
                if (notificationItems.length > 0) {
                    notificationItems.forEach(notification => {
                        const notificationItem = $(`
                            <div class="notification-item">
                                <p>${notification.message || 'Demande d\'ami en attente'}</p>
                                ${notification.status === 'pending' ? `<button class="btn btn-primary" onclick="respondFriendRequest(${notification.connection_id}, 'accepted')">Accepter</button>
                                <button class="btn btn-secondary" onclick="respondFriendRequest(${notification.connection_id}, 'declined')">Refuser</button>` : ''}
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

    // Respond to friend request
    window.respondFriendRequest = function(requestId, response) {
        $.ajax({
            url: 'respond_friend_request.php',
            method: 'POST',
            data: { request_id: requestId, response: response },
            success: function(response) {
                if (response.success) {
                    fetchNotifications(); // Refresh notifications
                } else {
                    alert('Erreur lors de la réponse à la demande d\'ami.');
                }
            }
        });
    }

    // Fetch notifications when the page loads
    fetchNotifications();
});
