$(document).ready(function() {
    function validateSearch() {
        var searchInput1 = $("#s-name").val();
        var searchInput2 = $("#s-status").val();
        var searchInput3 = $("#s-url").val();
        if (searchInput1.trim() === "" && searchInput2.trim() === "" && searchInput3.trim() === "") {
            alert("Veuillez remplir au moins un champ de recherche !");
            return false;
        }

        return true;
    }

    $("#button-serach").click(function() {
        return validateSearch();
    });
});