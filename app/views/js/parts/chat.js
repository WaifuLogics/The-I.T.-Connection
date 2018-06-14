// function CreateNewChatRoom(){
//
// }

function RetrieveAllFriends(){
    let options = {
        headers: {
            "content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        credentials: 'same-origin'
    };
    fetch("{{ path_for('chat-retrieve') }}", options)
        .then(response => response.json())
        .then(async (json) => {
            GetId('list-chat_friends').innerHTML = "";
            console.log(json);
            for(let friend of json.response){
                if(friend.account_id != "{{ accountId }}"){
                    console.log(friend);
                    GetId('list-chat_friends').innerHTML += `
                    <button class="btn blue waves-effect waves-light friend-btn">Add ${await ReturnUserName(friend.account_id)}</button>
                `;
                }else if(friend.account_friended != "{{ accountId }}"){
                    GetId('list-chat_friends').innerHTML += `
                    <button class="btn blue waves-effect waves-light friend-btn">Add ${await ReturnUserName(friend.account_friended)}</button>
                `;
                }
            }
        });
}