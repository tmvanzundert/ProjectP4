function setErrorEmptyInputbox(ElementName) {

    const input = document.getElementById(ElementName);
    if (!input) return;
    if (input.value === "") {
        input.style.border = "1px solid red";
    }
    else {
        input.style.border = "none";
    }

}