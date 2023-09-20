const burgerr = document.getElementById('sidebarToggle');
const sidebarr = document.getElementById('sidebarr');
const pagee = document.getElementById('pagee');
const bodyy = document.body;

burgerr.addEventListener('click', event => {
    if( bodyy.classList.contains('show-sidebar') ) {
        closeSidebar();
    } else {
        showSidebar();
    }
});

function showSidebar() {
    let  maskk = document.createElement('div');
    maskk.classList.add('pagee__mask');
    maskk.addEventListener('click',closeSidebar);
    pagee.appendChild(maskk);

    bodyy.classList.add('show-sidebar');
}

function closeSidebar() {
    bodyy.classList.remove('show-sidebar');
    document.querySelector('.pagee__mask').remove();
}
