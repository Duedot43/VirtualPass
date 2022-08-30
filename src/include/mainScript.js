// Dark Mode button
let dark_toggle = document.body;
function dark_mode() {

    dark_toggle.classList.toggle("dark-mode");
    const change_theme = document.getElementsByClassName("sidenav");
    change_theme.style.color = ('#ffffff');

}

function loadFile(filePath) {
    let result = null;
    const xml_http = new XMLHttpRequest();
    xml_http.open("GET", filePath, false);
    xml_http.send();
    if (xml_http.status === 200) {
        result = xml_http.responseText;
    }
    return result;
}

const vp_ver = loadFile("/public/version-info");
parser = new DOMParser();
xmlDoc = parser.parseFromString(vp_ver, "text/xml");
console.log(vp_ver);


// deepcode ignore DOMXSS: Stop it please
document.getElementById('version-id').innerHTML = "Version ATS-" + xmlDoc.getElementsByTagName("version")[0].childNodes[0].nodeValue;

// Automatically toggles Dark Mode
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
        if (event.matches) {
            let change_theme = document.getElementsByClassName('');
            change_theme.style.color('#c0c0c0')

        } else {

        }
    })


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
const overtab = document.getElementById('overview-tab').style.backgroundColor = ('#acdbea')
overtab.style.borderColor('#205c8f')