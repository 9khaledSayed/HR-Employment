$(function (){
    let violation_select = $("select[name=violation_id]");
    let minutesLate = $("#minutes_late");
    let absenceDays = $("#absence_days");
    let arrows;

    $('.kt-selectpicker').selectpicker();
    if (KTUtil.isRTL()) {
        arrows = {
            leftArrow: '<i class="la la-angle-right"></i>',
            rightArrow: '<i class="la la-angle-left"></i>'
        }
    } else {
        arrows = {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    }
    // enable clear button
    $('.datepicker').datepicker({
        rtl: KTUtil.isRTL(),
        todayBtn: "linked",
        format:'yyyy-mm-dd',
        clearBtn: true,
        todayHighlight: true,
        templates: arrows
    });



    getType(violation_select.val());
    violation_select.change(function (){
        let violation_id = violation_select.val();
        getType(violation_id);
    });

    function getType(violation_id) {
        if(violation_select.val() != null && violation_select.val() !== ''){
            $.ajax({
                url: '/dashboard/violations/' + violation_id + '/additions',
                success: function (data){
                    switch (data.additions){
                        case 'minutes_deduc': // lateness
                            minutesLate.fadeIn();
                            absenceDays.fadeOut();
                            break;
                        case 'leave_days': // leave work
                            absenceDays.fadeIn();
                            minutesLate.fadeOut();
                            break;
                        default :
                            absenceDays.fadeOut();
                            minutesLate.fadeOut();
                            break;
                    }
                },
            });

        }
    }
});
