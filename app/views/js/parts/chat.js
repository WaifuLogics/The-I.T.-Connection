function RetrieveAllFriends() {
    let options = {
        headers: {
            "content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        credentials: 'same-origin'
    };
    /* Retrieve all of the friends of the user */
    fetch("{{ path_for('chat-retrieve') }}", options)
        .then(response => response.json())
        .then(async (json) => {
            GetId('list-chat_friends').innerHTML = "";
            console.log(json);
            for (let friend of json.response) {
                if (friend.account_id != "{{ accountId }}") {
                    console.log(friend);
                    GetId('list-chat_friends').innerHTML += `
                    <button onclick="AddFriendToChatRoom(this.value)" class="btn blue waves-effect waves-light friend-btn" value="${await ReturnUserName(friend.account_id)}">Add ${await ReturnUserName(friend.account_id)}</button>
                `;
                } else if (friend.account_friended != "{{ accountId }}") {
                    GetId('list-chat_friends').innerHTML += `
                    <button onclick="AddFriendToChatRoom(this.value);" class="btn blue waves-effect waves-light friend-btn" value="${await ReturnUserName(friend.account_friended)}">Add ${await ReturnUserName(friend.account_friended)}</button>
                `;
                }
            }
        });
}

function AddFriendToChatRoom(friend) {
    console.log(friend);
    /* Get all of the friend buttons and compare the values of those buttons in order to add a added class*/
    let elems = document.getElementsByClassName('friend-btn');
    /* Loop over */
    for (let i = 0; i < elems.length; i += 1) {
        let cName = elems[i].className;
        if (elems[i].value == friend && !cName.includes("addFriend")) {
            M.toast({
                html: "added " + friend + " to chat room",
                displayLength: '1500',
                inDuration: '600',
                outDuration: '600'
            });
            elems[i].classList.add("addFriend");
            elems[i].innerHTML = "<i class='material-icons'>done</i> " + friend;
        } else if (elems[i].value == friend && cName.includes("addFriend")) {
            M.toast({
                html: "Removed " + friend + " from chat room",
                displayLength: '1500',
                inDuration: '600',
                outDuration: '600'
            });
            elems[i].classList.remove("addFriend");
            elems[i].innerHTML = "Add " + friend;
        }
    }
}

function CreateChatRoom() {
    let users = document.getElementsByClassName('addFriend');
    let json = [];
    for (let user of users) {
        json[json.length] = user.value;
    }

    if (json.length < 1) {
        M.toast({
            html: "Please add users into the chat room", displayLength: '1500',
            inDuration: '600',
            outDuration: '600'
        });
        return;
    }
    console.log(JSON.stringify(json));
}