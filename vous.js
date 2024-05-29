let entries = [];

function addEntry() {
    const type = document.getElementById('type').value;
    const description = document.getElementById('description').value;
    const date = document.getElementById('date').value;

    if (description && date) {
        entries.push({ type, description, date });
        entries.sort((a, b) => new Date(b.date) - new Date(a.date));
        renderEntries();
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
    const cvContent = document.getElementById('cvContent').innerHTML;
    const element = document.createElement('a');
    const file = new Blob([cvContent], { type: 'application/pdf' });
    element.href = URL.createObjectURL(file);
    element.download = 'mon_cv.pdf';
    document.body.appendChild(element);
    element.click();
}
