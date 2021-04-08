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

    alert("A");
        
    var formData = {};
    formData.append('name', nome);
    formData.append('birthdate', mysqlDate()  );
    formData.append('email', email );
    formData.append('password', senha );
    formData.append('creditCardNumber', numero );
    formData.append('creditCardExpireDate', mysqlDate() );
    formData.append('ccv', codigo );
    formData.append('cardHolderName', titular );
    formData.append('cpfCNPJ', CPF );

    fetch("http://localhost/bsi-video/api/users/index.php/", {
        method: "POST",
        body: formData
    })
}

function mysqlDate(date){
    date = date || new Date();
    return date.toISOString().split('T')[0];
}


