let entries = [];

function addEntry() {
    const type = document.getElementById('type').value;
    const description = document.getElementById('description').value;
    const date = document.getElementById('date').value;

    if (description && date) {
        // Envoyer les données au serveur pour les enregistrer dans la base de données
        fetch('job.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ type, description, date }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                entries.push({ type, description, date });
                entries.sort((a, b) => new Date(b.date) - new Date(a.date));
                renderEntries();
            } else {
                console.error(data.error);
            }
        })
        .catch(error => console.error('Erreur:', error));
    }
}

function renderEntries() {
    const entryList = document.getElementById('entryList');
    entryList.innerHTML = '';

    entries.forEach(entry => {
        const li = document.createElement('li');
        li.innerHTML = `<strong>${entry.type === 'formation' ? 'Formation' : 'Projet'} :</strong> ${entry.description} <em>(Date: ${entry.date})</em>`;
        entryList.appendChild(li);
    });
}

function generateCV() {
    const cvContent = document.getElementById('cvContent');
    cvContent.innerHTML = entries.map(entry => `
        <div>
            <h3>${entry.type === 'formation' ? 'Formation' : 'Projet'}</h3>
            <p>${entry.description}</p>
            <p><em>Date: ${entry.date}</em></p>
        </div>
    `).join('');

    document.getElementById('cvOutput').style.display = 'block';
}

function downloadPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    let y = 10;
    doc.setFontSize(12);
    doc.text('Mon CV', 10, y);
    y += 10;

    entries.forEach(entry => {
        doc.setFontSize(10);
        doc.text(`${entry.type === 'formation' ? 'Formation' : 'Projet'}: ${entry.description}`, 10, y);
        y += 5;
        doc.text(`Date: ${entry.date}`, 10, y);
        y += 10;
    });

    doc.save('mon_cv.pdf');
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('fileInput').addEventListener('change', displaySelectedImage);
    document.getElementById('cvButton').addEventListener('click', showCV);
});

function displaySelectedImage(event) {
    const selectedFile = event.target.files[0];
    const profileImage = document.getElementById('profileImage');
    profileImage.onload = function() {
        URL.revokeObjectURL(profileImage.src);
    }
    profileImage.src = URL.createObjectURL(selectedFile);
}

function showCV() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "data.xml", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                const xmlDoc = xhr.responseXML;
                if (xmlDoc) {
                    const formations = Array.from(xmlDoc.getElementsByTagName("formation")).map(formation => `
                        <li><strong>${formation.getElementsByTagName("titre")[0].textContent}</strong>, ${formation.getElementsByTagName("etablissement")[0].textContent}, ${formation.getElementsByTagName("annee")[0].textContent}</li>
                    `).join('');
                    const projets = Array.from(xmlDoc.getElementsByTagName("projet")).map(projet => `
                        <li><strong>${projet.getElementsByTagName("titre")[0].textContent}</strong>: ${projet.getElementsByTagName("description")[0].textContent} (${projet.getElementsByTagName("annee")[0].textContent})</li>
                    `).join('');
                    const cvDetailsContent = `
                        <h2>Formations</h2>
                        <ul>${formations}</ul>
                        <h2>Projets</h2>
                        <ul>${projets}</ul>
                    `;
                    document.getElementById('cvDetails').innerHTML = cvDetailsContent;
                    document.getElementById('cvDetails').style.display = 'block';
                } else {
                    console.error("Erreur : Le fichier XML est vide ou mal formé.");
                }
            } else {
                console.error("Erreur lors du chargement du fichier XML : " + xhr.status);
            }
        }
    };
    xhr.send();

    function fetchEntries() {
        fetch('get_entries.php')
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                } else {
                    entries = data.entries;
                    renderEntries();
                }
            })
            .catch(error => console.error('Erreur:', error));
    }
    
    // Appelez cette fonction pour charger les formations et projets au chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        fetchEntries();
    });
}
