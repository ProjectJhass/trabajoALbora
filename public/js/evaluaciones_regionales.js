function limitarInput(input, nextInputIndex) {
    if (input.value.length > 1) {
        input.value = input.value.slice(0, 1);
    }
    if (input.value.length === 1) {
        var nextInput =
            document.getElementsByClassName("caracter")[nextInputIndex - 1];
        if (nextInput) {
            nextInput.focus();
        }
    }
    let digito1 = document.getElementById("digito1").value || "";
    let digito2 = document.getElementById("digito2").value || "";
    let digito3 = document.getElementById("digito3").value || "";
    let digito4 = document.getElementById("digito4").value || "";
    let codigos = digito1 + digito2 + digito3 + digito4;
    $("#codigos").val(codigos);
}
