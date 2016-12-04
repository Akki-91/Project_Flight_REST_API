$(document).ready(function() {

        $('.green').on('click', function () {

            $(this).removeClass("btn-default").addClass("btn-success");

            var destination = $(this).closest('tr').data('destination');
            var fromLocation = $(this).closest('tr').data('from-location');
            var currency = $(this).closest('tr').data('currency');
            var price = $(this).closest('tr').data('price');
            var href = $(this).closest('tr').data('href');

            $.ajax({
                url: '/saveFlight',
                data: {
                    'destination': destination,
                    'fromLocation': fromLocation,
                    'currency': currency,
                    'price': price,
                    'href': href
                },
                type: 'POST',
                dataType: 'json'
            })
                .done( function (ans) {

                });

        });


        $('.delete').on('click', function () {

            var id = $(this).closest('tr').data('id');

            $.ajax({
                url: '/deleteFlight',
                data: {
                    'id': id
                },
                type: 'POST',
                dataType: 'json'
            })
                .done( function (ans) {
                    $('[data-id="'+ ans.id + '"]').fadeOut()
                });
        });

});


