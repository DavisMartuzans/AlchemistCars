// Gludas ritināšanas funkcija
document.addEventListener("DOMContentLoaded", makeLinksSmooth);
function makeLinksSmooth() { 
    const navLinks = document.querySelectorAll("section a"); 
  
    navLinks.forEach((link) => {
      link.addEventListener("click", smoothScroll);
    });
  }

  function smoothScroll(e) {
    e.preventDefault();
    // Dabū mērķa elementa ID no Href atribūta
    const targetId = this.getAttribute("href");

    // Atrod mērķa elementu DOM izmantojot ID
    const targetElement = document.querySelector(targetId);

    // Ja mērķa elements eksistē tad izmanto gludo ritināšanas funckiju
    if (targetElement) { 
        targetElement.scrollIntoView({ behavior: "smooth", block: "end" }); 
    }
  }

  document.addEventListener("DOMContentLoaded", makeLinksSmooth);

function makeLinksSmooth() {
    const navLinks = document.querySelectorAll("section a");

    navLinks.forEach((link) => {
        link.addEventListener("click", smoothScroll);
    });

    // Get the button that opens the modal
    var rentNowButton = document.getElementById("rent-now");
    // Get the modal
    var modal = document.getElementById("payment-popup");
    // Get the <span> element that closes the modal
    var closeBtn = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    rentNowButton.onclick = function () {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    closeBtn.onclick = function () {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

function smoothScroll(e) {
    e.preventDefault();
    const targetId = this.getAttribute("href");
    const targetElement = document.querySelector(targetId);
    if (targetElement) {
        targetElement.scrollIntoView({ behavior: "smooth", block: "end" });
    }
}
