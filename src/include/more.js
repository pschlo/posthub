function myFunction(id) {
    var dots = document.getElementById(id+"_dots");
    var moreText = document.getElementById(id+"_more");
    var btnText = document.getElementById(id);

    if (dots.style.display === "none") {
        dots.style.display = "inline";
        btnText.innerHTML = "+ Mehr anzeigen";
        moreText.style.display = "none";
    } else {
        dots.style.display = "none";
        btnText.innerHTML = "&minus; Weniger anzeigen";
        moreText.style.display = "inline";
    }
}