async function ffSearchJobs() {
  const input = document.getElementById('jobSearchInput');
  const q = input ? input.value.trim() : '';
  const list = document.getElementById('jobsList');
  const empty = document.getElementById('jobsEmpty');
  if (!list) return;

  const res = await fetch(`/jobs/search?q=${encodeURIComponent(q)}`, {
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  });

  const data = await res.json();
  list.innerHTML = data.html;
  if (empty) empty.classList.toggle('d-none', data.count > 0);
}

document.addEventListener('DOMContentLoaded', () => {
  const input = document.getElementById('jobSearchInput');
  if (!input) return;
  input.addEventListener('input', () => {
    window.clearTimeout(input.__ffTimer);
    input.__ffTimer = window.setTimeout(ffSearchJobs, 250);
  });
});
