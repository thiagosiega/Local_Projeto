document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const container = document.querySelector('.container');

    //sempre o mouse se aproximar 20px do lado esquerdo da tela, o sidebar vai aparecer e umpurrar o container
    window.addEventListener('mousemove', function (e) {
        if (e.clientX <= 20) {
            sidebar.style.left = '0px';
            container.style.marginLeft = '200px';
        }
        //sempre o mouse se afastar 150px do lado esquerdo da tela, o sidebar vai desaparecer
        if (e.clientX >= 180) {
            sidebar.style.left = '-200px';
            container.style.marginLeft = '10px';
        }
    });
});