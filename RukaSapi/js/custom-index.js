$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

let navbar = $(".navbar");
let nav = $(".navigacija");


$(window).scroll(function () {
    let oTop = $("#showMore").offset().top;
    if ($(window).scrollTop() > oTop) {
        nav.addClass("sticky");
    } else {
        nav.removeClass("sticky");
    }
});

//limit for database read
var limit = 3;
var search = "";
var newPetsShow = false;
var btnLoad = document.getElementById('loadMore');


//load pets
function loadData() {

    search = document.getElementById('getSearch').value;
    let divIspis = document.getElementById('showMore');

    var category = vrijedsnotCheck();

    var weight = vrijedsnotRadio();

    var http = new XMLHttpRequest();
    var method = "POST";
    var url = "api/pet/getAllPets.php";
    var asynchronous = true;


    http.open(method, url, asynchronous);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send("counter=" + limit + "&searchHint=" + search + "&weight=" + weight + "&category=" + JSON.stringify(category));
    limit += 3;
    http.onload = function () {
        var data = JSON.parse(http.responseText);
        console.log(data);

        let html = "";

        if (data.success == 0) {
            btnLoad.style.display = "none";
            divIspis.innerHTML = `<div class="not-found">
                                    <img src="res/images/not-found.png">
                                    <h4  class="mt-5">Nije pronadjen nijedan ljubimac.</h4>
                                    <h5 class="mt-3">Pokusajte da promijenite Vas kriterijum za pretragu.</h5>
                                </div`;
            return;
        }

        btnLoad.style.display = "inline-block";

        var pets = data.pets;
        const newpets = data.newpets || [];


        if (data.stopLoad === 1) {
            btnLoad.style.display = 'none';
        }

        if (data.success === 1) {

            if (newpets.length > 0) {

                html += `<div class="col-12 h2">Novi ljubimci</div>`;

                for (var a = 0; a < newpets.length; a++) {
                    const image = 'slike/' + newpets[a].image;
                    //svaki novi element
                    html += `<div onclick="window.location=petInfo.php?id='${newpets[a].id}' style="cursor: pointer;" class="col-12 col-lg-4 col-md-6 mb-4 col-sm-6">
                        <div data-toggle="tooltip" title="Show more" class="blur card h-100-custom">
                        <div class="img-wrap">
                        <img class="card-img-top image-card h-100" src="${image}" alt="${newpets[a].name}">`;
                    if (newpets[a].favorite === 'no') {
                        html += '<button id="btnFav" onclick="addFavorite(' + newpets[a].id + ', event);reduceLimit()" class="align-btn-right  btn-outline-danger"><span id="liked' + newpets[a].id + '" style="font-size: 16pt">&#9825;</span></img></div>';
                    } else {
                        html += '<button id="btnFav" onclick="removeFavorite(' + newpets[a].id + ', event);reduceLimit()" class="align-btn-right  btn-outline-danger"><span id="liked' + newpets[a].id + '" style="font-size: 16pt">&#9829;</span></img></div>';
                    }
                    html += '<div class="card-body-custom">';
                    html += '<a href="petInfo.php?id=' + newpets[a].id + '"><span class="title_card">' + newpets[a].name + '</span> &nbsp; <span style="color: black">-  ' + newpets[a].breed + '</span></a>';
                    var about = newpets[a].description.substr(0, 58);
                    about = about.substr(0, Math.min(about.length, about.lastIndexOf(" "))) + "...";
                    html += '<p class="card-text">' + about + '</p></div><div class="card-footer">';
                    date = newpets[a].date.substr(0, 10);
                    html += '<span id="publish">Datum: ' + date + '</span></div></div></div>';
                }
            }

            html += `<div class="col-12 h2">Svi ljubimci</div>`;

            for (var a = 0; a < pets.length; a++) {
                //svaki element
                html += `<div onclick="window.location='petInfo.php?id=${pets[a].id}';" style="cursor: pointer;" class="col-12 col-lg-4 col-md-6 mb-4 col-sm-6">
                            <div data-toggle="tooltip" title="Show more" class="blur card h-100-custom">
                                <div class="img-wrap">`;
                if (idUser != null && idUser === 1) {
                    html += `<span onclick="deletePet(${pets[a].id}, event)" id="deletePet" class="close">&times;</span>`;
                }
                const image = 'slike/' + pets[a].image;
                html += `<img class="card-img-top image-card h-100" src="${image}" alt="${pets[a].name}">`;
                if (pets[a].favorite === 'no') {
                    html += '<button id="btnFav" onclick="addFavorite(' + pets[a].id + ', event);reduceLimit()" class="align-btn-right  btn-outline-danger"><span id="liked' + pets[a].id + '" style="font-size: 16pt">&#9825;</span></img></div>';
                } else {
                    html += '<button id="btnFav" onclick="removeFavorite(' + pets[a].id + ', event);reduceLimit()" class="align-btn-right  btn-outline-danger"><span id="liked' + pets[a].id + '" style="font-size: 16pt">&#9829;</span></img></div>';
                }

                date = pets[a].date.substr(0, 10);

                html += `<div class="card-body-custom">
                            <a class="mb-1" href="petInfo.php?id=${pets[a].id}">
                                <span class="title_card">${pets[a].name}</span>
                            </a>
                            <span> - ${pets[a].breed}</span>    
                            <div class="card-text">
                                <div class="paragr">&#8226; Pol: ${pets[a].gender}</div>
                                <div class="paragr">&#8226; Grad: ${pets[a].address}</div>
                                <div class="paragr">&#8226; Vlasnik: ${pets[a].ownerName}</div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <span id="publish">Datum: ${date}</span>
                        </div>
                        </div>
                    </div>`;
            }
        }

        if (newpets.length > 0 && newPetsShow == 0 && data.id != 1) {
            vote(newpets);
            newPetsShow = 1;
        }

        removeNewPets();


        divIspis.innerHTML = html;

    }
}


