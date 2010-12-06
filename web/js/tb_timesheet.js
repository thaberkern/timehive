/**
 * Recalcs the amount of hours of the given weekday
 *
 * @param weekday The day of the week (starting from 1 = monday)
 */
function recalcTotalHours(weekday) {
    total = 0;

    var inputfields = $("input[class*=value_"+weekday+"]");

    for (i=0; i < inputfields.length; i++) {
        var time = inputfields[i];

        value = parseFloat(time.value);
        if (!isNaN(value)) {
            total += value;
        }
    }

    $('#total-'+weekday).html($().number_format(total, {numberOfDecimals: 2, decimalSeparator: ':', thousandsSeparator: ','}));
}