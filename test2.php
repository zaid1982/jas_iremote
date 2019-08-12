
kasflkdjslfk


<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script> if (!window.jQuery) {
        document.write('<script src="js/libs/jquery-2.1.1.min.js"><\/script>');
    }</script>

<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script> if (!window.jQuery.ui) {
        document.write('<script src="js/libs/jquery-ui-1.10.3.min.js"><\/script>');
    }
</script>
<script src="library/general.js"></script>

<script type="text/javascript">

    $(document).ready(function () {
        $.ajax({
            url: "http://iremote.rania.com.my/process/test.php",
            type: "POST",
            dataType: "json",       
            crossDomain: true,
            async: false,
            data: {funct: 'activate_user', activation_code: 'ascac'},
            success: function (responseData, textStatus, jqXHR) {
                alert(responseData.result);
            },
            error: function () {
                alert('fail');
            }
        });
    });
    
</script>