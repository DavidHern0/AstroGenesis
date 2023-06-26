<script>
function actualizarRecursos() {
    $.ajax({
        url: '/update-all',
        method: 'GET',
        success: function(response) {
      console.log("Resources updated");
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });
}
setInterval(actualizarRecursos, 5000);
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>