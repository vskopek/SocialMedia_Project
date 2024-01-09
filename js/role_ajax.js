function editClicked(clickedID) {

    $.post(
        "role_ajax",
        {"userId" : clickedID},
        function (response, status, request){
            let insertInto = document.querySelector("#insert-modal")
            insertInto.innerHTML = response;
        }
    )
}