let _ = (el) => document.getElementsByClassName(el);

function SetActive(mode) {
    for (let i of _(mode)) {
        i.className += " active";
    }
}

function Search(f_username) {
    /*The headers used to post data*/
    let headers = {
        method: 'post',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'x=8==D'
    };

    fetch('/inc/searchScript.php', headerInformation).then(response => response.text())
        .then(data => {
            document.getElementById('container-search_accounts_output').innerHTML += data;
        });
}