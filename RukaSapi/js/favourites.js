//load favourite pets

function loadFavouriteData() {

    var http = new XMLHttpRequest();
    var method = "POST";
    var url = "api/favoritePet/getAllFavorite.php";
    var asynchronous = true;

    http.open(method, url, asynchronous);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send("idUser=" + idUser);
    console.log(idUser)
    http.onload = function () {
        var data = JSON.parse(http.responseText);
        console.log(data);
        var pets = data.pets;
        var html = "";


        if (data.success === "1") {

            for (var a = 0; a < pets.length; a++) {
                //svaki element
                html += `<div style="cursor: pointer;" class="col-12 col-lg-4 col-xl-3 col-md-6 mb-4 col-sm-6">
                            <div data-toggle="tooltip" title="Show more" class="blur card h-100-custom">
                                <div class="img-wrap">
                                    <span onclick="deletePet(${pets[a].id})" id="deletePet" class="close">&times;</span>
                                    <img class="card-img-top image-card" style="height: 180px;" src="slike/${pets[a].photo}" alt="${pets[a].name}">`
                if (pets[a].favorite === 'no') {
                    html += '<button id="btnFav" onclick="addFavorite(' + pets[a].id + ');reduceLimit()" class="align-btn-right btn-outline-danger"><span id="liked' + pets[a].id + '" style="font-size: 16pt">&#9825;</span></button></div>';
                } else {
                    html += '<button id="btnFav" onclick="removeFavorite(' + pets[a].id + ');reduceLimit()" class="align-btn-right  btn-outline-danger"><span id="liked' + pets[a].id + '" style="font-size: 16pt">&#9829;</span></button></div>';
                }
                html += '<div class="card-body-custom">';
                html += '<a href="petInfo.php?id=' + pets[a].id + '"><span class="title_card">' + pets[a].name + '</span> &nbsp; <span style="color: black">-  ' + pets[a].breed + '</span></a>';
                let about = pets[a].description.substr(0, 98);
                about = about.substr(0, Math.min(about.length, about.lastIndexOf(" "))) + "...";
                html += '<p class="card-text">' + about + '</p></div><div class="card-footer">';
                date = pets[a].date.substr(0, 10);
                html += '<span id="publish">Date: ' + date + '</span></div></div></div>';
            }
        }

        var divIspis = document.getElementById('showMore');
        divIspis.innerHTML = html;


    }
}