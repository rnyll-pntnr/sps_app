$(function() {
    setFilterValues();
    onloadFunction();
});

function onloadFunction() {
    $(document).on('load', function() {
        
    })
}

function setFilterValues() {
    $(document).on('click', '#filterList', function(e) {
        e.preventDefault()
        window.location.replace(`home?from=${$('#fromDate').val()}&to=${$('#toDate').val()}`)
    })
}