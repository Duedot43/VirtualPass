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