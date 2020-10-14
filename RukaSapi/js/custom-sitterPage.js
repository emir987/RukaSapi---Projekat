function f() {

  var h1 = document.getElementById('sitterName');
  var sitterPhoto = document.getElementById('sitterPhoto');
  var sitterInfo = document.getElementById('sitterInfo');
  var sitterInfos = document.getElementById('sitterInfos');

  var http = new XMLHttpRequest();
  var method = "GET";
  var url = "api/sitter/getSitter.php?id=" + id;
  var asynchronous = true;

  http.open(method, url, asynchronous);
  http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  http.send();

  http.onload = function () {
    var data = JSON.parse(this.responseText);
    console.log(data);
    var sitter = data.sitter;

    h1.innerHTML = sitter.name + " " + sitter.surname;
    sitterPhoto.src = "slike_profil/" + sitter.image;
    sitterInfo.innerHTML = "<b>Opis:</b><br>" + sitter.info;
    var cares = "";
    if (sitter.dog == 1 && sitter.cat == 1) {
      cares = "Pas i macka";
    } else if (sitter.dog == 1 && sitter.cat == 0) {
      cares = "Pas";
    }
    if (sitter.dog == 0 && sitter.cat == 1) {
      cares = "Macka";
    }

    let since = "";
    if (!sitter.years) {
      since += sitter.month + " mjeseci";
    } else {
      since += sitter.years + " godina";
    }

    sitterInfos.innerHTML = `<table class="table1 table table-striped">\n
              <thead>\n
                <tr>\n
                  <th scope="col">Telefon</th>\n
                  <th scope="col">Email</th>\n
                  <th scope="col">Adresa</th>\n
                </tr>\n
              </thead>\n
              <tbody>\n
                <tr>\n
                  <td>${sitter.phone}</td>\n
                  <td>${sitter.email}</td>\n
                  <td>${sitter.address}</td>\n
                </tr>\n
              </tbody>\n
            </table>
            <table class="table2 table table-striped">\n
              <thead>\n
                <tr>\n
                  <th scope="col">Iskustvo</th>\n
                  <th scope="col">Brine se o:</th>\n
                  <th scope="col">Max težina psa</th>\n
                  <th scope="col">Cijena</th>\n
                </tr>\n
              </thead>\n
              <tbody>\n
                <tr>\n
                  <td>${since}</td>\n
                  <td>${cares}</td>\n
                  <td>${sitter.weight}kg</td>\n
                  <td>${sitter.price}$ po satu</td>\n
                </tr>\n
              </tbody>\n
            </table>`;

    loadReviews();
  }
}

function submitFormReview() {

  const form = document.getElementById('reviewForm');
  const formData = new FormData(form);
  formData.append("sitterID", id);

  const http = new XMLHttpRequest();
  const method = "POST";
  const url = 'api/sitter/reviewSitter.php';
  const asynchronous = true;

  http.open(method, url, asynchronous);
  http.send(formData);

  http.onload = function () {
    var data = JSON.parse(this.responseText);
    console.log(data);
    loadReviews();
    $('#reviewForm').trigger("reset");
  }
}


function loadReviews() {

  var comments = document.getElementById('comments');

  var http = new XMLHttpRequest();
  var method = "GET";
  var url = "api/sitter/loadReview.php?id=" + id;
  var asynchronous = true;

  http.open(method, url, asynchronous);
  http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  http.send();

  http.onload = function () {
    var data = JSON.parse(this.responseText);
    console.log(data);
    var reviewArray = data.reviews;
    var html = "";

    for (var a = 0; a < reviewArray.length; a++) {
      $reviewID = reviewArray[a].id;
      $review = reviewArray[a].review;

      html += '<div class="media mb-4">';
      html += '<img class="d-flex mr-3 rounded-circle" style="width: 50px; height: 50px;" src="slike_profil/' + reviewArray[a].commentator.image + '" alt="">';
      html += '<div class="media-body">';
      var commentator = reviewArray[a].commentator.name + " " + reviewArray[a].commentator.surname;
      var ago = '';
      var formattedDate = reviewArray[a].date.substr(0, 10) + ' at ' + reviewArray[a].date.substring(10, 16) + 'h';
      if (reviewArray[a].hours !== 'no') {
        ago += reviewArray[a].hours + ' hour ago';
      } else {
        ago += formattedDate;
      }
      html += '<span class="mt-0 font-weight-bold">' + commentator + '</span><span class="ml-4 comment" data-toggle="tooltip" data-placement="auto right" title="' + formattedDate + '">' + ago + '</span>';

      html += '<div id="comment' + $reviewID + '">' + reviewArray[a].review + '</div></div>';


      if (reviewArray[a].commentator.userID == userID) {
        html += '<button  onclick="deleteReview(' + $reviewID + ')" class="mt-3 btn btn-link btn-sm text-danger">Delete</button >';

      }
      html += '</div>';
    }
    comments.innerHTML = html;


  }
}

function deleteReview(id) {
  var http = new XMLHttpRequest();
  var method = "POST";
  var url = "api/sitter/deleteReview.php";
  var asynchronous = true;

  http.open(method, url, asynchronous);
  http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  http.send('id=' + id);

  http.onload = function () {
    var data = JSON.parse(this.responseText);
    console.log(data);
    loadReviews();
  };
}
$(document).ready(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

