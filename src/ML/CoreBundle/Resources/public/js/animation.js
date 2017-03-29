/**
 * Created by sMunkKK on 14/03/2017.
 */
$('.datepicker').datepicker({
    format: "dd-mm-yyyy",
    weekStart: 1,
    language: "fr",
    daysOfWeekDisabled: "0,2",
    daysOfWeekHighlighted: "0,2",
    autoclose: true,
    todayHighlight: true,
    datesDisabled: ['01/05/2017', '01/11/2017', '25/12/2017']
});