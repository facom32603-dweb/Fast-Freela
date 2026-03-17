(() => {
  const flash = document.querySelector('[data-flash-autohide="1"]');
  if (!flash) return;
  setTimeout(() => {
    flash.classList.add('opacity-0');
    setTimeout(() => flash.remove(), 400);
  }, 3500);
})();

window.addEventListener('load', function() {
    const splash = document.getElementById('splash-screen');
    setTimeout(() => {
        splash.style.opacity = '0';
        splash.style.visibility = 'hidden';
    }, 1000); // Aguarda 1 segundo para o usuário ver a animação
});