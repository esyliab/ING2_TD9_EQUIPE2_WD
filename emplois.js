document.getElementById('jobForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Récupérer les valeurs des champs du formulaire
    const jobTitle = document.getElementById('jobTitle').value;
    const contractType = document.getElementById('contractType').value;
    const salary = document.getElementById('salary').value;
    const location = document.getElementById('location').value;

    // Créer un nouvel élément de liste pour afficher le job
    const jobItem = document.createElement('li');
    jobItem.textContent = `${jobTitle} - ${contractType} - ${salary}€ - ${location}`;

    // Ajouter l'élément de liste à la liste des emplois
    document.getElementById('jobList').appendChild(jobItem);

    // Réinitialiser le formulaire
    document.getElementById('jobForm').reset();

    // Afficher un message de notification sur la page
    showMessage(`Nouvelle offre d'emploi ajoutée : ${contractType}`);
});

function showMessage(message) {
    // Créer un élément de div pour le message
    const messageDiv = document.createElement('div');
    messageDiv.className = 'notification';
    messageDiv.textContent = message;

    // Ajouter le message au corps du document
    document.body.appendChild(messageDiv);

    // Supprimer le message après 3 secondes
    setTimeout(() => {
        document.body.removeChild(messageDiv);
    }, 3000);
}