function vote(newPets) {

    let html = '';

    isNoName = false;

    for (let index = 0; index < newPets.length; index++) {
        const pet = newPets[index];

        if (pet.name === 'Bez imena') {

            isNoName = true;

            const image = 'slike/' + pet.image;

            html += `<div id="pet-section-${pet.id}" class="mySlides">
                    <img class="closeBtn" src="res/images/close.png" onclick="closeModal()">
                    <img style="width:100%; max-height:320px; object-fit:cover; margin-top:10px" src="${image}">
                    <div id="gived-name">
                        <h3 class="text-center my-3">Dajte ime novom ljubimcu</h3>
                        <div class="d-flex justify-content-center">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input checked type="radio" id="newname1${pet.id}" name="newname${pet.id}" class="custom-control-input" value="${pet.petNames[0]}">
                                <label class="custom-control-label h5" for="newname1${pet.id}">${pet.petNames[0]}</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="newname2${pet.id}" name="newname${pet.id}" class="custom-control-input" value="${pet.petNames[1]}">
                                <label class="custom-control-label h5" for="newname2${pet.id}">${pet.petNames[1]}</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="newname3${pet.id}" name="newname${pet.id}" class="custom-control-input" value="${pet.petNames[2]}">
                                <label class="custom-control-label h5" for="newname3${pet.id}">${pet.petNames[2]}</label>
                            </div>
                        </div>
                        <button onclick="submitName(${pet.id})" type="button" class="btn btn-success mx-auto d-flex mt-3">Potvrdi</button>
                    </div>
                </div>`;

        }
    }

    if (isNoName == false) return;



    html += `<div class="caption-container">
                <div class="d-flex" style="position: absolute; top:50%; transform:translateY(-50%); left:-10%; height: 40px;">
                    <img onclick="plusSlides(-1)" src="res/images/previous.png" class="h-100" style="cursor: pointer;">
                </div>
                <div class="d-flex" style="position: absolute; top:50%; transform:translateY(-50%); right:-10%; height: 40px;">
                    <img onclick="plusSlides(1)" src="res/images/next.png" class="h-100" style="cursor: pointer;">
                </div>
            </div>`;

    document.getElementById('give-name').innerHTML = html;
    $('#newNameModal').modal('show');

    showSlides(slideIndex)
}

