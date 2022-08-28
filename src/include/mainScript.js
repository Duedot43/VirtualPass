function dark_mode() {
    const dark = document.querySelector('span');

    dark.addEventListener('fullscreenchange', () => {
        document.body.classList.toggle('')
    })
}

const dropdown = document.getElementsByClassName("dropdown-button");
let i;

for (i = 0; i < dropdown.length; i++) {
    dropdown[i].addEventListener("click",function() {
        this.classList.toggle("active");
        const dropdownContent = this.nextElementSibling;
        if (dropdownContent.style.display === "block") {
            dropdownContent.style.display = "none";
        } else {
            dropdownContent.style.display = "block";
        }
    });
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
xmlDoc = parser.parseFromString(vp_ver,"text/xml");
console.log(vp_ver);


// deepcode ignore DOMXSS: Stop it please
document.getElementById('version-id').innerHTML = "Version ATS-" + xmlDoc.getElementsByTagName("version")[0].childNodes[0].nodeValue;

document.getElementById('overview-tab').style.backgroundColor = ('#acdbea')