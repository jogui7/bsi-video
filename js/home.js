$(document).ready(function () {
    verficaLogado();

    $("#logout").click(function(e) {
        logout();
    });

    fetchFilmes();
});

function verficaLogado(){
    fetch("http://localhost/bsi-video/api/auth/index.php/", {
        credentials:"include"
    })
    .then(async (res) => {
        const json = await res.json();
        if(!res.ok) {
            window.location.href = "http://bsi.video.test/";
        }
        $('header h2').text(`Olá ${json.userName}`);
    })
}

function logout(){
    fetch("http://localhost/bsi-video/api/auth/index.php/", {
        method: 'DELETE',
        credentials:"include"
    })
    .then(async (res) => {
        if(res.ok) {
            window.location.href = "http://bsi.video.test/";
        }
    })
}

function fetchFilmes() {
    fetch("http://localhost/bsi-video/api/movies/index.php/", {
        credentials:"include"
    })
    .then(async (res) => {
        const json = await res.json();
        if(!res.ok) {
            return;
        }
        json.forEach(filme => {
            $('.filmes').append(`
                <a href="/filme.html?id=${filme.id}" class="filme">
                    <img src="${filme.banner_url}" />
                </a>
            `);
        });
    })
}