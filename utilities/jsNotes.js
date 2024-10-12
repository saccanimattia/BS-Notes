mermaid.initialize({ startOnLoad: true });

function trovaAppunti(id) {
    var divs = document.getElementsByClassName("appunto")[0].getElementsByTagName("div");
    var divs2 = document.getElementsByClassName("s");
    var selected = document.getElementById("icon"+id);
    for (var i = 0; i < divs.length; i++) {
        if (!isNaN(parseInt(divs[i].className.substr(-1)))) {
            divs[i].style.display = "none";
        }
    }
    for (var i = 0; i < divs2.length; i++) {
        divs2[i].style.backgroundColor = "#0d6efd";
        divs2[i].style.border = "2px solid transparent";
    }
    selected.style.backgroundColor = "#04c0f5";
    selected.style.border = "2px solid white";
    document.getElementsByClassName(id)[0].style.display = "block";
    document.getElementById("diagram-container-" + id).childNodes[1].setAttribute("style", "display: block;")
}

function search() {
    $searchValue = document.getElementById("search").value;
    if($searchValue == "")
        showAll()
    var divs = document.getElementsByClassName("s");
    for(var i = 0; i < divs.length; i++) {
        if(divs[i].getElementsByTagName("h4")[0].innerHTML.toLowerCase().includes($searchValue.toLowerCase())) {
            divs[i].style.display = "block";
        } else {
            divs[i].style.display = "none";
        }
    }
    
}
function showAll() {
    const divs = document.getElementsByClassName("s");
    for(let i = 0; i < divs.length; i++) {
        divs[i].style.display = "block"
    }
}
const option_icon = ["bi-caret-down-fill", "bi-caret-left-fill"]

$(document).ready(function() {
    const options = document.getElementsByClassName("note_options_opener")
    console.log(options[0])
    for(let i=0;i<options.length;i++)
        options[i].onclick = showOptions
})

function showOptions(e) {
    let selection = e.target
    console.log(selection)
    if(selection.className.includes(option_icon[0]))
        changeOptionsVisibility(selection.id.replace("options_opener_", ""), "none", option_icon[0], option_icon[1])
    else 
        changeOptionsVisibility(selection.id.replace("options_opener_", ""), "inline-block", option_icon[1], option_icon[0])
}
function changeOptionsVisibility(id, visibility, oldicon, newicon) {
    console.log("!")
    $("#options_opener_" + id).removeClass(oldicon)
    $("#options_opener_" + id).addClass(newicon)
    $("#container_options_" + id).css("display", visibility)
}