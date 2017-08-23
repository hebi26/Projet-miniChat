$(document).ready(function () {
    $('#parallax').jparallax();


// script pour recharger la page toutes les minutes
    function refresh() { //function qui rafraichit
        window.location.reload();
    }

    function reload() { //function qui execute le rafraichissement toutes les minutes
        var time = 100000;
        setTimeout("refresh();", time);
    }

    reload();
});
