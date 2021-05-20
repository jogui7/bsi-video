$(document).ready(function () {
    $("#button").click(function(e) {
        e.preventDefault();
        alterarSenha();
    });
});

function alterarSenha(){
    const newPassword = $("#newPassword").val();
    const confirmPassword = $("#confirmPassword").val();

    const url_string = window.location.href;
    const url = new URL(url_string);
    const token = url.searchParams.get("token");

    if (newPassword == "" || confirmPassword == "") {
        alert("Preencha corretamente os campos");
        return;
    }

    const sha256 = sjcl.hash.sha256.hash(newPassword);
	const hashedPassword = sjcl.codec.hex.fromBits(sha256);

    const formData = {
        password: hashedPassword,
        token
    };

    fetch("http://localhost/bsi-video/api/users/changePassword.php", {
        method: "PATCH",
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