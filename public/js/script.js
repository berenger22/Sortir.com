console.log('coucou');


document.getElementById("sortie_lieu").addEventListener("change", function () {
    console.log('coucou1');
    chargeDetailLieu();
});


function chargeDetailLieu() {
    console.log('coucou');
    url = 'http://127.0.0.1:8000/infoLieu/' + document.getElementById("sortie_lieu").value;
    fetch( url, {'method': 'GET'} )
    .then( response => response.json() )
    .then( response => {
        console.log(response);
        // document.getElementById("lieu_rue").innerHTML = response[0].rue;
        // document.getElementById("lieu_code_postal").innerHTML = response[0].ville.codePostal;
        // document.getElementById("lieu_ville").innerHTML = response[0].ville.nom;
        // document.getElementById("lieu_latitude").innerHTML = response[0].latitude;
        // document.getElementById("lieu_longitude").innerHTML = response[0].longitude;
    } )
}