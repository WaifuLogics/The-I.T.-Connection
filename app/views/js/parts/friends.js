/*

    --- Friend System Functions ---

*/

function AddFriend(json) {
    let currentUser = json['userSearches'];
    let otherUser = json['searchedUser'];

    let bodyInfo = 'type=request&curUser=' + currentUser + '&othUser=' + otherUser;
    let headers = {
        method: 'post',
        headers: {
            "content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: bodyInfo
    };
    /* Insert a friend request in the friend_request table*/
    fetch("{{ path_for('friend-request') }}", headers).then(response => response.text())
        .then(data => {
            if (data == "success") {
                M.toast({html: 'Friend Request Send', displayLength: '1500', inDuration: '600', outDuration: '600'});
                let friendBtn = document.getElementsByClassName('friend-button');
                for (let i = 0; i < friendBtn.length; i += 1) {
                    if (friendBtn[i].id == otherUser) {
                        friendBtn[i].style.display = "none";
                    }
                }
            }
        });
}

function CheckFriendRequests() {
    let bodyInfo = 'type=check&userId={{ accountId }}';
    let headers = {
        method: 'post',
        headers: {
            "content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: bodyInfo
    };

    fetch("{{ path_for('friend-check') }}", headers).then(response => response.text())
        .then(data => {
            let cont = document.getElementsByClassName('friend_request-list');
            for (let i = 0; i < cont.length; i += 1) {
                cont[i].innerHTML = data;
            }
        })
}

function AcceptRequest(array) {
    let requester = array['requester'];
    let accepter = array['accepter'];

    let bodyInfo = 'type=accept&requester=' + requester + '&userId=' + accepter;
    let headers = {
        method: 'post',
        headers: {
            "content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: bodyInfo
    };

    fetch("{{ path_for('friend-accept') }}", headers).then(response => response.text())
        .then(data => {
            if (data == 'success') {
                M.toast({html: 'Friend Added', displayLength: '1500', inDuration: '600', outDuration: '600'});
                CheckFriendRequests();
                RetrieveFriends()
            }
        });
}

function RetrieveFriends() {
    let userID = "{{ accountId }}";
    let bodyInfo = 'type=retrieve&userId=' + userID;
    let headers = {
        method: 'post',
        headers: {
            "content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: bodyInfo
    };
    fetch("{{ path_for('friend-retrieve') }}", headers)
        .then(response => response.json())
        .then(async json => {
            document.getElementsByClassName("friend-list").innerHTML = "";
            for (let friend of json.friends) {
                /* Create a JSON object and encode it in base64 */
                if (friend.account_id == userID) {
                    /* The requester sees the friend*/
                    for (let list of document.getElementsByClassName("friend-list")) {
                        let id = await ReturnUserName(friend.account_friended);
                        list.innerHTML += `
                         <li class="container-user">
                            <a href="{{ path_for('account', {'id': '${id}'}) }}">
                                <div class="col s12 wrapper-user">
                                    <img class="user-img" src="/img/users/test.png" alt="user image"/>
                                    <p>${id}</p>
                                </div>
                            </a>
                         </li>
                     `;
                    }
                } else {
                    let id = await ReturnUserName(friend.account_id);
                    console.log(id);
                    /* The accepter sees the friend*/
                    for (let list of document.getElementsByClassName("friend-list")) {
                        list.innerHTML += `
                         <li class="container-user">
                            <a href="{{ path_for('account', {'id': '${id}'}) }}">
                                <div class="col s12 wrapper-user">
                                    <img class="user-img" src="/img/users/test.png" alt="user image"/>
                                    <p>${id}</p>
                                </div>
                            </a>
                         </li>
                     `;
                    }
                }
            }
        });
}