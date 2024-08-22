<!-- resources/views/layouts/footer.blade.php -->
<footer class="footer">
    <div class="footer-content d-flex justify-content-between align-items-center">
        <div class="footer-info">
            <p>Meu Açaí - Todos os direitos reservados Copyright</p>
            <p><a href="https://mail.google.com/mail/?view=cm&fs=1&to=meucai.ceo@gmail.com" target="_blank" class="email-link">meucai.ceo@gmail.com</a></p>
            <button id="contactButton" class="contact-button">Fale Conosco</button>
            <div id="contactForm" class="contact-form" style="display: none;">
                <form class="responsive-form" action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <div>
                        <label for="nome">Nome:</label>
                        <input class="custom-input" type="text" id="nome" name="nome" required>
                    </div>
                    <div>
                        <label for="telefone">Telefone (WhatsApp):</label>
                        <input class="custom-input" type="tel" id="telefone" name="telefone" required>
                    </div>
                    <div>
                        <label for="assunto">Descreva o assunto:</label>
                        <textarea class="custom-input" id="assunto" name="assunto" required style="width: 220px; height: 99px;"></textarea>
                    </div>
                    <input class="custom-input" type="submit" value="Enviar">
                </form>
            </div>
        </div>
        <div class="social-icons">
            <div class="footer-logo">
                <a class="navbar-brand logo" href="{{ route('home') }}">
                    <img src="{{ asset('img/LogoSite.png') }}" alt="Logo" class="footer-navbar-logo">
                </a>
            </div>
            <a href="https://www.facebook.com/profile.php?id=61560979948527&locale=pt_BR" target="_blank" class="social-icon">
                <i class="bi bi-facebook"></i>
            </a>
            <a href="https://www.instagram.com/meu_acai_com/" target="_blank" class="social-icon">
                <i class="bi bi-instagram"></i>
            </a>
        </div>
    </div>
</footer>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">

<style>
.footer {
    padding: 20px;
    background-color: #f8f9fa;
}

.footer-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.footer-logo img.footer-navbar-logo {
    height: 30px;
}

.footer-info {
    text-align: center;
}

.social-icons {
    display: flex;
    gap: 15px;
}

.social-icon i {
    font-size: 30px;
    color: #ffff;
    transition: color 0.3s;
}

.social-icon i:hover {
    color: purple;
}

@media (max-width: 768px) {
    .footer-content {
        flex-direction: column;
        text-align: center;
    }

    .social-icons {
        margin-top: 20px;
    }
}
</style>
