(() => {
  const flash = document.querySelector('[data-flash-autohide="1"]');
  if (!flash) return;
  setTimeout(() => {
    flash.classList.add('opacity-0');
    setTimeout(() => flash.remove(), 400);
  }, 3500);
})();
