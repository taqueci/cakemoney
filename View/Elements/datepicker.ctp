$(function() {
    $('<?php echo $id; ?>').datepicker({
		format: "yyyy-mm-dd",
		todayBtn: "linked",
		autoclose: true,
		todayHighlight: true
    });
});
