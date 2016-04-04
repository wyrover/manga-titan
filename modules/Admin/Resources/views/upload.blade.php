<script>
	$.ajax({
    xhr: function() {
        var xhr = jQuery.ajaxSettings.xhr();
        if(xhr instanceof window.XMLHttpRequest) {
            xhr.upload.addEventListener('progress', on_progress, false);
            xhr.upload.addEventListener('load', on_loaded, false);
            xhr.addEventListener('abort', on_abort, false);
        }
        return xhr;
    }
});
</script>