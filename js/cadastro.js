function cadastrar(){
    var nome = $("#txtNome").val();
    var nascimento = $("#txtNascimento").val();
    var email =   $("#txtEmail").val();
    var senha = $("#Senha").val();
    var confsenha = $("#ConfSenha").val();
    var numero = $("#txtNumero").val();
    var validade = $("#txtValidade").val();
    var codigo = $("#txtCodigo").val();
    var titular = $("#txtTitular").val();
    var CPF = $("#txtCPF").val();

    var formData = {
        name: nome,
        birthdate: mysqlDate(new Date(nascimento)),
        email,
        password: senha,
        creditCardNumber: numero,
        creditCardExpireDate: mysqlDate(new Date(validade)),
        ccv: codigo,
        cardHolderName: titular,
        cpfCNPJ: CPF,
    };

    fetch("http://localhost/bsi-video/api/users/index.php/", {
        method: "POST",
        body: JSON.stringify(formData)
    }).then(res => console.log(res.json))
}

function mysqlDate(date){
    date = date || new Date();
    return date.toISOString().split('T')[0];
}


