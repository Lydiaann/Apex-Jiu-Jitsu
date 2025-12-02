// form.js — robust initializer (polls until modal/form exist, creates popup if missing)
(() => {
  const MAX_TRIES = 60;    // how many times to poll (60 * 100ms = 6s)
  const POLL_INTERVAL = 100;

  let tries = 0;
  const poll = setInterval(() => {
    tries++;

    const modal = document.getElementById("formModal");
    const form = document.getElementById("signupForm");
    const openBtn = document.getElementById("openFormBtn");

    // If modal & form are present, initialize and stop polling
    if (modal && form) {
      clearInterval(poll);
      initModalLogic({ modal, form, openBtn });
      return;
    }

    // stop polling after too many tries
    if (tries >= MAX_TRIES) {
      clearInterval(poll);
      console.warn("form.js: timed out waiting for modal/form to load.");
    }
  }, POLL_INTERVAL);

  // Main initializer
  function initModalLogic({ modal, form, openBtn }) {
    // ensure close button exists
    const closeBtn = modal.querySelector(".close");

    // ensure popup exists, otherwise create it
    let popup = document.getElementById("confirmation-popup");
    if (!popup) {
      popup = document.createElement("div");
      popup.id = "confirmation-popup";
      popup.className = "confirmation-popup";
      // basic inline styles for safety if CSS not loaded
      popup.style.display = "none";
      popup.style.position = "fixed";
      popup.style.top = "20px";
      popup.style.right = "20px";
      popup.style.backgroundColor = "#4CAF50";
      popup.style.color = "white";
      popup.style.padding = "12px 20px";
      popup.style.borderRadius = "8px";
      popup.style.fontWeight = "bold";
      popup.style.opacity = "0";
      popup.style.transition = "opacity 1s ease";
      popup.style.zIndex = "9999";
      document.body.appendChild(popup);
    }

    // helper to show popup
    function showPopup(message, success = true) {
      popup.textContent = message || (success ? "Submission successful!" : "An error occurred.");
      popup.style.backgroundColor = success ? "#4CAF50" : "#E74C3C";
      popup.style.display = "block";
      // fade in
      requestAnimationFrame(() => { popup.style.opacity = "1"; });

      // fade out after 3s
      setTimeout(() => {
        popup.style.opacity = "0";
        setTimeout(() => { popup.style.display = "none"; }, 1000); // wait for fade-out
      }, 3000);
    }

    // open button (optional)
    if (openBtn) {
      // ensure anchor doesn't navigate away: prefer href="#" and preventDefault in handler
      openBtn.addEventListener("click", (e) => {
        e.preventDefault();
        modal.style.display = "block";
        openBtn.style.display = "none";
      });
    } else {
      // no open button found — OK. modal can be triggered elsewhere.
      console.info("form.js: no #openFormBtn found on page.");
    }

    // close button (optional)
    if (closeBtn) {
      closeBtn.addEventListener("click", () => {
        modal.style.display = "none";
        if (openBtn) openBtn.style.display = "block";
      });
    }

    // clicking outside modal closes it
    window.addEventListener("click", (e) => {
      if (e.target === modal) {
        modal.style.display = "none";
        if (openBtn) openBtn.style.display = "inline-block";
      }
    });

    // submit handler
    form.addEventListener("submit", (e) => {
      e.preventDefault();
      const formData = new FormData(form);

      fetch("process.php", { method: "POST", body: formData })
        .then(res => res.text())        // <-- IMPORTANT: convert Response -> text
        .then(text => {
          // show server response
          showPopup(text || "Submission successful!", true);
          modal.style.display = "none";
          if (openBtn) openBtn.style.display = "block";
          try { form.reset(); } catch (err) {}
        })
        .catch(err => {
          console.error("form.js: submit error", err);
          showPopup("An error occurred. Please try again.", false);
          modal.style.display = "none";
          if (openBtn) openBtn.style.display = "block";
        });
    });

    // small log to confirm initialization
    console.info("form.js: modal/form initialized.");
  }
})();
