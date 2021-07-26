BX.ready(function () {

    BX.bindDelegate(document, 'submit', {attribute: {'data-action': 'addItem'}}, function (ev) {
        ev.preventDefault();

        const form = this;
        const inputName = BX.findChild(form, {
            attribute: {
                name: 'name'
            }
        }, true);

        const inputUrl = BX.findChild(form, {
            attribute: {
                name: 'url'
            }
        }, true);

        // BX.showWait();

        BX.ajax.runComponentAction('ylab:profile.manager', 'process', {
            mode: 'class',
            data: {
                name: inputName.value,
                url: inputUrl.value
            },

        })
            .then(function(response) {
                if (response.status === 'success') {
                    alert("Данные записаны");
                }
            })
            .catch(function (response) {

                // BX.closeWait();
            });
    });

});

