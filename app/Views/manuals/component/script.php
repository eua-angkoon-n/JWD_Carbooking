<script type="text/javascript">
        $(document).off("click", ".modal-img").on("click", ".modal-img", function (e) {
            var img = $(this).data('id');
            $('#modalImg').attr('src', img);
        });
</script>