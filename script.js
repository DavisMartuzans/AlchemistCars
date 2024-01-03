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