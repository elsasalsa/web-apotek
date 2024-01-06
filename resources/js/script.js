const sidebarToggle = document.querySelector('#sidebar-toggle');
sidebarToggle.addEventListener('click', function () {
    document.querySelector('#sidebar').classList.toggle('collapsed');
});

document.querySelector('#sidebar').addEventListener('click', () => {
    toggleLocalStorage();
    toggleRootClass();
});
