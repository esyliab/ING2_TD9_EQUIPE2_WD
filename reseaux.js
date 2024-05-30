$(document).ready(function() {
    const connectionsList = $('#connections-list');
    const userId = 1; // Replace with actual logged-in user ID

    // Fetch and display users
    $.ajax({
        url: 'get_users.php',
        method: 'GET',
        success: function(users) {
            const userProfiles = JSON.parse(users);
            connectionsList.empty(); // Clear the list before appending new data
            userProfiles.forEach(user => {
                if (user.user_id !== userId) {
                    const userCard = $(`
                        <div class="user-card">
                            <p>Pseudo: ${user.username}</p>
                            <p>Email: ${user.email}</p>
                            <button class="btn btn-primary" id="friend-btn-${user.user_id}" onclick="sendFriendRequest(${user.user_id})">Envoyer une demande d'ami</button>
                        </div>
                    `);
                    connectionsList.append(userCard);
                }
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
                        if (user.user_id !== userId) {
                            const userCard = $(`
                                <div class="search-result-card">
                                    <p>Pseudo: ${user.username}</p>
                                    <p>Email: ${user.email}</p>
                                    <button class="btn btn-primary" id="search-friend-btn-${user.user_id}" onclick="sendFriendRequest(${user.user_id})">Envoyer une demande d'ami</button>
                                </div>
                            `);
                            searchResults.append(userCard);
                        }
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

    // Send friend request function
    window.sendFriendRequest = function(receiverId) {
        $.ajax({
            url: 'add_friend.php',
            method: 'POST',
            data: { sender_id: userId, receiver_id: receiverId },
            success: function(response) {
                if (response.success) {
                    $(`#friend-btn-${receiverId}`).prop('disabled', true).text('Demande envoyée');
                    $(`#search-friend-btn-${receiverId}`).prop('disabled', true).text('Demande envoyée');
                } else {
                    alert('Erreur lors de l\'envoi de la demande.');
                }
            }
        });
    };
});
