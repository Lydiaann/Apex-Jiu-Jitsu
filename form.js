document.addEventListener("DOMContentLoaded", function() {
          const modal = document.getElementById("formModal");
          const openBtn = document.getElementById("openFormBtn");
          const closeBtn = document.querySelector(".close");
          const form = document.getElementById("signupForm");
          const confirmationDiv = document.getElementById("confirmation");

          // Open modal
          openBtn.onclick = (e) => {
            e.preventDefault();
            modal.style.display = "block";
            openBtn.style.display = "none";
          };

          // Close modal via ×
          closeBtn.onclick = () => {
            modal.style.display = "none";
            openBtn.style.display = "block"; // ✅ bring CTA back
          };

          // Close modal by clicking outside
          window.onclick = (e) => {
            if (e.target == modal) {
              modal.style.display = "none";
              openBtn.style.display = "inline-block"; // ✅ bring CTA back
            }
          };

          // Handle form submission via AJAX
          form.onsubmit = (e) => {
            e.preventDefault(); // prevent default form submit
            
            const formData = new FormData(form);
            
            fetch("index.php", {
              method: "POST",
              body: formData
            })
            .then(res => res.text())
            .then(data => {
              // Show success/error message
              confirmationDiv.style.display = "block";
              confirmationDiv.innerText = data;
              
              // Close modal after success
              modal.style.display = "none";
              
              // ✅ Bring CTA back
              openBtn.style.display = "block";

              // Reset form if needed
              // form.reset();
            })
            .catch(error => {
              console.error("Error:", error);
              confirmationDiv.style.display = "block";
              confirmationDiv.innerText = "An error occurred.";
            
              modal.style.display = "none";
              openBtn.style.display = "block";
            });
          };
        });