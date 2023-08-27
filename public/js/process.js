document.addEventListener('DOMContentLoaded', function () {
  const contactForm = document.getElementById('contact-form');

  contactForm.addEventListener('submit', async function (e) {
      e.preventDefault();

      const formData = new FormData(contactForm);
      const response = await fetch('/email', {
          method: 'POST',
          body: JSON.stringify(Object.fromEntries(formData)),
          headers: {
              'Content-Type': 'application/json'
          }
      });

      const result = await response.json();
      if (result.success) {
          alert(result.message);
          contactForm.reset(); // Clear the form if the email was sent successfully
      } else {
          alert('Failed to send email. Please try again later.');
      }
  });
});
