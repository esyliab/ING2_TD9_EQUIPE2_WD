$(document).ready(function() {
    const userId = new URLSearchParams(window.location.search).get('user_id');
    const userProfile = $('#user-profile');

    if (userId) {
        $.ajax({
            url: 'get_user.php',
            method: 'GET',
            data: { user_id: userId },
            success: function(user) {
                if (user) {
                    const profileHTML = `
                        <div class="profile-card">
                            <img src="${user.profile_picture}" alt="Profile Picture" class="profile-picture">
                            <h2>${user.username}</h2>
                            <p>Nom : ${user.first_name} ${user.last_name}</p>
                            <p>Email : ${user.email}</p>
                            <p>Bio : ${user.bio}</p>
                        </div>
                    `;
                    userProfile.html(profileHTML);
                } else {
                    userProfile.html('<p>Utilisateur non trouvé</p>');
                }
            },
            error: function() {
                userProfile.html('<p>Erreur lors du chargement du profil utilisateur</p>');
            }
        });
    } else {
        userProfile.html('<p>ID utilisateur manquant</p>');
    }
});
