// Animation to bring the two divs closer together on scroll in the "à-propos" section
document.addEventListener('DOMContentLoaded', function () {
    var textElements = document.querySelectorAll('.story-picture');
    var pictureElements = document.querySelectorAll('.story-text');

    function checkElements(elements) {
        elements.forEach(function (element) {
            var elementTop = element.getBoundingClientRect().top;
            var windowHeight = window.innerHeight;
            var scroll = window.scrollY || window.pageYOffset;

            // Adding the condition for responsive design
            if (window.innerWidth >= 1131) {
                if (scroll > elementTop - windowHeight + 100) {
                    element.classList.add('animated');
                }
            } else {
                // If the screen width is less than 1130 pixels, disable the animation
                element.classList.remove('animated');
            }
        });
    }

    function updateOnResize() {
        // Update the animation during window resizing
        checkElements(textElements);
        checkElements(pictureElements);
    }

    window.addEventListener('scroll', function () {
        checkElements(textElements);
        checkElements(pictureElements);
    });

    // To display the animation during page loading
    checkElements(textElements);
    checkElements(pictureElements);

    // Adding the resize event to update the animation
    window.addEventListener('resize', updateOnResize);
});

// Animation to bring the two divs closer together on scroll in the "monthly-meeting" section
document.addEventListener('DOMContentLoaded', function () {
    var textElements = document.querySelectorAll('.meetingLeft');
    var pictureElements = document.querySelectorAll('.meetingRight');

    function checkElements(elements) {
        elements.forEach(function (element) {
            var elementTop = element.getBoundingClientRect().top;
            var windowHeight = window.innerHeight;
            var scroll = window.scrollY || window.pageYOffset;

            // Adding the condition for responsive design
            if (window.innerWidth >= 1131) {
                if (scroll > elementTop - windowHeight + 100) {
                    element.classList.add('animated');
                }
            } else {
                // If the screen width is less than 1130 pixels, disable the animation
                element.classList.remove('animated');
            }
        });
    }

    function updateOnResize() {
        // Update the animation during window resizing
        checkElements(textElements);
        checkElements(pictureElements);
    }

    window.addEventListener('scroll', function () {
        checkElements(textElements);
        checkElements(pictureElements);
    });

    // To display the animation during page loading
    checkElements(textElements);
    checkElements(pictureElements);

    // Adding the resize event to update the animation
    window.addEventListener('resize', updateOnResize);
});

// Animation to display each-trip on scroll
document.addEventListener("DOMContentLoaded", function() {
    var tripElements = document.querySelectorAll('.each-trip');

    function showTripsOnScroll() {
        tripElements.forEach(function(tripElement) {
            var rect = tripElement.getBoundingClientRect();
            var windowHeight = window.innerHeight || document.documentElement.clientHeight;
            
            // Vous pouvez ajuster cette valeur (0.5) pour déterminer quand les éléments devraient apparaître
            var isVisible = rect.top <= windowHeight * 0.5 && rect.bottom >= 0;

            if (isVisible && !tripElement.classList.contains('visible')) {
                tripElement.classList.add('visible');
            }
        });
    }

    // Initial check on page load
    showTripsOnScroll();

    // Listen for the scroll event and show trips accordingly
    window.addEventListener('scroll', showTripsOnScroll);
});

// Animation to display forum sections on scroll
document.addEventListener("DOMContentLoaded", function() {
    var tripElements = document.querySelectorAll('.forum');

    function showTripsOnScroll() {
        tripElements.forEach(function(tripElement) {
            var rect = tripElement.getBoundingClientRect();
            var windowHeight = window.innerHeight || document.documentElement.clientHeight;
            
            // Vous pouvez ajuster cette valeur (0.5) pour déterminer quand les éléments devraient apparaître
            var isVisible = rect.top <= windowHeight * 0.5 && rect.bottom >= 0;

            if (isVisible && !tripElement.classList.contains('visible')) {
                tripElement.classList.add('visible');
            }
        });
    }

    // Initial check on page load
    showTripsOnScroll();

    // Listen for the scroll event and show trips accordingly
    window.addEventListener('scroll', showTripsOnScroll);
});