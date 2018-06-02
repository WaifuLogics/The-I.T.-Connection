let _ = (el) => document.getElementsByClassName(el);

function SetActive(mode) {
    for (let i of _(mode)) {
        i.className += " active";
    }
}

function Search(f_username) {

  let bodyInfo = 'search-username=' + f_username;

    /*The headers used to post data*/
    let headers = {
        method: 'post',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: bodyInfo
    };

    fetch('/inc/searchScript.php', headers).then(response => response.text())
        .then(data => {
            document.getElementById('container-search_accounts_output').innerHTML = data;
        });
}