function noName(element) {
    if (element.checked) {
        element.parentElement.previousElementSibling.style.display = "none";
    } else {
        element.parentElement.previousElementSibling.style.display = "block";
    }
}

function submitName(petID) {

    const radioID = 'newname' + petID;

    let radios = document.getElementsByName(radioID);
    let petName = "";
    for (let i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            petName = radios[i].value;
            break;
        }
    }

    const http = new XMLHttpRequest();
    const method = "POST";
    const url = "api/pet/voteName.php";
    const asynchronous = true;

    http.open(method, url, asynchronous);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send("petID=" + petID + "&name=" + petName);
    http.onload = function () {
        var data = JSON.parse(http.responseText);
        console.log(data);
        if (data.success === '1') {
            const petElementID = '#pet-section-' + data.petID;
            const petElement = $("#give-name").find(petElementID)[0];
            const slides = document.getElementsByClassName("mySlides");
            petElement.lastElementChild.classList.add('voted');
            petElement.lastElementChild.innerHTML = "Hvala, Vaš glas je zabilježen! &#128077";
            setTimeout(function () {
                plusSlides(1);
                console.log(petElement)
                console.log(slides.length)

                if (slides.length == 1) {
                    $('#newNameModal').modal('hide');
                } else {
                    petElement.remove();
                }
            }, 2000);

        }
    }

}


var slideIndex = 1;

function closeModal() {
    $("#newNameModal").modal('hide')
}

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    const slides = document.getElementsByClassName("mySlides");

    if (n > slides.length) {
        slideIndex = 1
    }
    if (n < 1) {
        slideIndex = slides.length
    }
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    slides[slideIndex - 1].style.display = "block";
}


function removeNewPets() {
    var http = new XMLHttpRequest();
    var method = "POST";
    var url = "api/pet/deleteNewPets.php";
    var asynchronous = true;

    http.open(method, url, asynchronous);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send();
}

//load more pets - increase limit
btnLoad.addEventListener("click", function () {
    loadData();
});


//                              FILTER START
//checkButtons category
function vrijedsnotCheck() {
    const checksParent = (window.innerWidth < 991) ? document.getElementById('category-small') : document.getElementById('category-large');
    const checks = checksParent.querySelectorAll('input');

    var check_value = [];
    for (var i = 0; checks[i]; ++i) {
        if (checks[i].checked) {
            check_value[i] = checks[i].value;
        } else {
            check_value[i] = null;
        }
    }
    return check_value;
}

$(document).ready(function () {
    document.getElementById('all-s').checked = true;
    document.getElementById('all-l').checked = true;
});

//rb weight
function vrijedsnotRadio() {

    const checksParent = (window.innerWidth < 991) ? document.getElementById('weight-small') : document.getElementById('weight-large');
    const radios = checksParent.querySelectorAll('input');


    var radio_value = "";
    for (var i = 0; radios[i]; ++i) {
        if (radios[i].checked) {
            radio_value = radios[i].value;
        }
    }
    return radio_value;
}


//don't increase limit by filtering pets
function reduceLimit() {
    limit -= 3;
}

//                              FILTER END


//delete pet by ID - click on x
function deletePet(id, event) {
    event.stopPropagation();
    var http = new XMLHttpRequest();
    var method = "GET";
    var url = "api/pet/deletePet.php?id=" + id;
    var asynchronous = true;

    http.open(method, url, asynchronous);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send();
    loadData();
}

//add new pet 
const form = document.getElementById('dodaj-ljubimca');
form.addEventListener('submit', addPet);

function addPet(event) {

    event.preventDefault();

    var formData = new FormData(form);

    var http = new XMLHttpRequest();
    var method = form.getAttribute('method');
    var url = form.getAttribute('action');
    var asynchronous = true;

    formData = jQuery(document.forms['dodaj-ljubimca']).serializeArray();

    for (var i = 0; i < formData.length; i++) {
        data.append(formData[i].name, formData[i].value);
    }

    http.open(method, url, asynchronous);
    http.send(data);

    http.onload = function () {
        //let data = JSON.parse(this.responseText);
        //console.log(data);
        $('#modal-add_new').modal('hide')
        //window.alert('Successfully added new pet!')
    }
}

// function checkAddPet() {

// }

