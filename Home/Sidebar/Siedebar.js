document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const container = document.getElementById('container');

    // Quando o mouse entra na barra lateral
    sidebar.addEventListener('mouseenter', function () {
        sidebar.style.left = '0'; // Expande a barra lateral
        container.style.marginLeft = '200px'; // Afasta o conteúdo principal
    });

    // Quando o mouse sai da barra lateral
    sidebar.addEventListener('mouseleave', function () {
        sidebar.style.left = '-150px'; // Contrai a barra lateral
        container.style.marginLeft = '60px'; // Aproxima o conteúdo principal
    });
});
