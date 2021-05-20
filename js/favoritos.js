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
    fetch("http://localhost/bsi-video/api/favorites/index.php/", {
        credentials:"include"
    })
    .then(async (res) => {
        const json = await res.json();
        if(!res.ok) {
            return;
        }
        json.forEach(filme => {
            if(JSON.parse(filme.is_movie)) {
                $('.filmes').append(`
                    <a href="/filme.html?id=${filme.id}" class="filme">
                        <img src="${filme.banner_url}" />
                    </a>
                `);
            } else {
                $('.series').append(`
                    <a href="/filme.html?id=${filme.id}" class="filme">
                        <img src="${filme.banner_url}" />
                    </a>
                `);
            }
        });
    })
}