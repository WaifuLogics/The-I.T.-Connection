let _ = (el) => document.getElementsByClassName(el);
let GetId = (el) => document.getElementById(el);

function SetActive(mode) {
    for (let i of _(mode)) {
        i.className += " active";
    }
}

/* The following files have been split up to make this file look cleaner */

/* Include js/parts/friends.js */
{% include 'js/parts/friends.js' %}

/* Include js/parts/search.js */
{% include 'js/parts/search.js' %}

/* Include js/parts/projects.js */
{% include 'js/parts/projects.js' %}
