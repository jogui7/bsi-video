$(document).ready(function () {
    verficaLogado();

    $("#logout").click(function(e) {
        logout();
    });

    $("#filter-btn").click(function(e) {
        applyFilter();
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
        if(json.isAdmin == 1) {
            $(".content > h2").append('<a href="/cadastrarFilme.html">+</a>')
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
    fetch("http://localhost/bsi-video/api/movies/index.php", {
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

function applyFilter() {
    let url = "http://localhost/bsi-video/api/movies/index.php"
    const params = [];
    if($("#title").val())   {
        params.push(`title=${$("#title").val()}`)
    }
    if($("#genre").val())   {
        params.push(`genre=${$("#genre").val()}`)
    }
    if($("#isMovie").val())   {
        params.push(`isMovie=${$("#isMovie").val()}`)
    }
    if($("#releaseDate").val())   {
        params.push(`releaseDate=${$("#releaseDate").val()}`)
    }
    if($("#relevance").val())   {
        params.push(`relevance=${$("#relevance").val()}`)
    }

    if(params.length > 0) {
        url += '?'+params.join('&')
    }

    fetch(url, {
        credentials:"include"
    })
    .then(async (res) => {
        const json = await res.json();
        if(!res.ok) {
            return;
        }
        $('.filmes').html(() => "");
        json.forEach(filme => {
            $('.filmes').append(`
                <a href="/filme.html?id=${filme.id}" class="filme">
                    <img src="${filme.banner_url}" />
                </a>
            `);
        });
    })
}