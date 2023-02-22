$(document).ready(function() {
    
});


function confirmDelete($message = "Are you sure?") {
    var x = confirm($message);
    if (x)
        return true;
    else
        return false;
}

