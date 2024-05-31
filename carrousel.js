$(document).ready(function() {
    var currentIndex = 0;
    var items = $('#carrousel ul li');
    var itemCount = items.length;
    var timeoutID;

    items.eq(currentIndex).show();

    function afficherImageSuivante() {
        items.eq(currentIndex).hide();
        currentIndex = (currentIndex + 1) % itemCount;
        items.eq(currentIndex).show();
        resetTimeout();
    }

    function afficherImagePrecedente() {
        items.eq(currentIndex).hide();
        currentIndex = (currentIndex - 1 + itemCount) % itemCount;
        items.eq(currentIndex).show();
        resetTimeout();
    }

    $('#precedent').click(afficherImagePrecedente);
    $('#suivant').click(afficherImageSuivante);

    function resetTimeout() {
        clearTimeout(timeoutID);
        timeoutID = setTimeout(afficherImageSuivante, 5000); // Défilement automatique après 5 secondes
    }

    resetTimeout();
});