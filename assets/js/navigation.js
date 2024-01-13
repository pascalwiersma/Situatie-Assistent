const mobileMenuButton = document.getElementById("mobileMenuButton");
const mobileMenu = document.getElementById("mobileMenu");
const closeMobileMenuButton = document.getElementById("closeMobileMenuButton");

mobileMenuButton.addEventListener("click", function () {
    mobileMenu.classList.toggle("hidden");
});

closeMobileMenuButton.addEventListener("click", function () {
    mobileMenu.classList.add("hidden");
});

document.addEventListener("click", function (event) {
    if (
        !mobileMenu.contains(event.target) &&
        !mobileMenuButton.contains(event.target)
    ) {
        mobileMenu.classList.add("hidden");
    }
});
