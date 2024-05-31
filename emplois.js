// Fonction pour créer une nouvelle offre
function creerOffre() {
    // Récupérer les données du formulaire
    var titre = document.getElementById('titre').value;
    var description = document.getElementById('description').value;

    // Stocker les données dans le localStorage
    localStorage.setItem('nouvelleOffre', JSON.stringify({ titre: titre, description: description }));

    // Rediriger vers la page notifications
    window.location.href = 'notifications.html';
}

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

// Récupération du formulaire
const jobForm = document.getElementById('jobForm');

// Récupération de la liste des emplois
const jobList = document.getElementById('jobList');

// Écouteur d'événement pour le formulaire
jobForm.addEventListener('submit', function(event) {
    event.preventDefault(); // Pour empêcher la soumission du formulaire

    // Récupération des valeurs du formulaire
    const jobTitle = document.getElementById('jobTitle').value;
    const contractType = document.getElementById('contractType').value;
    const salary = document.getElementById('salary').value;
    const location = document.getElementById('location').value;

    // Création de l'élément li contenant les informations de l'offre d'emploi
    const newJobItem = document.createElement('li');
    newJobItem.textContent = `${jobTitle} - ${contractType} - Salaire: ${salary} - Localisation: ${location}`;

    // Ajout de la nouvelle offre d'emploi à la liste
    jobList.insertBefore(newJobItem, jobList.firstChild);
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

// Récupération du formulaire
const jobForm = document.getElementById('jobForm');

// Récupération de la liste des emplois
const jobList = document.getElementById('jobList');

// Récupération du conteneur de notification
const notification = document.getElementById('notification');

// Écouteur d'événement pour le formulaire
jobForm.addEventListener('submit', function(event) {
    event.preventDefault(); // Pour empêcher la soumission du formulaire

    // Récupération des valeurs du formulaire
    const jobTitle = document.getElementById('jobTitle').value;
    const contractType = document.getElementById('contractType').value;
    const salary = document.getElementById('salary').value;
    const location = document.getElementById('location').value;

    // Création de l'élément li contenant les informations de l'offre d'emploi
    const newJobItem = document.createElement('li');
    newJobItem.textContent = `${jobTitle} - ${contractType} - Salaire: ${salary} - Localisation: ${location}`;

    // Ajout de la nouvelle offre d'emploi à la liste
    jobList.insertBefore(newJobItem, jobList.firstChild);

    // Afficher la notification
    notification.style.display = 'block';

    // Masquer la notification après 3 secondes
    setTimeout(function() {
        notification.style.display = 'none';
    }, 3000);

    // Effacer les champs du formulaire après soumission
    jobForm.reset();
});


    // Effacer les champs du formulaire après soumission
    jobForm.reset();
});
