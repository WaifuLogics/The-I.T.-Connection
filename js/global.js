let _ = (el) => document.getElementsByClassName(el);

function SetActive(mode) {
    for (let i of _(mode)) {
        i.className += " active";
    }
}