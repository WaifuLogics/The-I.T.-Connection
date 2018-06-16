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
            /* Clear the entire friend list to prevent duplicates */
            GetId('list-chat_friends').innerHTML = "";
            for (let friend of json.response) {
                if (friend.account_id != "{{ accountId }}") {
                    /* Insert a button with the account_id as value */
                    GetId('list-chat_friends').innerHTML += `
                    <button onclick="AddFriendToChatRoom(this.value)" data-userId="${await friend.account_id}" class="btn blue waves-effect waves-light friend-btn" value="${await ReturnUserName(friend.account_id)}">Add ${await ReturnUserName(friend.account_id)}</button>
                `;
                } else if (friend.account_friended != "{{ accountId }}") {
                    GetId('list-chat_friends').innerHTML += `
                    <button onclick="AddFriendToChatRoom(this.value);" data-userId="${await friend.account_friended}" class="btn blue waves-effect waves-light friend-btn" value="${await ReturnUserName(friend.account_friended)}">Add ${await ReturnUserName(friend.account_friended)}</button>
                `;
                }
            }
        });
}

function AddFriendToChatRoom(friend) {
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
        /* Get the custom data attributes from the add friend to chat button and insert it into the JSON object */
        json[json.length] = user.getAttribute("data-userId");
    }

    if (GetId('chat_room_name').value.length > 0 && GetId('chat_room_name').value.length <= 32) {
        if (json.length < 1) {
            M.toast({
                html: "Please add one more friend to the chat room",
                displayLength: '1500',
                inDuration: '600',
                outDuration: '600'
            });
            return;
        }
    } else {
        M.toast({
            html: "Please fill in a valid room name.",
            displayLength: '1500',
            inDuration: '600',
            outDuration: '600'
        });
        return;
    }
    let jsonText = {
        "users": json
    };
    let bodyInfo = "roomName=" + GetId('chat_room_name').value + "&users=" + window.btoa(JSON.stringify(jsonText));
    let options = {
        method: 'post',
        headers: {
            "content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: bodyInfo
    };
    M.toast({
        html: "Creating Chat Room",
        displayLength: '1500',
        inDuration: '600',
        outDuration: '600'
    });
    fetch("{{ path_for('chat-create') }}", options).then(response => response.json())
        .then(json => {
            if (json.response == "success") {
                M.toast({
                    html: "Chat Room Created",
                    displayLength: '1500',
                    inDuration: '600',
                    outDuration: '600'
                });
                ClearCreateChatRoomForm();
                window.location = "{{ path_for('chat') }}";
            }
        });
}

function ClearCreateChatRoomForm(){
    GetId('chat_room_name').value = "";
    /* Get all of the friend-button elements */
    let users = document.getElementsByClassName('friend-btn');
    for(let elem of users){
        /* Check if the elements contain a class of addFriend, if so, remove the class */
        if(elem.classList.contains('addFriend') && !elem.classList.contains('hidden')){
            elem.innerHTML = "Add " + elem.value;   
            elem.classList.remove("addFriend");
        }
    }
}