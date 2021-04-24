$(document).ready(function () {
    $("#button").click(function(e) {
        e.preventDefault();
        recuperarSenha();
    });
});

function recuperarSenha(){
    const email = $("#email").val();

    if (email == "") {
        alert("Preencha corretamente os campos");
        return;
    }

    var mailFormat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    if (!email.match(mailFormat)) {
        alert("Digite um email válido!");
        return;
    }

    const formData = {
        email
    };

    fetch("http://localhost/bsi-video/api/users/recoverPassword.php", {
        method: "POST",
        body: JSON.stringify(formData)
    })
    .then(async (res) => {
        const json = await res.json();
        alert(json.message);
    })
}