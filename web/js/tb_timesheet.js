var totalErrors = new Array(false, false, false, false, false, false, false);

/**
 * Recalcs the amount of hours of the given weekday
 *
 * @param weekday The day of the week (starting from 1 = monday)
 */
function recalcTotalHours(unique_id, field, weekday) {
    total = 0;

    var inputfields = $("input[class*=value_"+weekday+"]");

    for (i=0; i < inputfields.length; i++) {
        var time = inputfields[i];

        value = parseFloat(time.value);
        if (!isNaN(value)) {
            total += value;
        }
    }
    
    if (total > MAX_HOURS_PER_DAY) {
        totalErrors[weekday] = true;
    }
    else {
        totalErrors[weekday] = false;
    }
    
    if (hasNoTotalOverMaxErrors()) {
        $('#warn-total-over-max').hide();
        $('#form-submit-btn').removeAttr("disabled");

    }
    else {
        $('#warn-total-over-max').show();
        $('#form-submit-btn').attr("disabled", true);
    }

    $('#total-'+weekday).html($().number_format(total, {numberOfDecimals: 2, decimalSeparator: '.', thousandsSeparator: ','}));
    
    if (field != null) {
        $('#container_'+unique_id).html(field.value);
    }
    
}

function hasNoTotalOverMaxErrors() {
    
    for (i=0; i < 7; i++) {
        if (totalErrors[i] == true) {
            return false;
        }
    }
    
    return true;
}