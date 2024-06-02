$(document).ready(function() {
    const connectionsList = $('#connections-list');
    const userId = $('#user-id').val(); // Utilisateur connecté, récupéré de la session

    // Fonction pour envoyer une demande d'ami
    window.sendFriendRequest = function(receiverId, receiverUsername) {
        $.ajax({
            url: 'add_friend.php',
            method: 'POST',
            data: { receiver_id: receiverId, receiver_username: receiverUsername },
            success: function(response) {
                if (response.success) {
                    $(`#friend-btn-${receiverId}`).prop('disabled', true).text('Demande envoyée');

                    // Ajouter une notification pour l'utilisateur connecté
                    $.ajax({
                        url: 'add_notifications.php',
                        method: 'POST',
                        data: { user_id: userId, message: `Vous avez envoyé une demande d'ami à ${receiverUsername}.` },
                        success: function(response) {
                            if (response.success) {
                                // Ajouter la notification à la liste des notifications
                                $('#notification-list').append(`<div class="notification-item"><p>Vous avez envoyé une demande d'ami à ${receiverUsername}.</p></div>`);
                            }
                        }
                    });
                } else {
                    alert(response.message || 'Votre demande a bien été envoyée');
                }
            }
        });
    };

    // Fetch and display users
    $.ajax({
        url: 'get_users.php',
        method: 'GET',
        success: function(users) {
            const userProfiles = JSON.parse(users);
            connectionsList.empty(); // Clear the list before appending new data
            userProfiles.forEach(user => {
                const userCard = $(`
                    <div class="user-card">
                        <img src="${user.profile_picture}" alt="Profile Picture" class="profile-picture">
                        <p><a href="profil.html?user_id=${user.user_id}" class="user-link">${user.username}</a></p>
                        <p>Email: ${user.email}</p>
                        <button class="btn btn-primary" id="friend-btn-${user.user_id}" onclick="sendFriendRequest(${user.user_id}, '${user.username}')">Envoyer une demande d'ami</button>
                    </div>
                `);
                connectionsList.append(userCard);
            });
        },
        error: function() {
            alert('Error fetching users');
        }
    });

    // Search function
    $('#search-btn').on('click', function() {
        const keyword = $('#search-input').val();
        $.ajax({
            url: 'search.php',
            method: 'GET',
            data: { keyword },
            success: function(users) {
                const searchResults = $('#search-results');
                searchResults.empty(); // Clear previous results
                const userProfiles = JSON.parse(users);
                if (userProfiles.length > 0) {
                    userProfiles.forEach(user => {
                        const userCard = $(`
                            <div class="search-result-card">
                                <img src="${user.profile_picture}" alt="Profile Picture" class="profile-picture">
                                <p><a href="profil.html?user_id=${user.user_id}" class="user-link">${user.username}</a></p>
                                <p>Email: ${user.email}</p>
                                <button class="btn btn-primary" id="search-friend-btn-${user.user_id}" onclick="sendFriendRequest(${user.user_id}, '${user.username}')">Envoyer une demande d'ami</button>
                            </div>
                        `);
                        searchResults.append(userCard);
                    });
                } else {
                    searchResults.append('<p>Aucun utilisateur trouvé</p>');
                }
            },
            error: function() {
                alert('Error searching users');
            }
        });
    });
});
