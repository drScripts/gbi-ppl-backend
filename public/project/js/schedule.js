$(function () {
    function readFileImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $("#card-banner-upload").attr(
                    "style",
                    `background-image:url('${e.target.result}');background-size:cover;background-repeat:no-repeat;`
                );
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    if ($("#schedule-table")) {
        $("#schedule-table").DataTable({
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: true,
            responsive: true,
        });
    }

    if ($("#banner")) {
        $("#banner").change(function () {
            readFileImage(this);
        });
    }
});
