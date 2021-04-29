$(document).ready(function () {
    $("#loginButton").click(function(e) {
        e.preventDefault();
        logar();
    });
    if(localStorage.getItem("email")) {
        $("#email").val(localStorage.getItem("email"));
        $("#password").val(localStorage.getItem("password"));
        $("#remember").prop('checked', true);
    }
});

function logar(){
    const email = $("#email").val();
    const password = $("#password").val();
    const remember = $("#remember").prop('checked');

    if (email == "" || password == "") {
        alert("Preencha corretamente os campos");
        return;
    }
    
    const mailFormat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    if (!email.match(mailFormat)) {
        alert("Digite um email válido!");
        return;
    }

    const sha256 = sjcl.hash.sha256.hash(password);
	const hashedPassword = sjcl.codec.hex.fromBits(sha256);

    const formData = {
        email,
        password: hashedPassword
    };

    fetch("http://localhost/bsi-video/api/auth/index.php/", {
        method: "POST",
        body: JSON.stringify(formData),
        credentials: "include"
    })
    .then(async (res) => {
        const json = await res.json();
        alert(json.message);
        if(res.ok) {
            window.location.href = "http://bsi.video.test/home.html";
            console.log(res.headers.get('set-cookie'));
            console.log(document.cookie);
            if (remember) {
                localStorage.setItem('email', email);
                localStorage.setItem('password', password);
            } else {
                localStorage.removeItem('email');
                localStorage.removeItem('password');
            }
        }
    })

}