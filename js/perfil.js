$(document).ready(function () {
    verificaLogado();
    $("#cancelbtn").click(function(e) {
        verificaLogado();
    });
    $("#savebtn").click(function(e) {
        e.preventDefault();
        atualizaCartao();
    });
});

function verificaLogado(){
    var name = $("#name");
    var email = $("#email");
    var birthdate =   $("#birthdate");
    var cardNumber = $("#cardNumber");
    var ccv = $("#ccv");
    var cardHolder = $("#cardHolder");
    var cardExpireDate = $("#cardExpireDate");
    fetch("http://localhost/bsi-video/api/auth/index.php/", {
        credentials:"include"
    })
    .then(async (res) => {
        const json = await res.json();
        if(!res.ok) {
            window.location.href = "http://bsi.video.test/";
        }
        name.text(`Nome: ${json.userName}`);
        email.text(`Email: ${json.userEmail}`);
        birthdate.text(`Data de nascimento: ${json.userBirthDate.split('-').reverse().join('/')}`);
        cardNumber.val(json.userCardNumber);
        ccv.val(json.userCCV);
        cardHolder.val(json.userCardHolderName);

        const expireDate = json.userCardExpireDate.slice(0, 7);
        cardExpireDate.val(expireDate);
    })
}

function atualizaCartao(){
    var cardNumber = $("#cardNumber").val();
    var ccv = $("#ccv").val();
    var cardHolder = $("#cardHolder").val();
    var cardExpireDate = $("#cardExpireDate").val();

    if (cardNumber == "" ||
    ccv == "" ||
    cardHolder == "" || 
    cardExpireDate == ""
    ) {
        alert("Preencha corretamente os campos");
        return;
    }

    if (cardNumber.toString().length != 16) {
        alert("Cartão inválido");
        return;
    }

    if (ccv.toString().length != 3) {
        alert("Cartão inválido");
        return;
    }

    var formData = {
        creditCardNumber: cardNumber,
        creditCardExpireDate: mysqlDate(new Date(cardExpireDate)),
        ccv,
        cardHolderName: cardHolder,
    };

    fetch("http://localhost/bsi-video/api/users/index.php/", {
        method: "PATCH",
        body: JSON.stringify(formData),
        credentials:"include"
    })
    .then(async (res) => {
        if(res.ok) {
            alert('Cartão alterado com sucesso');
            return;
        } 
        alert('Não foi possível alterar o cartão');
    })
}

function mysqlDate(date){
    date = date || new Date();
    return date.toISOString().split('T')[0];
}