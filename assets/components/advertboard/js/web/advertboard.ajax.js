(function () {

    const result = {

        init: function () {

            this.eventSubscription()

        },

        eventSubscription: function () {

            $(document).on('af_complete', $.proxy(this.eventAfComplete, this))
        },

        eventAfComplete: function (event, response) {
            if ('service' in response.data && response.data.service == 'advertboard') {
                this.cleanDOM(response)
                this.offLibraries(response)
                this.getService(response)
            }
        },

        cleanDOM: function (response) {

            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
            $('.alert').hide()

        },

        offLibraries: function (response) {

            response.message = '';

        },

        getService: function (response) {
            let modalID, imageBlocks, alertClass
            let alert = response.form.find('.alert')

            if ('modalID' in response.data) {
                modalID = response.data.modalID
            }
            if ('imageBlock' in response.data) {
                imageBlocks = $(response.data.imageBlock) // блоки где должен вставляться аватар
                if ('avatar' in response.data && imageBlocks.length > 0) {
                    imageBlocks.removeClass('modified').find('img').attr('src', response.data.avatar)
                }
            }

            if (response.data.result) {
                if ('location' in response.data) {
                    if (modalID){
                        if (response.data.editButtonID && response.data.redirectEdit) {
                            $('#' + response.data.editButtonID).attr('href', response.data.redirectEdit)
                        }
                        $('#' + modalID).on('hidden.bs.modal', function (e) {
                            window.location.href = response.data.location;
                        })
                    } else {
                        window.location = response.data.location
                    } 
                }
                alertClass = 'alert-success'
            } else {
                alertClass = 'alert-danger'
                $.each(response.data.errors, (i, msg) => {
                    response.form.find('[name="' + i + '"]')
                        .addClass('is-invalid').parent()
                        .append($('<span class="invalid-feedback">' + msg + '</span>'))
                    if (response.form.attr('id')) {
                        $('body').find('[form="' + response.form.attr('id') + '"][name="' + i + '"]')
                            .addClass('is-invalid').parent()
                            .append($('<span class="invalid-feedback">' + msg + '</span>'))
                    }
                })
            }
            if (modalID) {
                $('.modal').modal('hide')
                $('#' + modalID).modal('show')
            }
            if (alert.length > 0 && response.data.message) {
                alert.show().attr('class', alert.attr('class').replace(/\balert-\w*\b/g, '')).addClass(alertClass).text(response.data.message)
            }
        }
    }

    result.init()

})()