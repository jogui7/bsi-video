$(document).ready(function () {
    verificaLogado();
    $("#savebtn").click(function(e) {
        e.preventDefault();
        cadastrar();
    });
});

function verificaLogado(){
    fetch("http://localhost/bsi-video/api/auth/index.php/", {
        credentials:"include"
    })
    .then(async (res) => {
        const json = await res.json();
        if(!res.ok) {
            window.location.href = "http://bsi.video.test/";
        }
        if(json.isAdmin != 1) {
            logout();
        }
        
        $(".content > h2").text('aaaa')
    })
}

function cadastrar(){
    var title = $("#title").val();
    var genre = $("#genre").val();
    var release_date = $("#releaseDate").val();
    var relevance = $("#relevance").val();
    var synopsis = $("#synopsis").val();
    var trailer = $("#trailer").val();
    var duration = $("#duration").val();
    var banner = document.getElementById("banner").files[0];
    var is_movie = $("#isMovie").val();

    if (title == "" ||
        genre == "" ||
        release_date == "" || 
        relevance == "" || 
        synopsis == "" || 
        trailer == "" || 
        duration == "" || 
        !banner || 
        is_movie == ""
    ) {
        alert("Preencha corretamente os campos");
        return;
    }

    var formData = new FormData();

    formData.append("title", title);
    formData.append("release_date", mysqlDate(new Date(release_date)));
    formData.append("relevance", relevance);
    formData.append("genre", genre);
    formData.append("synopsis", synopsis);
    formData.append("trailer", trailer);
    formData.append("duration", duration);
    formData.append("is_movie", is_movie);
    formData.append("banner", banner);

    fetch("http://localhost/bsi-video/api/movies/index.php/", {
        method: "POST",
        credentials:"include",
        body: formData
    })
    .then(async (res) => {
        const json = await res.json();
        alert(json.message);
    })
}


function mysqlDate(date){
    date = date || new Date();
    return date.toISOString().split('T')[0];
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
