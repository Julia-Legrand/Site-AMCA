document.addEventListener("DOMContentLoaded", function () {
    // Function to display or mask password
    function toggleRegistrationPassword() {
        let registrationPasswordInput = document.getElementById('registration_form_plainPassword');
        let toggleButton = document.querySelector('.toggle-password');

        if (registrationPasswordInput.type === 'password') {
            registrationPasswordInput.type = 'text';
            toggleButton.textContent = 'Masquer';
        } else {
            registrationPasswordInput.type = 'password';
            toggleButton.textContent = 'Afficher';
        }
    }

    let toggleButton = document.querySelector('.toggle-password');
    toggleButton.addEventListener('click', toggleRegistrationPassword);
});