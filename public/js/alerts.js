// Display alerts within timing
let alerts = document.querySelectorAll('.alert');
alerts.forEach(alert => {
    setTimeout(() => {
        alert.remove();
    }, 10000);
});