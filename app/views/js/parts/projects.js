
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
    GetId('container-projects').innerHTML += `
            <li id="btn-create_project">
                <a id="create_article-button" class="modal-trigger" href="#modal-createproject">Create New
                Project</a>
            </li>
        `;
    let data = await (await fetch("{{ path_for('project-retrieve') }}", headers)).json();
    GetId('list-project').innerHTML = "";
    console.log(data);
    for (let project of data.data) {
        GetId('list-project').innerHTML += `
            <li data-user="${project.project_creator}" class="project-wrapper search">
                <a href="${project.project_link}">
                    <p class="left-align">${project.project_name}</p>
                    <p class="left-align">Created By: ${await ReturnUserName(project.project_creator)}</p>
                    <div class="clearfix"></div>
                </a>
            </li>
        `;
    }
}