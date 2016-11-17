/**
 * File: contact-form.js.
 *
 * Validates and submits the contact-form using Foundation's Abide.js.
 */
!function ($) {

    "use strict";

    $("#contactForm")
        .on("forminvalid.zf.abide", function (e) {
            e.preventDefault();
            // handle the invalid form...
            formError();
            submitMSG(false, "Please supply all information.");
        })

        .on("valid", function (e) {
            e.preventDefault();

            // Initiate Variables With Form Content
            var name    = $("#name").val();
            var email   = $("#email").val();
            var message = $("#message").val();
            mailto = typeof mailto === "undefined" ? '' : mailto;

            $.ajax({
                type: "POST",
                dataType: "text",
                url: ajax_contactform.ajaxurl,
                data: {
                    action: "chamber_contact_form",
                    mailto: mailto[0]+'@'+mailto[1],
                    name: name,
                    email: email,
                    message: message,
                    contact_nonce: ajax_contactform.contact_nonce
                },
                success : function(text) {
                    if (text == "success") {
                        formSuccess();
                        submitMSG(true, text);
                    } else {
                        formError();
                        submitMSG(false, text);
                    }
                },
                completed : function(text) {
                    submitMSG(true, text + ' is complete, m\'man!');
                }
            });
        })

        .on("submit", function (e) {
            e.preventDefault();

            // Initiate Variables With Form Content
            var name    = $("#name").val();
            var email   = $("#email").val();
            var message = $("#message").val();
            mailto = typeof mailto === "undefined" ? '' : mailto[0]+'@'+mailto[1];

            $.ajax({
                type: "POST",
                dataType: "text",
                url: ajax_contactform.ajaxurl,
                data: {
                    action: "chamber_contact_form",
                    mailto: mailto,
                    name: name,
                    email: email,
                    message: message,
                    contact_nonce: ajax_contactform.contact_nonce
                },
                success : function(text) {
                    if (text == "success") {
                        formSuccess();
                        submitMSG(true, text);
                    } else {
                        formError();
                        submitMSG(false, text);
                    }
                },
                completed : function(text) {
                    submitMSG(true, text + ' is complet, m\'man!');
                }
            });
        })


    function formSuccess() {
        $("#contactForm")[0].reset();
        submitMSG(true, "Message Submitted!");
    }

    function formError(){
        $("#contactForm").removeClass().addClass('flash animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
            $(this).removeClass();
        });
    }

    function submitMSG(valid, msg) {
        if(valid){
            var msgClasses = "success callout pulsate";
        } else {
            var msgClasses = "alert callout";
        }
        $("#msgSubmit").removeClass().addClass(msgClasses).css('display', 'block');
        $("#msgSubmitText").text(msg);
    }

}(jQuery);

//# sourceMappingURL=contact-form.js.map