const slika_input = document.getElementById('slika_input');

const slike = Array.from(document.querySelectorAll(".slika_dodaj"));

var data = new FormData();



slika_input.addEventListener("change", function (event) {


    for (const file of this.files) {

        if (file) {

            if (file.size < 2097152) {

                if (file.type === "image/png" || file.type === "image/jpg" || file.type === "image/jpeg") {

                    console.log('njih je: ' + [...data.values()].length)
                    if ([...data.values()].length > 3) {

                        alert("Mozete odabrati maksimalno 4 slike");
                        return;
                    }

                    const slikaID = 'slika-' + [...data.keys()].length;
                    data.append(slikaID, file, file.name);

                    //Display the key / value pairs
                    // for (var pair of data.entries()) console.log(pair[0] + ', ' + pair[1]);
                    // console.log('');

                    for (const slika of slike) {

                        if (slika.dataset.imgg == 'empty') {

                            const reader = new FileReader();

                            reader.addEventListener("load", function () {
                                slika.src = reader.result;
                            });
                            reader.readAsDataURL(file);

                            let number = slika.getAttribute('id').slice(-1);

                            slika.dataset.imgg = slikaID;
                            document.getElementById('close' + number).style.display = "block";
                            slika.parentElement.style.pointerEvents = "none";
                            slika.parentElement.style.cursor = "auto";

                            break;
                        }

                    }

                    //document.getElementById('close-profile').style.display = "block";
                } else {
                    alert("Slika " + file.name + " nije u jpg, png ili jpeg formatu.");
                }
            } else {
                alert("Maksimalna velicina slike je 2MB");

            }
        }
    }

});

function zatvori_slika(broj, element) {
    const slikaIme = element.nextElementSibling.firstElementChild.dataset.imgg;
    data.delete(slikaIme);
    // Display the key/value pairs
    // for (var pair of data.entries()) console.log(pair[0]);
    // console.log('');

    document.getElementById('slika_' + broj).src = 'res/images/new_pet.png';
    element.style.display = "none";
    element.nextElementSibling.firstElementChild.dataset.imgg = "empty";
    element.nextElementSibling.style.pointerEvents = "auto"
    element.nextElementSibling.style.cursor = "pointer";
}


function addFavorite(id, e) {
    e.stopPropagation();

    var http = new XMLHttpRequest();
    var method = "POST";
    var url = "api/favoritePet/addFavorite.php";
    var asynchronous = true;
    http.open(method, url, asynchronous);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send('petID=' + id);

    http.onload = function () {
        let data = JSON.parse(this.responseText);
        loadData();
    }

}

function removeFavorite(id, e) {

    e.stopPropagation();
    var http = new XMLHttpRequest();
    var method = "POST";
    var url = "api/favoritePet/removeFavorite.php";
    var asynchronous = true;
    http.open(method, url, asynchronous);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send('petID=' + id);

    http.onload = function () {
        var data = JSON.parse(this.responseText);
        console.log(data);
        loadData();
    }

}



//select 2

$(document).ready(() => $('.js-example-basic-single').select2());

$(document).ready(() => $('.js-example-basic-multiple').select2());

const rase = {
    "pas": ['Labrador', 'Zlatni retriver', 'Njemacki ovcar', 'Pudlica', 'Belgijski ovcar'],
    "macka": ['Bengalska', 'Persijska'],
};

function selectRasa(rasa) {
    const rasaElement = document.getElementById('breed');
    const vrstaZivotinje = rasa.value;
    rasaElement.disabled = false;

    const rasaVrste = rase[vrstaZivotinje];

    rasaElement.innerHTML = '<option value="0" disabled selected hidden>Odaberi</option>';
    for (i = 0; i < rasaVrste.length; i++) {
        rasaElement.innerHTML = rasaElement.innerHTML + `<option value="${rasaVrste[i]}">${rasaVrste[i]}</option>`;
    }

}

const dodaj_ljubimca_btn = document.getElementById('dodaj_ljubimca_btn');

dodaj_ljubimca_btn.addEventListener("click", function () {
    if (idUser == null) {
        $('#modal-login').modal('show');
        return;
    }
    $('#modal-add_new').modal('show');
});
