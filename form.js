(() => {
  const modal = document.getElementById("formModal");
  const openBtn = document.getElementById("openFormBtn");
  const closeBtn = modal?.querySelector(".close");
  const form = document.getElementById("signupForm");
  const confirmationDiv = document.getElementById("confirmation");

  if (!modal || !form) return; // exit if modal isn't on this page

  // --- Open Modal ---
  if (openBtn) {
    openBtn.addEventListener("click", (e) => {
      e.preventDefault();
      modal.style.display = "block";
      openBtn.style.display = "none";
    });
  }

  // --- Close Modal ---
  if (closeBtn) {
    closeBtn.addEventListener("click", () => {
      modal.style.display = "none";
      if (openBtn) openBtn.style.display = "block";
    });
  }

  // --- Click outside to close ---
  window.addEventListener("click", (e) => {
    if (e.target === modal) {
      modal.style.display = "none";
      if (openBtn) openBtn.style.display = "inline-block";
    }
  });

  // --- Submit Form via AJAX ---
  form.addEventListener("submit", (e) => {
    e.preventDefault();

    const formData = new FormData(form);
    fetch("php/process.php", { method: "POST", body: formData })
      .then(res => res.text())
      .then(data => {
        if (confirmationDiv) {
          confirmationDiv.style.display = "block";
          confirmationDiv.innerText = data;
        }
        modal.style.display = "none";
        if (openBtn) openBtn.style.display = "block";
      })
      .catch(err => {
        console.error("Error:", err);
        if (confirmationDiv) {
          confirmationDiv.style.display = "block";
          confirmationDiv.innerText = "An error occurred.";
        }
        modal.style.display = "none";
        if (openBtn) openBtn.style.display = "block";
      });
  });
})();
