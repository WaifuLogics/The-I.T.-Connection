let _ = (el) => document.getElementsByClassName(el);
let GetId = (el) => document.getElementById(el);

function SetActive(mode) {
    for (let i of _(mode)) {
        i.className += " active";
    }
}

/* This function searches for users */
function Search(f_username, thisUser) {
  let bodyInfo = 'search-username=' + f_username + "&search_thisUser=" + thisUser;
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

function AddFriend(json) {
  let currentUser = json['userSearches'];
  let otherUser = json['searchedUser'];

  let bodyInfo = 'type=request&curUser=' + currentUser + '&othUser=' + otherUser;
  let headers = {
    method:'post',
    headers: {
      "content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    body: bodyInfo
  };
  /* Insert a friend request in the friend_request table*/
  fetch('/inc/friendScript.php', headers).then(response => response.text())
  .then(data => {
    if(data == "success"){
      M.toast({html: 'Friend Request Send', displayLength: '1500', inDuration: '600', outDuration: '600'});
      let friendBtn = document.getElementsByClassName('friend-button');
      for(let i = 0; i < friendBtn.length; i += 1){
        if(friendBtn[i].id == otherUser){
          friendBtn[i].style.display = "none";
        }
      }
    }
  });
}

function CheckFriendRequests(){
  let bodyInfo = 'type=check&userId=' + GetId('global-user_id').value;
  let headers = {
    method:'post',
    headers: {
      "content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    body: bodyInfo
  }

  fetch('/inc/friendScript.php', headers).then(response => response.text())
    .then(data => {
      cont = document.getElementsByClassName('friend_request-list');
      for(let i = 0; i < cont.length; i += 1){
        cont[i].innerHTML = data;
      }
    })
}

function AcceptRequest(array){
  let requester = array['requester'];
  let accepter = array['accepter'];

  let bodyInfo = 'type=accept&requester=' + requester + '&accepter=' + accepter;
  let headers = {
    method:'post',
    headers: {
      "content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    body: bodyInfo
  }

  fetch('/inc/friendScript.php', headers).then(response => response.text())
    .then(data => {
      console.log(data);
      if(data == 'success'){
        M.toast({html: 'Friend Added', displayLength: '1500', inDuration: '600', outDuration: '600'});
        CheckFriendRequests();
      }
    });
}
