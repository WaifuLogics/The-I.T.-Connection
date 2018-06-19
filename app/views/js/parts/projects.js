
/*

    --- Project System Functions

*/

/* This function limits the amount of characters used in a string*/
function LimitChars(event) {
    const el = event.target;
    if (el.value.length >= 32)
        event.preventDefault();
}

function ValidateProjectForm() {
    let title = GetId('project-name');
    let link = GetId('project-link');

    if (title.value.length > 0) {
        title.className = "has-character-counter";
        if (link.value.length > 0) {
            link.className = "has-character-counter";
            CreateNewProject(title, link);
        } else {
            link.className += " invalid";
        }
    } else {
        title.className += " invalid";
    }
}

function CreateNewProject(title, link) {
    let bodyInfo = 'project_title=' + title.value +
        '&project_link=' + link.value + '&user_id={{ accountId }}';
    let headers = {
        method: 'post',
        headers: {
            "content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: bodyInfo
    };
    fetch("{{ path_for('project-create') }}", headers).then(response => response.json())
        .then(json => {
                if (json.response == 'success') {
                    ClearProjectForm(title, link);
                    RetrieveProjects();
                    M.toast({html: "Project Created", displayLength: '1500', inDuration: '600', outDuration: '600'});
                }
            }
        );
}

function ClearProjectForm(title, link) {
    title.value = "";
    link.value = "";
}

async function RetrieveProjects() {
    let headers = {
        method: 'post',
        headers: {
            "content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
    };
    let data = await (await fetch("{{ path_for('project-retrieve') }}", headers)).json();
    GetId('list-project').innerHTML = "";
    for (let project of data.data) {
        /* Check if the user owns the project, if so, add a delete icon to the project container */
        if(project.project_creator == "{{ accountId }}"){
            GetId('list-project').innerHTML += `
                <li class="project-wrapper">
                <i id="${project.project_id}" data-creator="${project.project_creator}" onclick="DeleteProject(this.id);" class="material-icons right tooltipped" data-position="bottom" data-tooltip="Delete Project">clear</i>
                    <a href="${project.project_link}">
                        <p class="left-align">${project.project_name}</p>
                        <p class="left">Created By: ${await ReturnUserName(project.project_creator)}</p>
                        <div class="clearfix"></div>
                    </a>
                </li>
            `;
        }else{
            GetId('list-project').innerHTML += `
                <li class="project-wrapper">
                    <a href="${project.project_link}">
                        <p class="left-align">${project.project_name}</p>
                        <p class="left">Created By: ${await ReturnUserName(project.project_creator)}</p>
                        <div class="clearfix"></div>
                    </a>
                </li>
            `;
        }
        
    }
}

async function DeleteProject(projectId){
    /* Check if the user owns the project that is requested to be deleted */
    let creator;
    try{
        creator = GetId(projectId).getAttribute('data-creator'); 
    }catch{
        M.toast({html: "Could Not Delete Project,<br/>User Does Not Own This Project", displayLength: '1500', inDuration: '600', outDuration: '600'});        
        return;
    }

    let bodyInfo = 'project=' + projectId + "&creator=" + creator;
    let headers = {
        method: 'post',
        headers: {
            "content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: bodyInfo
    };

    let data = await(await fetch("{{ path_for('project-delete') }}", headers)).json();
    console.log(data);
    if(data.response == "success"){
        M.toast({html: "Project Deleted", displayLength: '1500', inDuration: '600', outDuration: '600'});
        RetrieveProjects();
    }else{
        M.toast({html: "Could Not Delete Project", displayLength: '1500', inDuration: '600', outDuration: '600'});
    }
}