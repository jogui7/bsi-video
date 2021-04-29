$(document).ready(function () {
    $("#botaoCadastrar").click(function(e) {
        e.preventDefault();
        cadastrar();
    });
});

function cadastrar(){
    var nome = $("#nome").val();
    var nascimento = $("#nascimento").val();
    var email =   $("#email").val();
    var senha = $("#senha").val();
    var confsenha = $("#confSenha").val();
    var numero = $("#numero").val();
    var validade = $("#validade").val();
    var codigo = $("#codigo").val();
    var titular = $("#titular").val();
    var cpf = $("#cpf").val();

    if (nome == "" ||
        nascimento == "" ||
        email == "" || 
        senha == "" || 
        confsenha == "" || 
        numero == "" || 
        validade == "" || 
        codigo == "" || 
        titular == "" || 
        cpf == ""
    ) {
        alert("Preencha corretamente os campos");
        return;
    }
    
    var mailFormat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    if (!email.match(mailFormat)) {
        alert("Digite um email válido!");
        return;
    }

    if(senha != confsenha) {
        alert("Senhas precisam ser iguais");
        return;
    }

    if (numero.toString().length != 16) {
        alert("Cartão inválido");
        return;
    }

    if (codigo.toString().length != 3) {
        alert("Cartão inválido");
        return;
    }

    if(cpf.toString().length != 11 & 14) {
        alert("Digite um CPF ou um CNPJ válido");
        return;
    }

    var sha256 = sjcl.hash.sha256.hash(senha);
	senha = sjcl.codec.hex.fromBits(sha256);

    var formData = {
        name: nome,
        birthdate: mysqlDate(new Date(nascimento)),
        email,
        password: senha,
        creditCardNumber: numero,
        creditCardExpireDate: mysqlDate(new Date(validade)),
        ccv: codigo,
        cardHolderName: titular,
        cpfCNPJ: cpf,
    };

    fetch("http://localhost/bsi-video/api/users/index.php/", {
        method: "POST",
        body: JSON.stringify(formData)
    })
    .then(async (res) => {
        const json = await res.json();
        alert(json.message);
        if(res.ok) {
            window.location.href = "http://bsi.video.test";
        }
    })
}

function mysqlDate(date){
    date = date || new Date();
    return date.toISOString().split('T')[0];
}