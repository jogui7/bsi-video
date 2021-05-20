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
    var params = new window.URLSearchParams(window.location.search);
    const movieId = params.get('id');
    fetch(`http://localhost/bsi-video/api/movies/index.php/${movieId}`, {
        credentials:"include"
    })
    .then(async (res) => {
        const filme = await res.json();
        if(!res.ok) {
            return;
        }
        document.title = filme.title;
        $('header h2').text(filme.title);
        $('.filme').append(`
            <div class="row">
                <div class="column">
                    <div class="row">
                        <div class="row-item">
                            <b>Gênero:</b>
                            <p>${getGenre(filme.genre)}</p>
                        </div>
                        <div class="row-item">
                            <b>Relevância:</b>
                            <p>${filme.relevance}</p>
                        </div>
                        <div class="row-item">
                            <b>Data de lançamento:</b>
                            <p>${filme.release_date.split('-').reverse().join('/')}</p>
                        </div>
                        <div class="row-item">
                            <b>Duração:</b>
                            <p>${filme.duration} ${filme.is_movie ? 'minutos' : 'temporadas'}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="row-item">
                            <b>Descrição:</b>
                            <p>${filme.synopsis}</p>
                            <button id="favbtn">Adicionar aos favoritos</button>
                        </div>
                    </div>
                </div>
                <img src="${filme.banner_url}" />
            </div>
            <b>Trailer:</b>
            <iframe src="${filme.trailer}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        `);
    }).then(() => {
        fetch(`http://localhost/bsi-video/api/favorites/index.php/`, {
            credentials:"include"
        })
        .then(async (res) => {
            const favs = await res.json();
            if(!res.ok) {
                return;
            }
            $('#favbtn').text(favs.map(fav => fav.id).includes(movieId) ? 'Remover dos favoritos' : 'Adicionar aos favoritos');
            $('#favbtn').click(function() { 
                handleFav(movieId) 
            });
        })
    })
}

function handleFav(movieId) {
    fetch(`http://localhost/bsi-video/api/favorites/index.php/${movieId}`, {
        method: $('#favbtn').text() == 'Adicionar aos favoritos' ? 'POST' : 'DELETE',
        credentials:"include"
    })
    .then(async (res) => {
        if(res.ok) {
            $('#favbtn').text($('#favbtn').text() == 'Adicionar aos favoritos' ? 'Remover dos favoritos' : 'Adicionar aos favoritos');
            return;
        } 
        alert(`Erro ao ${$('#favbtn').text() == 'Remover dos favoritos' ? 'remover dos favoritos' : 'adicionar aos favoritos'}`);
    })
}

function getGenre(genre) {
    switch (genre) {
        case 'ACTION':
            return 'Ação';
        case 'ADVENTURE':
            return 'Aventura';
        case 'COMEDY':
            return 'Comédia';
        case 'CRIME_MYSTERY':
            return 'Mistério Criminal';
        case 'FANTASY':
            return 'Fantasia';
        case 'HISTORICAL':
            return 'Histórico';
        case 'HORROR':
            return 'Terror';
        case 'ROMANCE':
            return 'Romance';
        case 'SATIRE':
            return 'Sátira';
        case 'SCI_FI':
            return 'Ficção Científica';
        case 'THRILLER':
            return 'Suspense'; 
        case 'OTHER':
            return 'Outros';    
    
        default:
            break;
    }
}