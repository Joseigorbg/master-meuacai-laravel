document.getElementById("contactButton").addEventListener("click", function() {
    var contactForm = document.getElementById("contactForm");
    if (contactForm.style.display === "none" || contactForm.style.display === "") {
        contactForm.style.display = "block";
        this.textContent = "Fechar";
    } else {
        contactForm.style.display = "none";
        this.textContent = "Fale Conosco";
    }
});

