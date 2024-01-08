

function previewProfile(input){
    if(input.files && input.files[0]) {
        var fileReader = new FileReader();
        fileReader.onload = function(event) {
            $("#profile-picture-preview").attr("src", event.target.result)
            $("#profile-picture-preview").show()
        }
        fileReader.readAsDataURL(input.files[0])
    }
}