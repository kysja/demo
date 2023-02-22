$(document).ready(function() {

    // States dropdown change event handler | jQuery
    $('#stateSel').on('change', function() { 
        let qs = $(this).data('qs');
        let state = this.value ? 'state=' + this.value : '';
        if (qs != '' && state != '') qs += '&';
        $(location).attr('href', '/?' + qs + state);
    });


    // Search input <Enter> keyup event handler | jQuery
    $("#search").keyup(function(event){
        if(event.keyCode == 13){
            let qs = $(this).data('qs');
            let query = (this.value != '') ? 'search=' + encodeURIComponent(this.value) : '';
            if (qs != '' && query != '') qs += '&';
            $(location).attr('href', '/?' + qs + query);
        }
    });


    



    // Rating stars click event handlers | Javascript
    let allStars = document.querySelectorAll('.starRate');
    allStars.forEach(function(elem) {
        elem.addEventListener("click", function() {

            let id = this.dataset.id;
            let rate = this.dataset.rate;
            let current = this.parentElement.dataset.current;

            if (rate == current) return; // Do nothing if the same rate is clicked
            else this.parentElement.dataset.current = rate; // Update current rate

            fetchStarsUpdate(id, rate)
                .then(data => { 
                    if (data.status == 'success') {
                        for (let i = 1; i <= 5; i++) {
                            let starElement = document.getElementById("star-" + id + "-" + i);
                            if (i <= rate) 
                                starElement.classList.add("active");
                            else 
                                starElement.classList.remove("active");
                        }
                    }
                })
                .catch(error => { console.log(error) });
        });
    });



});


// Request server to update rating stars | Javascript
async function fetchStarsUpdate(id, rate) {
    const response = await fetch('/ajax/stars?id=' + id + '&rate=' + rate);
    if (response.status !== 200) {
        throw Error(response.statusText);
    }
    const result = await response.json();
    return result;
}



