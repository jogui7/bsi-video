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
            alert('Erro ao buscar filmes');
        }
        json.forEach(filme => {
            $('.filmes').append(`
                <div class="filme">
                    <b>${filme.title}</b>
    
                    <p class="descricao">${filme.synopsis}o</p>
    
                    <p>Data de lançamento: ${filme.release_date.split('-').reverse().join('/')}</p> 
    
                    <p>Gênero: ${filme.genre}</p>
                    
                    <p>Relevância: ${filme.relevance}</p>
    
                    <p>Trailer: <a href="${filme.trailer}">link</a></p>
                </div>
            `);
        });
    })
}