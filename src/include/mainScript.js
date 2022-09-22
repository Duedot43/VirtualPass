//Dark Mode Functionality
const dark_toggler = document.querySelector('.dark-toggler');
const prefersDark = window.matchMedia("(prefers-color-scheme: dark)");

const currentMode = localStorage.getItem("theme");
if (currentMode === "dark") { //TOP!!
    document.body.classList.toggle("dark-mode");
}
else if (currentMode === "light") {
    document.body.classList.toggle('light-mode');
}

dark_toggler.addEventListener("click", function () {
    let theme;
    if (prefersDark.matches) {
        document.body.classList.toggle("light-mode");
        theme = document.body.classList.contains('light-mode') ? "light" : "dark";
    } else {
        document.body.classList.toggle("dark-mode");
        theme = document.body.classList.contains('dark-mode') ? "dark" : "light";
    }

    //localStorage.setItem("theme", theme);
});

//enables various buttons to display information
const dropdown = document.getElementsByClassName("dropdown-button");
let i;

for (i = 0; i < dropdown.length; i++) {
    dropdown[i].addEventListener("click", function () {
        this.classList.toggle("active");
        const dropdownContent = this.nextElementSibling;
        if (dropdownContent.style.display === "block") {
            dropdownContent.style.display = "none";
        } else {
            dropdownContent.style.display = "block";
        }
    });
}

//async function to change embed data && selected button highlight
const switchEmbed = document.querySelectorAll('.sidenav button');

for (i = 0; i < switchEmbed.length; i++) {
    switchEmbed[i].addEventListener('click', function (e) {

        //Reluctantly using a nestled for loop to check for highlights, and remove them.
        for (i = 0; i < switchEmbed.length; i++) {
            if (switchEmbed[i].classList.contains('highlighted')) {
                switchEmbed[i].classList.remove('highlighted');
            }
        }
        this.classList.add("highlighted");

        const buttonName = this.getAttribute('name');
        const viewportTitle = document.getElementById('viewportTitle');
        viewportTitle.innerHTML = buttonName;

        if (e.target.value) {
            AJAX(e.target.value, "mainEmbed");

        }
    })
}

function AJAX(target, element) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.response);
            document.getElementById(element).innerHTML = this.response;
        }
    };
    xhttp.open("GET", target, true);
    xhttp.send();
}

//closes the dropdown menu when the user clicks outside of it
window.onclick = function (event) {
    if (!event.target.matches('.dropdown-button')) {
        const dropdowns = document.getElementsByClassName("dropdown-content");
        let i;
        for (i = 0; i < dropdowns.length; i++) {
            const openDropdown = dropdowns[i];
            if (openDropdown.style.display === "block") {
                openDropdown.style.display = "none";
            }
        }
    }
}