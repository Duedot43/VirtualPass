function login_button() {
    'use strict';
    let login = document.querySelector('.acc-menu');
    login.style.display === ('none') ? login.style.display = ('block') : login.style.display = ('none')
}

function issues_button() {
    let issues = document.querySelector('.issue-tab');
    issues.style.display === ('none') ? issues.style.display = ('block') : issues.style.display = ('none');

}

function dark_mode() {
    const dark = document.querySelector('span');

    dark.addEventListener('fullscreenchange', () => {
        document.body.classList.toggle('')
    })
}

function loadFile(filePath) {
    var result = null;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", filePath, false);
    xmlhttp.send();
    if (xmlhttp.status == 200) {
        result = xmlhttp.responseText;
    }
    return result;
}


const vp_ver = loadFile("/public/version-info");
parser = new DOMParser();
xmlDoc = parser.parseFromString(vp_ver,"text/xml");
console.log(vp_ver);


// deepcode ignore DOMXSS: Stop it please
document.getElementById('version-id').innerHTML = "Version ATS-" + xmlDoc.getElementsByTagName("version")[0].childNodes[0].nodeValue;