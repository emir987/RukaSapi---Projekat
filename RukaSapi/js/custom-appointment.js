
$(document).ready(function (e) {
    screen_resize();
});

$(window).resize(function (e) {
    screen_resize();
});

function screen_resize() {
    var w = parseInt(window.innerWidth);

    if (w <= 991) {
        document.getElementById("change_container").classList.add('container');
        document.getElementById("change_container").classList.remove('container-fluid');
    } else {
        document.getElementById("change_container").classList.add('container-fluid');
        document.getElementById("change_container").classList.remove('container');
    }

    if (w <= 575) {
        document.getElementById("change_container").classList.add('container');
        document.getElementById("change_container").classList.remove('container-fluid');
    } else {
        document.getElementById("change_container").classList.add('container-fluid');
        document.getElementById("change_container").classList.remove('container');
    }

}


//min datum je danas
startDateID.min = new Date().toISOString().split("T")[0];

function getWeight() {
    var sizes = document.getElementsByName('sizeRadio');
    var selected = "";
    for (i = 0; i < sizes.length; i++) {
        if (sizes[i].checked) {
            selected = sizes[i].value;
        }
    }
    return selected;
}

function findSitters(lat, lng) {

    // var zip = document.getElementById('location').value;
    // var weight = getWeight();

    var http = new XMLHttpRequest();
    var method = "POST";
    var url = "api/sitter/getAllSitters.php";
    var asynchronous = true;



    http.open(method, url, asynchronous);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send('lat=' + lat + "&lng=" + lng);
    http.onload = function () {
        var data = JSON.parse(http.responseText);
        console.log(data);



        if (data.success == 0) {
            document.getElementById('sitters').innerHTML = `
                    <h4 class="text-center col-lg-12">Nismo pronašli nijednog radnika koji odgovara vašem kriterijumu.</h4>
                    <h6 class="text-center col-lg-12">Pokušajte da promjenite kriterijum ili promijenite lokaciju.</h6>`;
            return;
        }

        var sitters = data.sitters;
        console.log(sitters)
        var html = "";

        for (var a = 0; a < sitters.length; a++) {

            html += '<div class="col-12 col-lg-4 col-md-6 mb-4 col-sm-6  p-0">';
            html += '<div class="img-wrap-app">';
            html += '<img class="card-img-top image-card" style="height: 300px" src="slike_profil/' + sitters[a].image + '" alt="' + sitters[a].name + '">';
            html += '</div></div>';
            html += '<div style="background-color:#f2faff" class="col-12 col-lg-8 col-md-6 mb-4 col-sm-6">';

            let starsHTML = '';
            const starsSum = sitters[a].starsSum;
            const starsCount = sitters[a].reviews;
            const stars = Math.round(starsSum / starsCount * 10) / 10;
            const starsArray = stars.toString().split('.');
            console.log('starrs ' + starsArray[0] + " " + starsArray[1]);

            for (let index = 0; index < parseInt(starsArray[0]); index++) {
                starsHTML += '<i class="fa fa-star" aria-hidden="true"></i>';
            }

            if (starsArray[1] > 2 || starsArray[1] < 8) {
                starsHTML += '<i class="fa fa-star-half" aria-hidden="true"></i>';
            }


            //pocinje
            html += '<div class="d-flex justify-content-between" id="headerText">';
            html += '<div class="" id="FirstHeaderText">';
            var start = document.getElementById('startDateID').value;
            html += `<div class="d-flex"><h3><a class="text-success" href="sitterPage.php?id=${sitters[a].id}&start=${start}">${sitters[a].name} ${sitters[a].surname}</a></h3><div class="stars-rating">${starsHTML}</div></div>`;
            html += `<div>Adresa: ${sitters[a].address}</div><span class="font-size text-dark font-weight-bold">${sitters[a].mainMessage}</span><br><br>`;
            html += '<span class="pointer font-weight-bolder text-uppercase small border border-success text-success p-1 border-10 border-dotted">' + sitters[a].reviews + ' reviews</span><br>';
            html += '</div>';


            html += '<div class="">';
            if (sitters[a].favorite === 'no') {
                if (data.logged == '0') {
                    html += '<button id="btnFavSitter" data-toggle="modal" data-target="#modal-login" role="button" class="align-btn-right  btn-outline-danger float-right"><span id="liked' + sitters[a].id + '" style="font-size: 16pt">&#9825;</span></button>';
                } else {
                    html += '<button id="btnFavSitter" onclick="addFavoriteSitter(' + sitters[a].id + ')" class="align-btn-right  btn-outline-danger float-right"><span id="liked' + sitters[a].id + '" style="font-size: 16pt">&#9825;</span></button>';
                }
            } else {
                html += '<button id="btnFavSitter" onclick="removeFavoriteSitter(' + sitters[a].id + ')" class="align-btn-right  btn-outline-danger float-right"><span id="liked' + sitters[a].id + '" style="font-size: 16pt">&#9829;</span></button>';
            }
            html += '<h4 class="text-danger font-size">' + sitters[a].price + "$/walk" + '</h4>';
            html += '</div>';
            html += '</div>';
            //zavrsava


            //pocinje
            var allReviews = sitters[a].allReviews;
            html += '<div class="mt-3" id="bodyText">';
            for (let b = 0; b < allReviews.length; b++) {
                if (b > 1) break;
                html += '<p>' + allReviews[b];
                if (allReviews[b].length > 20) {
                    html += '<a href="sitterPage.php?id=' + sitters[a].id + '//#comments"> (see more...)</a>' + '</p>';
                }
            }
            html += '</div>';
            //zavrsava


            html += '<div id="footerText" class="mt-sm-2">';
            html += '<span class="text-danger" >Favourites: ' + sitters[a].favs + '</span>';
            html += '</div>';
            html += '</div>';

        }
        //ispis
        document.getElementById('sitters').innerHTML = html;
    }
}

function addFavoriteSitter(id) {

    console.log(id);
    var http = new XMLHttpRequest();
    var method = "POST";
    var url = "api/favoriteSitter/addFavorite.php";
    var asynchronous = true;
    http.open(method, url, asynchronous);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send('sitterID=' + id);

    http.onload = function () {
        var data = JSON.parse(this.responseText);
        console.log(data);
        findSitters();
    }

}

function removeFavoriteSitter(id) {

    var http = new XMLHttpRequest();
    var method = "POST";
    var url = "api/favoriteSitter/removeFavorite.php";
    var asynchronous = true;
    http.open(method, url, asynchronous);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send('sitterID=' + id);

    http.onload = function () {
        var data = JSON.parse(this.responseText);
        console.log(data);
        findSitters();
    }

}