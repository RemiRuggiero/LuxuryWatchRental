// Gestion transition image du carousel
$('.carousel').carousel({
    interval: 6200
})

// Calendrier DateRangePicker
$(function () {

    var date = new Date();
    var currentMonth = date.getMonth();
    var currentDate = date.getDate();
    var currentYear = date.getFullYear();

    var btn = document.getElementById('btn');
    var daterange = document.getElementById('daterange');

    var disabledDate = document.getElementById('catchDate').value;
    var disabledDate = JSON.parse(disabledDate);
    // console.log(disabledDate[0]);

    daterange.addEventListener('click', function (e) {
        e.preventDefault;
        console.log(daterange.value);
    })


    $('input[name="daterange"]').daterangepicker({
        opens: 'right',
        minDate: new Date(currentYear, currentMonth, currentDate + 3),
        isInvalidDate: function (date) {
            if (disabledDate.length == 0) {
                true
            } else {
                var disabled_start = moment(disabledDate[0].date).add(-1, 'day');
                var disabled_end = moment(disabledDate[disabledDate.length - 1].date).add(1, 'day');
                return date.isAfter(disabled_start) && date.isBefore(disabled_end);
            }

        }

    }, function (start, end, label) {
        console.log("A new date selection was made: " + start.format('dd/MMMM/y') + ' to ' + end.format('dd/MMMM/y'));
    });
});