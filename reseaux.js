// reseaux.js

document.addEventListener('DOMContentLoaded', () => {
    const connectionsList = document.getElementById('connections-list');
    
    const connections = [
        { name: 'Alice Dupont', jobTitle: 'Software Engineer', profileImage: 'alice.jpg' },
        { name: 'Bob Martin', jobTitle: 'Project Manager', profileImage: 'bob.jpg' },
        { name: 'Claire Lebrun', jobTitle: 'UX Designer', profileImage: 'claire.jpg' }
        // Add more connections as needed
    ];

    connections.forEach(connection => {
        const connectionCard = document.createElement('div');
        connectionCard.classList.add('connection-card');
        
        connectionCard.innerHTML = `
            <img src="${connection.profileImage}" alt="${connection.name}" style="width:100px;height:100px;border-radius:50%;">
            <h3>${connection.name}</h3>
            <p>${connection.jobTitle}</p>
            <button class="message-btn">Message</button>
        `;

        connectionsList.appendChild(connectionCard);
    });
});
