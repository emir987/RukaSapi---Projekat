$(document).ready(function () {
    $('#nav-icon1').click(function () {
        $(this).toggleClass('open');
    });
});

//register

function register() {

    var form = document.getElementById('regForm');
    var formData = new FormData(form);

    var emailError = document.getElementById('emailError');
    var nameError = document.getElementById('nameError');
    var passwordError = document.getElementById('passwordError');
    var surnameError = document.getElementById('surnameError');
    var phoneError = document.getElementById('phoneError');
    var addressError = document.getElementById('addressError');
    var addressError = document.getElementById('zipError');


    var http = new XMLHttpRequest();
    var method = "POST";
    var url = 'api/user/register.php';
    var asynchronous = true;

    http.open(method, url, asynchronous);
    http.send(formData);


    http.onload = function () {
        var data = JSON.parse(this.responseText);
        console.log(data);


        if (data.success == '1') {
            $('#modal-register').modal('hide');
            Swal.fire({
                icon: 'success',
                title: 'Uspješna registracija!',
                timer: 1500
            }).then(() => {
                $('#modal-login').modal('show');
            });


        } else {
            nameError.innerText = data.errorMessage.nameMessage;
            surnameError.innerText = data.errorMessage.surnameMessage;
            emailError.innerText = data.errorMessage.emailMessage;
            passwordError.innerText = data.errorMessage.passwordMessage;
            phoneError.innerText = data.errorMessage.phoneMessage;
            addressError.innerText = data.errorMessage.addressMessage;
            zipError.innerText = data.errorMessage.zipMessage;
        }
    }
}


// LOGIN

function submitFormLogin() {

    var form = document.getElementById('loginForm');
    var formData = new FormData(form);
    var emailError = document.getElementById('emailError');
    var passwordError = document.getElementById('passwordError');

    var http = new XMLHttpRequest();
    var method = "POST";
    var url = 'api/user/login.php';
    var asynchronous = true;

    http.open(method, url, asynchronous);
    http.send(formData);

    http.onload = function () {
        var data = JSON.parse(this.responseText);
        console.log(data);


        if (data.success == '1') {
            $('#modal-login').modal('hide');
            Swal.fire({
                icon: 'success',
                title: 'Uspješna prijava!',
                timer: 2000
            }).then(() => {
                location.reload();
            });
        } else {
            emailError.innerText = data.message.emailMessage;
            passwordError.innerText = data.message.passwordMessage;
        }
    }
}


const profilna_input = document.getElementById('profilna_input');
const slika_profil = document.getElementById('slika_profil_dodaj');
const close_profil = document.getElementById('close_profil');

profilna_input.addEventListener("change", function (event) {

    const file = this.files[0];

    if (file) {
        console.log(file.type);

        if (file.size < 2097152) {

            if (file.type === "image/png" || file.type === "image/jpg" || file.type === "image/jpeg") {

                if (slika_profil.dataset.imgg == 'empty') {

                    const reader = new FileReader();

                    reader.addEventListener("load", function () {
                        slika_profil.src = reader.result;
                    });
                    reader.readAsDataURL(file);

                    slika_profil.dataset.imgg = '1';
                    close_profil.style.display = "block";
                    slika_profil.parentElement.style.pointerEvents = "none";
                    close_profil.style.cursor = "pointer";
                    close_profil.style.pointerEvents = "auto";
                }

                //document.getElementById('close-profile').style.display = "block";
            } else {
                alert("Slika " + file.name + " nije u jpg, png ili jpeg formatu.");
            }
        } else {
            alert("Maksimalna velicina slike je 2MB");

        }
    }

});

function zatvori_profilna(element, e) {
    console.log('hahah')
    e.preventDefault();
    const slikaIme = element.parentElement.dataset.imgg;
    profilna_input.value = "";

    slika_profil.src = 'res/images/profile-user.png';
    element.style.display = "none";
    element.nextElementSibling.dataset.imgg = "empty";
    element.nextElementSibling.style.pointerEvents = "auto"
    element.nextElementSibling.style.cursor = "pointer";

}