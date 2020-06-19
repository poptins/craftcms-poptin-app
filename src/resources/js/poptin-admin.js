jQuery(document).ready(function ($) {
    jQuery(".where-is-my-id-inside-lb").bind('click',function(e){
        $('#oopsiewrongid').modal('hide');
        $('#whereIsMyId').modal();
    });

    function show_loader() {
        $(".poptin-overlay").fadeIn(500);
    }

    function hide_loader() {
        $(".poptin-overlay").fadeOut(500);
    }

    jQuery(".pp_signup_btn").on('click', function (e) {
        e.preventDefault();
        console.log("Sign Up Was Clicked!");

        var email = $("#email").val();
        console.log(email);

        if(!isEmail(email)){
            $("#oopsiewrongemailid").modal('show');
            return false;
        }

        show_loader();
        jQuery.ajax({
            url: window.poptin.config.poptin_url + '/api/marketplace/register',
            dataType: "JSON",
            method: "POST",
            data: jQuery("#registration_form").serialize(),
            success: function (data) {
                console.log(data);
                if (data.success == true) {
                    $("[name='client_id']").val(data.client_id);
                    $("[name='user_id']").val(data.user_id);
                    $("[name='token']").val(data.token);
                    $("[name='login_url']").val(data.login_url);

                    // Updating config in database
                    jQuery.ajax({
                        url: '/poptin/config',
                        dataType: "JSON",
                        method: "POST",
                        data: jQuery("#poptinConfigForm").serialize(),
                        success: function (data) {
                            hide_loader();
                        }
                    });

                    jQuery(".ppaccountmanager").fadeOut(300);
                    jQuery(".poptinLogged").fadeIn(300);
                    jQuery(".poptinLoggedBg").fadeIn(300);
                } else {
                    if(data.message === "Registration failed. User already registered.") {
                        jQuery("#lookfamiliar").modal();
                    } else if(data.message = "The email has already been taken.") {
                        jQuery("#lookfamiliar").modal();
                    } else {
                        swal("Error", data.message, "error");
                    }

                    hide_loader();
                }
            }
        });
    });

    jQuery('.goto_dashboard_button_pp_updatable').click(function(){
        link = $(this);
        href = link.attr('href');
        setTimeout(function(){
            link.attr('href',href.replace('&after_registration=craftcms',''));
        },1000);
    });

    jQuery(document).on('click','.deactivate-poptin-confirm-yes',function(){
        $("[name='client_id']").val('');
        $("[name='user_id']").val('');
        $("[name='token']").val('');
        $("[name='login_url']").val('');

        window.poptin.methods.updateCraftConfig();

        jQuery('#makingsure').modal('hide');
        jQuery('#byebyeModal').modal('show');
        $(".poptinLogged").hide();
        $(".poptinLoggedBg").hide();
        $(".ppaccountmanager").fadeIn('slow');
        $(".popotinLogin").show();
        $(".popotinRegister").hide();
    });

    jQuery(".pplogout").click(function (e) {
        e.preventDefault();
        jQuery('#makingsure').modal('show');
    });

    $(".ppLogin").click(function (e) {
        e.preventDefault();
        $(".popotinLogin").fadeIn('slow');
        $(".popotinRegister").hide();
    });

    $(".ppRegister").click(function (e) {
        e.preventDefault();
        $(".popotinRegister").fadeIn('slow');
        $(".popotinLogin").hide();
    });

    $('.ppFormLogin').on('submit', function (e) {
        e.preventDefault();
        var id = $('.ppFormLogin input[type="text"]').val();
        console.log(id);
        if (id.length != 13) {
            e.preventDefault();
            $("#oopsiewrongid").modal('show');
            return false;
        }

        $("[name='client_id']").val(id);
        $("[name='user_id']").val();
        $("[name='token']").val('');
        $("[name='login_url']").val('');

        window.poptin.methods.updateCraftConfig();

        jQuery(".poptinLogged").fadeIn('slow');
        jQuery(".poptinLoggedBg").fadeIn('slow');
        jQuery(".ppaccountmanager").hide();
        jQuery(".popotinLogin").hide();
        jQuery(".popotinRegister").hide();
        $(".goto_dashboard_button_pp_updatable").attr('href', window.poptin.config.poptin_url);
    });


});


function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}