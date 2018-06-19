/* This function searches for users */
function Search(f_username) {
    let thisUser = "{{ accountId }}";
    let bodyInfo = 'search-username=' + f_username + "&search_thisUser=" + thisUser;
    /*The headers used to post data*/
    let headers = {
        method: 'post',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: bodyInfo
    };

    /* Return the result of the search request */
    fetch("{{ path_for('search') }}", headers).then(response => response.text())
        .then(data => {
            document.getElementById('container-search_accounts_output').innerHTML = data;
        });
}

async function ReturnUserName(str) {
    let bodyInfo = 'type=getUserId&userId=' + str;
    let headers = {
        method: 'post',
        headers: {
            "content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: bodyInfo
    };
    /* Execute a fetch and wait for a response without stalling the DOM */
    const getUser = async identifier => await (await fetch("{{ path_for('friend-getUserId') }}", headers)).json();
    /* Wait for the response of the request and then return the username */
    let userName = await getUser();
    return userName.account_name;
}