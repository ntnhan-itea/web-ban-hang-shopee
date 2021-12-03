
// Creat last date moddified in HTML element.
// Creat last date moddified in HTML element.
function lastModified () {
    let getDay = new Date(document.lastModified);
    // let lastUpdate = `<i><small><b>Last modified:</b> ${getDay.toLocaleString()}</small></i>`
    let lastUpdate = getDay.toLocaleString();

    // document.getElementById('last-modified').innerHTML = lastUpdate;
    // document.getElementById('last-modified').style.position = 'absolute';
    console.log("`Last update: " + lastUpdate +"`");
}
