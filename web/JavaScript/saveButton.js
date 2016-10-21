document.addEventListener('DOMContentLoaded', function () {

    var greenButtons = document.querySelectorAll('.green');

    [...greenButtons].forEach(function (el) {
        el.addEventListener('click', function (event) {

            this.classList.remove("btn-default");
            this.classList.add("btn-success");

        });

    });
});

