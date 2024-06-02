document.getElementById('jobForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Récupérer les valeurs des champs du formulaire
    const jobTitle = document.getElementById('jobTitle').value;
    const contractType = document.getElementById('contractType').value;
    const employmentType = document.getElementById('employmentType').value;
    const salary = document.getElementById('salary').value;
    const location = document.getElementById('location').value;

    // Créer un nouvel élément de liste pour afficher le job
    const jobItem = document.createElement('li');
    jobItem.textContent = `${jobTitle} - ${contractType} - ${employmentType} - ${salary}€ - ${location}`;

    // Ajouter l'élément de liste à la liste des emplois
    document.getElementById('jobList').appendChild(jobItem);

    // Réinitialiser le formulaire
    document.getElementById('jobForm').reset();

    // Afficher un message de notification sur la page avec le type de contrat
    showMessage(`Nouveau type de contrat ajouté: ${contractType} - ${employmentType}`);
});

function showMessage(message) {
    // Créer un élément de div pour le message
    const messageDiv = document.createElement('div');
    messageDiv.className = 'notification';
    messageDiv.textContent = message;

    // Ajouter le message au corps du document
    document.body.appendChild(messageDiv);

    // Utiliser un timeout pour permettre l'animation
    setTimeout(() => {
        messageDiv.classList.add('show');
    }, 10);

    // Supprimer le message après 3 secondes
    setTimeout(() => {
        messageDiv.classList.remove('show');
        setTimeout(() => {
            document.body.removeChild(messageDiv);
        }, 500); // Attendre la fin de l'animation de disparition
    }, 3000);
}

// Fonction pour afficher les notifications
function afficherNotifications() {
    // Vérifier s'il y a une nouvelle offre
    if (localStorage.getItem('nouvelleOffre')) {
        var nouvelleOffre = JSON.parse(localStorage.getItem('nouvelleOffre'));

        // Afficher la notification sur la page notifications
        var notificationsList = document.getElementById('notificationsList');
        var nouvelleNotification = document.createElement('li');
        nouvelleNotification.textContent = 'Nouvelle offre : ' + nouvelleOffre.titre;
        notificationsList.appendChild(nouvelleNotification);

        // Supprimer l'offre du localStorage après affichage de la notification
        localStorage.removeItem('nouvelleOffre');
    }
}

// Appeler la fonction d'affichage des notifications périodiquement
setInterval(afficherNotifications, 1000); // 1000ms = 1 seconde
