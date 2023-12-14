// Animation to bring the two divs closer together on scroll in the about-section
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