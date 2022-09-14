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

dark_toggler.addEventListener("click", function() {
    if (prefersDark.matches) {
        document.body.classList.toggle("light-mode");
        var theme = document.body.classList.contains('light-mode') ? "light" : "dark";
    } else {
        document.body.classList.toggle("dark-mode");
        var theme = document.body.classList.contains('dark-mode') ? "dark" : "light";
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

const switchEmbed = document.querySelectorAll('button');

for (i = 0; i < switchEmbed.length; i++) {
    switchEmbed[i].addEventListener('click', function(e) {

        //e.target.style.backgroundColor = ('var(--highlight)');
        document.getElementById('mainEmbed').src = e.target.value;

    })
}



//Removes open tabs when user clicks anywhere on screen.
const removeContent = document.getElementsByClassName('issue-tab')
const random_variable = document.body;

const overtab = document.getElementById('overview-tab').style.backgroundColor = ('var(--highlight)');