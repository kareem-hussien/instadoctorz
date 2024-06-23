document.addEventListener('turbo:load', loadTransactionFilterDate)

function loadTransactionFilterDate () {
    if (!$('#transactionDateFilter').length) {
        return
    }

    let appointmentStart = moment().startOf('week')
    let appointmentEnd = moment().endOf('week')

    function cb (start, end) {
        $('#transactionDateFilter').val(
            start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'))
    }

  let transactionDatePicker =  $('#transactionDateFilter').daterangepicker({
        startDate: appointmentStart,
        endDate: appointmentEnd,
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
    }, cb)

    cb(appointmentStart, appointmentEnd)


    transactionDatePicker.on("apply.daterangepicker", function (ev, picker) {
        window.livewire.emit('changeDateFilter', $(this).val())
    });

    window.addEventListener('update-item', event => {
        let array = event.detail.data;
        $('#transactionDoctor').empty();
        $('#transactionDoctor').append($('<option value=""></option>').text( Lang.get('js.select_doctor')));
        $.each(array, function (key, value) {
            $('#transactionDoctor').append($('<option></option>').attr('value', key).text(value));

        });
    })
}



listenChange('#trPaymentMehtod',function(){
    window.livewire.emit('paymentFilter',$(this).val());
});

listenChange('#transactionStatus',function(){
    window.livewire.emit('statusFilter',$(this).val());
});

listenChange('#transactionDoctor',function(){
    window.livewire.emit('doctorFilter',$(this).val());
});

listenChange('#transactionServices',function(){
    window.livewire.emit('serviceFilter',$(this).val());

});

listenClick('#transactionResetFilter', function () {
    $('#trPaymentMehtod').val('').trigger('change')
    $('#transactionStatus').val('').trigger('change')
    $('#transactionDoctor,#transactionServices').val('').trigger('change')
    hideDropdownManually($('#transactionFilterBtn'), $('.dropdown-menu'));
})
