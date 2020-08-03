define([
        'uiComponent',
        'jquery',
        'Magento_Ui/js/modal/modal',
        'mage/url'
    ],
    function (
        Component,
        $,
        modal,
        urlBuilder
    ) {
        'use strict';

        $(function () {

            let options = {
                type: 'popup',
                responsive: true,
                innerScroll: true,
                title: 'Quick Order',
                buttons: [{
                    text: $.mage.__('Close'),
                    class: '',
                    click: function () {
                        this.closeModal();
                    }
                }]
            };

            let popup = modal(options, $('#quick-order-form'));

            $(".quick-order-button").bind('click', function () {
                $("#quick-order-form").modal("openModal");
            });

            $("#sendInfo").click(function () {
                let name, phone, phoneIsNumber, email, sku;

                name = $("#customerName").val();
                phone = $("#customerPhone").val();
                phoneIsNumber = Number(phone);
                email = $("#customerEmail").val();
                sku = $("#product_addtocart_form").attr("data-product-sku");

                // if (typeof sku == "undefined") {
                //     sku = $("#popup-modal-info").attr("data-product-sku");
                // } else {

                if (
                    typeof (name) == "string" && name.length != 0 &&
                    Number.isInteger(phoneIsNumber) == true && phoneIsNumber != 0 && phone.length != 0 &&
                    correctEmail(email) == true && email.length != 0
                ) {

                    let data = {
                        'name': name,
                        'phone': phone,
                        'email': email,
                        'sku': sku
                    };

                    let url = urlBuilder.build('q_order/record/add');

                    $.ajax({
                        url: url,
                        data: data,
                        type: 'POST',
                        dataType: 'json'
                    }).done(function (response) {
                        console.log(response);
                        $("#errorMessage").hide();
                        $("#quick-order-form").modal("closeModal");
                        console.log(sku);
                        console.log(typeof (sku));
                    }).fail(function (error) {
                        console.log(JSON.stringify(error));
                    });
                } else {
                    $("#errorMessage").html("<span style= 'color: red'>" +
                        "Your data is not valid. Please, check the correct spelling</span>");
                }

                //}

                function correctEmail(email) {
                    let reg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    return reg.test(email);
                }
            });
        });
    }
);
