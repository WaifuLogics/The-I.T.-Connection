let _ = (el) => document.getElementsByClassName(el);
let GetId = (el) => document.getElementById(el);

function SetActive(mode) {
    for (let i of _(mode)) {
        i.className += " active";
    }
}

/* This function searches for users */
function Search(f_username) {
    let thisUser = "{{ accountId }}";
    console.log(thisUser);
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
            for (let friend of json.friends) {
                if (friend.account_id == userID) {
                    /* The requester sees the friend*/
                    for (let list of document.getElementsByClassName("friend-list")) {
                        list.innerHTML += `
                         <li class="container-user">
                             <div class="col s12 wrapper-user">
                                 <img class="user-img" src="/img/users/test.png" alt="user image"/>
                                 <p>${await ReturnUserName(friend.account_friended)}</p>
                             </div>
                         </li>
                     `;
                    }
                } else {
                    /* The accepter sees the friend*/
                    for (let list of document.getElementsByClassName("friend-list")) {
                        list.innerHTML += `
                         <li class="container-user">
                             <div class="col s12 wrapper-user">
                                 <img class="user-img" src="/img/users/test.png" alt="user image"/>
                                 <p>${await ReturnUserName(friend.account_id)}</p>
                             </div>
                         </li>
                     `;
                    }
                }
            }
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

/*

    --- Project System Functions

*/

/* This function limits the amount of characters used in a string*/
function LimitChars(event) {
    const el = event.target;
    if (el.value.length >= 32)
        event.preventDefault();
}

function ValidateProjectForm(){
    let title = GetId('project-name');
    let link = GetId('project-link');

    if(title.value.length > 0){
        title.className = "has-character-counter";
        if(link.value.length > 0){
            link.className = "has-character-counter";
            CreateNewProject(title, link);
        }else{
            link.className += " invalid";
        }
    }else{
        title.className += " invalid";
    }
}

function CreateNewProject(title, link){
    let bodyInfo = 'project_title=' + title.value +
        '&project_link=' + link.value + '&user_id={{ accountId }}';
    console.log(bodyInfo);
    let headers = {
        method: 'post',
        headers: {
            "content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: bodyInfo
    };
    fetch("{{ path_for('project-create') }}", headers).then(response => response.json())
        .then(json => {
            if(json.response == 'success'){
                ClearProjectForm(title, link);
                RetrieveProjects();
            }
        }
    );
}

function ClearProjectForm(title, link){
    title.value = "";
    link.value = "";
}

async function RetrieveProjects(){
    let headers = {
        method: 'post',
        headers: {
            "content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
    };

    let data = await (await fetch("{{ path_for('project-retrieve') }}", headers)).json();
    console.log(data);
    for(let project of data.data){
        GetId('list-project').innerHTML += `
            <li class="project-wrapper">
                <a class="left-align" href="${project.project_link}">${project.project_name}</a>
                <div class="project-details">
                    <a class="right-align">Created By: ${project.project_creator}</a>
                </div>
            </li>
        `;
    }
    GetId('list-project').innerHTML += `
            <li class="project-wrapper">
                <a id="create_article-button" class="modal-trigger" href="#modal-createproject">Create New
                Project</a>
            </li>
        `;
}