document.addEventListener('turbo:load', loadDoctorAppointmentFilterDate)

let doctorAppointmentFilterDate = '#doctorPanelAppointmentDate';

function loadDoctorAppointmentFilterDate () {
    if (!$(doctorAppointmentFilterDate).length) {
        return
    }
    let timeRange = $('#doctorPanelAppointmentDate');
    let doctorAppointmentStart = moment().startOf('week')
    let doctorAppointmentEnd = moment().endOf('week')

    function cb(doctorAppointmentStart, doctorAppointmentEnd) {
        $('#doctorPanelAppointmentDate').val(
            doctorAppointmentStart.format('MM/DD/YYYY') + ' - ' + doctorAppointmentEnd.format('MM/DD/YYYY'))
    }

    timeRange.daterangepicker({
        startDate: doctorAppointmentStart,
        endDate: doctorAppointmentEnd,
        opens: 'left',
        showDropdowns: true,
        locale: {
            customRangeLabel: Lang.get('js.custom'),
            applyLabel:Lang.get('js.apply'),
            cancelLabel: Lang.get('js.cancel'),
            fromLabel:Lang.get('js.from'),
            toLabel: Lang.get('js.to'),
            monthNames: [
                Lang.get('js.jan'),
                Lang.get('js.feb'),
                Lang.get('js.mar'),
                Lang.get('js.apr'),
                Lang.get('js.may'),
                Lang.get('js.jun'),
                Lang.get('js.jul'),
                Lang.get('js.aug'),
                Lang.get('js.sep'),
                Lang.get('js.oct'),
                Lang.get('js.nov'),
                Lang.get('js.dec')
            ],

            daysOfWeek: [
                Lang.get('js.sun'),
                Lang.get('js.mon'),
                Lang.get('js.tue'),
                Lang.get('js.wed'),
                Lang.get('js.thu'),
                Lang.get('js.fri'),
                Lang.get('js.sat')],
        },
        ranges: {
            [Lang.get('js.today')]: [moment(), moment()],
            [Lang.get('js.yesterday')]: [
                moment().subtract(1, 'days'),
                moment().subtract(1, 'days')],
            [Lang.get('js.this_week')]: [moment().startOf('week'), moment().endOf('week')],
            [Lang.get('js.last_30_days')]: [moment().subtract(29, 'days'), moment()],
            [Lang.get('js.this_month')]: [moment().startOf('month'), moment().endOf('month')],
            [Lang.get('js.last_month')]: [
                moment().subtract(1, 'month').startOf('month'),
                moment().subtract(1, 'month').endOf('month')],
        },
    }, cb);

    cb(doctorAppointmentStart, doctorAppointmentEnd)

    timeRange.on("apply.daterangepicker", function (ev, picker) {
        window.livewire.emit('changeDateFilter', $(this).val())
    });
}

listenChange('.doctor-appointment-status-change', function () {
    let doctorAppointmentStatus = $(this).val()
    let doctorAppointmentId = $(this).attr('data-id')
    let doctorAppointmentCurrentData = $(this)

    $.ajax({
        url: route('doctors.change-status', doctorAppointmentId),
        type: 'POST',
        data: {
            appointmentId: doctorAppointmentId,
            appointmentStatus: doctorAppointmentStatus,
        },
        success: function (result) {
            $(doctorAppointmentCurrentData).
                children('option.booked').
                addClass('hide')
            livewire.emit('refresh')
            displaySuccessMessage(result.message)
        },
    })
})

listenChange('.doctor-apptment-change-payment-status', function () {
    let doctorApptmentPaymentStatus = $(this).val()
    let doctorApptmentAppointmentId = $(this).attr('data-id')

    $('#doctorAppointmentPaymentStatusModal').modal('show').appendTo('body')

    $('#doctorAppointmentPaymentStatus').val(doctorApptmentPaymentStatus)
    $('#doctorAppointmentId').val(doctorApptmentAppointmentId)
})

listenSubmit('#doctorAppointmentPaymentStatusForm', function (event) {
    event.preventDefault()
    let paymentStatus = $('#doctorAppointmentPaymentStatus').val()
    let appointmentId = $('#doctorAppointmentId').val()
    let paymentMethod = $('#doctorPaymentType').val()

    $.ajax({
        url: route('doctors.change-payment-status', appointmentId),
        type: 'POST',
        data: {
            appointmentId: appointmentId,
            paymentStatus: paymentStatus,
            paymentMethod: paymentMethod,
            loginUserId: currentLoginUserId,
        },
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                $('#doctorAppointmentPaymentStatusModal').modal('hide')
                location.reload()
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
        },
    })
})


listenChange('#doctorPanelPaymentType', function () {
    window.livewire.emit('changeDateFilter',
        $('#doctorPanelAppointmentDate').val())
    window.livewire.emit('changePaymentTypeFilter', $(this).val())
})

listenChange('#doctorPanelAppointmentStatus', function () {
    window.livewire.emit('changeDateFilter', $('#doctorPanelAppointmentDate').val())
    window.livewire.emit('changeStatusFilter', $(this).val())
})

listenClick('#doctorPanelApptmentResetFilter', function () {
    $('#doctorPanelPaymentType').val(0).trigger('change')
    $('#doctorPanelAppointmentStatus').val(1).trigger('change')
    doctorAppointmentFilterDate.data('daterangepicker').
        setStartDate(moment().startOf('week').format('MM/DD/YYYY'))
    doctorAppointmentFilterDate.data('daterangepicker').
        setEndDate(moment().endOf('week').format('MM/DD/YYYY'))
    hideDropdownManually($('#doctorPanelApptFilterBtn'), $('.dropdown-menu'));
})

listenClick('#doctorPanelApptResetFilter', function () {
    $('#doctorPanelPaymentType').val(0).trigger('change')
    $('#doctorPanelAppointmentStatus').val(1).trigger('change')
    $('#doctorPanelAppointmentDate').data('daterangepicker').
        setStartDate(moment().startOf('week').format('MM/DD/YYYY'))
    $('#doctorPanelAppointmentDate').data('daterangepicker').
        setEndDate(moment().endOf('week').format('MM/DD/YYYY'))
    hideDropdownManually($('#doctorPanelApptFilterBtn'), $('.dropdown-menu'));
})

document.addEventListener('livewire:load', function () {
    window.livewire.hook('message.processed', () => {
        if ($('#doctorPanelPaymentType').length) {
            $('#doctorPanelPaymentType').select2()
        }
        if ($('#doctorPanelAppointmentStatus').length) {
            $('#doctorPanelAppointmentStatus').select2()
        }
        if ($('.appointment-status').length) {
            $('.appointment-status').select2()
        }
        if ($('.payment-status').length) {
            $('.payment-status').select2()
        }
    })
})
