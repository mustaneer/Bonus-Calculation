jQuery(function ($) {
	$('#deposit_amount').maskMoney({prefix:'£',affixesStay: true, precision: 0});
	$('#deposit_amount').trigger('mask.maskMoney');
	
	$('#deposit_amount_years').maskMoney({suffix:' years',affixesStay: true, thousands:'', precision: 0});
	//$('#deposit_amount_years').focus();
	
	if($('.main-bonus-wrapper').length > 0){
		var deposit_amount = 45000;
        var deposit_amount_years = 5;
        var data = {
			'action' : 'bonus_calculation_request',
			'deposit_amount' : deposit_amount,
			'deposit_amount_years' : deposit_amount_years,
		}
		$.ajax({
			url:     admin_url.ajaxurl,
			type:    "POST",
			data:    data,
			success: function( response ) {
				if(response.success){
					var interest_main_accout_split 	= response.data.interest_main_account.split(" ");
					var otheraccountamount_split 	= response.data.otheraccountamount.split(" ");
					var other_account_weekly_deposit = response.data.other_account_weekly_deposit;
					$('.weekly_deposit .amount').html(response.data.weekly_deposit);
					$('.total_bonus .amount').html(response.data.govt_bonus);
					$('.popup_weekly_deposit .w_deposit').html(response.data.weekly_deposit);
					$('.popup_govt_bonus .g_y_bonus').html(response.data.govt_bonus);
					$('.popup_govt_bonus .gov-bonus-subtitle').html(response.data.government_bonus_subtitle);
					$('.popup_interest .interest_subtitle').html(response.data.interest_main_account);
					$('.popup_interest .interest_amount').html(interest_main_accout_split[0]);
					$('.other_popup_interest .other_interest_subtitle').html(response.data.otheraccountamount);
					$('.other_popup_interest .right').html(otheraccountamount_split[0]);
					$('.total_bonus_amount .total_years').html(response.data.years);
					$('.total_bonus_amount .total_amount').html(response.data.final_balance);
					if(other_account_weekly_deposit > 0){
						$('.additional_weekly_deposit .amount').html(other_account_weekly_deposit); 
						$('.additional_result #additional_rate').html(response.data.other_account_interest_rate_used+"%"); 
						$('.the_results .divider').css('display','flex');
						$('.result_wrapper .additional_result').css('display','block');							
					} else {
						$('.the_results .divider').css('display','none');
						$('.result_wrapper .additional_result').css('display','none');	
					}
				} 
			}
		})
	}

	jQuery('#deposit_amount').on('keyup', function(e) {
		$(".dep_errmsg").html("").hide();
		var max = 6;
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
	        //display error message
	        $(".errmsg").html("Digits Only").show().fadeOut(3000);
	        return false;
	    } else{
	        var input_val = $(this).val();
	        input_val = input_val.replace("£", "");
	        input_val = input_val.replace(/,/g , '');
	        if(input_val < 5000 || input_val > 100000 ){
		        $(".dep_errmsg").html("Please input a value between £5,000 and £100,000").show();
		        if(input_val.length > 6) {
			        $(".dep_errmsg").html("Please input a value between £5,000 and £100,000").show();
			        $("#deposit_amount").val(input_val.substring(0, 6)).trigger('mask.maskMoney');
					//$('#deposit_amount').maskMoney({prefix:'£',affixesStay: true, precision: 0});
					//$('#deposit_amount').focus();
		        }
		        return false;
	        } else if(input_val >= 5000 || input_val >= 100000){
				//$('#deposit_amount').val(input_val);
				
				$('.deposit_range_slider').val(input_val).change();
	        } 
	          
	    }
    });

    jQuery('.deposit_range_slider').rangeslider({
        polyfill: false,
        // Default CSS classes
        rangeClass: 'rangeslider',
        disabledClass: 'rangeslider--disabled',
        horizontalClass: 'rangeslider--horizontal',
        verticalClass: 'rangeslider--vertical',
        fillClass: 'rangeslider__fill',
        handleClass: 'rangeslider__handle',

        // Callback function
        onInit: function () {
        },
        // Callback function
        onSlide: function (position, value) {
            $("#deposit_amount").val(value).trigger('mask.maskMoney');
  
            var deposit_amount_years = $('#deposit_amount_years').val();
            var data = {
				'action' : 'bonus_calculation_request',
				'deposit_amount' : value,
				'deposit_amount_years' : deposit_amount_years,
			}
			gtag('config', 'UA-180549761-1', {
			  'page_title' : 'Your custom title',
			  'page_path': '/your-own-path'
			})
			$.ajax({
				url:     admin_url.ajaxurl,
				type:    "POST",
				data:    data,
				success: function( response ) {
					if(response.success){
						var interest_main_accout_split 	= response.data.interest_main_account.split(" ");
						var otheraccountamount_split 	= response.data.otheraccountamount.split(" ");
						var other_account_weekly_deposit = response.data.other_account_weekly_deposit;
						$('.weekly_deposit .amount').html(response.data.weekly_deposit);
						$('.total_bonus .amount').html(response.data.govt_bonus);
						$('.popup_weekly_deposit .w_deposit').html(response.data.weekly_deposit);
						$('.popup_govt_bonus .g_y_bonus').html(response.data.govt_bonus);
						$('.popup_govt_bonus .gov-bonus-subtitle').html(response.data.government_bonus_subtitle);
						$('.popup_interest .interest_subtitle').html(response.data.interest_main_account);
						$('.popup_interest .interest_amount').html(interest_main_accout_split[0]);
						$('.other_popup_interest .other_interest_subtitle').html(response.data.otheraccountamount);
						$('.other_popup_interest .right').html(otheraccountamount_split[0]);
						$('.total_bonus_amount .total_years').html(response.data.years);
						$('.total_bonus_amount .total_amount').html(response.data.final_balance);
						if(other_account_weekly_deposit > 0){
							$('.additional_weekly_deposit .amount').html(other_account_weekly_deposit); 
							$('.additional_result #additional_rate').html(response.data.other_account_interest_rate_used+"%");  
							$('.the_results .divider').css('display','flex');
							$('.result_wrapper .additional_result').css('display','block');							
						} else {
							$('.the_results .divider').css('display','none');
							$('.result_wrapper .additional_result').css('display','none');	
						}
					} 
				}
			})
        },

        // Callback function
        onSlideEnd: function () {
        }
    });
    
	jQuery('#deposit_amount_years').on('keyup', function(e) {
		$(".year_errmsg").html("").hide();
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
	        //display error message
	        $(".year_errmsg").html("Digits Only").show().fadeOut(3000);
	        return false;
	    } else{
	        var input_val = $(this).val();
	        input_val = input_val.replace(" years", "");
	        if(input_val < 1 || input_val > 20){
		        $(".year_errmsg").html("Please input a value between 1 and 20 years").show();
		        return false;
	        } else if(input_val >= 1 || input_val >= 20){
				$('#deposit_amount_years').val(input_val).trigger('mask.maskMoney');
				$('.deposit_year_slider').val(input_val).change();
	        } 
	          
	    }
    });
    jQuery('.deposit_year_slider').rangeslider({
        polyfill: false,
        // Default CSS classes
        rangeClass: 'rangeslider',
        disabledClass: 'rangeslider--disabled',
        horizontalClass: 'rangeslider--horizontal',
        verticalClass: 'rangeslider--vertical',
        fillClass: 'rangeslider__fill',
        handleClass: 'rangeslider__handle',
        // Callback function
        onInit: function () {
        },
        // Callback function
        onSlide: function (position, value) {
            $('#deposit_amount_years').val(value).trigger('mask.maskMoney');
            //$('#deposit_amount_years').maskMoney({suffix:' years',affixesStay: true, thousands:'', precision: 0});
			//$('#deposit_amount_years').focus();
            var deposit_amount_years = value;
            var deposit_amount = $('#deposit_amount').val();
            $('.d_year').html(value);
            var data = {
				'action' : 'bonus_calculation_request',
				'deposit_amount' : deposit_amount,
				'deposit_amount_years' : deposit_amount_years,
			}
			$.ajax({
				url:     admin_url.ajaxurl,
				type:    "POST",
				data:    data,
				success: function( response ) {

					if(response.success){
						var interest_main_accout_split 	= response.data.interest_main_account.split(" ");
						var otheraccountamount_split 	= response.data.otheraccountamount.split(" ");
						var other_account_weekly_deposit = response.data.other_account_weekly_deposit;
						$('.weekly_deposit .amount').html(response.data.weekly_deposit);
						$('.total_bonus .amount').html(response.data.govt_bonus);
						$('.popup_weekly_deposit .w_deposit').html(response.data.weekly_deposit);
						$('.popup_govt_bonus .g_y_bonus').html(response.data.govt_bonus);
						$('.popup_govt_bonus .gov-bonus-subtitle').html(response.data.government_bonus_subtitle);
						$('.popup_interest .interest_subtitle').html(response.data.interest_main_account);
						$('.popup_interest .interest_amount').html(interest_main_accout_split[0]);
						$('.other_popup_interest .other_interest_subtitle').html(response.data.otheraccountamount);
						$('.other_popup_interest .right').html(otheraccountamount_split[0]);
						$('.total_bonus_amount .total_years').html(response.data.years);
						$('.total_bonus_amount .total_amount').html(response.data.final_balance);
						if(other_account_weekly_deposit > 0){
							$('.additional_weekly_deposit .amount').html(other_account_weekly_deposit); 
							$('.additional_result #additional_rate').html(response.data.other_account_interest_rate_used+"%"); 
							$('.the_results .divider').css('display','flex');
							$('.result_wrapper .additional_result').css('display','block');							
						} else {
							$('.the_results .divider').css('display','none');
							$('.result_wrapper .additional_result').css('display','none');	
						}
					}
				}
			})
        },
        // Callback function
        onSlideEnd: function () {
        }
    });

    $('#deposit_help_popup').on('click',function(){
	    Swal.fire({
		  title: '<strong>'+admin_url.deposit_help_title+'</strong>',
		    showClass: {
			    popup: '',
			    icon: ''
		  	},
		  	hideClass: {
		    	popup: 'swal2-hide',
		  	},
		  	width: 486,
		  	html: admin_url.deposit_help_text,
		  	showCloseButton: true,
		  	focusConfirm: false,
		  	confirmButtonText:'OK, got it!',
		  	confirmButtonAriaLabel: 'OK, got it!',

		})
    });

    $('#deposit_year_popup').on('click',function(){
	    Swal.fire({
		  title: '<strong>'+admin_url.not_sure_title+'</strong>',
		    showClass: {
			    popup: '',
			    icon: ''
		  	},
		  	hideClass: {
		    	popup: 'swal2-hide',
		  	},
		  width: 486,
		  html: admin_url.not_sure,
		  showCloseButton: true,
		  focusConfirm: false,
		  confirmButtonText:'OK, got it!',
		  confirmButtonAriaLabel: 'OK, got it!',

		})
    });


$('#additional_popup').on('click',function(){
	    Swal.fire({
		  title: '<strong>'+admin_url.additional_tooltip+'</strong>',
		    showClass: {
			    popup: '',
			    icon: ''
		  	},
		  	hideClass: {
		    	popup: 'swal2-hide',
		  	},
		  width: 486,
		  html: admin_url.additional_tooltip_content,
		  showCloseButton: true,
		  focusConfirm: false,
		  confirmButtonText:'OK, got it!',
		  confirmButtonAriaLabel: 'OK, got it!',

		})
	});


    $('#view_breakdown').on('click',function(){
	    var deposit_amount = $('#deposit_amount').val();
	    var deposit_amount_years = $('#deposit_amount_years').val();
	    var popup_content = $('.breakdown_popup_content').html();
	    Swal.fire({

		  title: '<p> Your Target </p><h3>'+deposit_amount+' </h3> <hr />',

		  customClass: {
			container: 'breakdown',

		  },
		  showClass: {
			    popup: '',
			    icon: ''
		  	},
		  	hideClass: {
		    	popup: 'swal2-hide',
		  	},
		  width: 486,
		  html: popup_content,
		  showCloseButton: true,
		  focusConfirm: false,
		  confirmButtonText:'OK, got it!',
		  confirmButtonAriaLabel: 'OK, got it!',

		})
    });

    function addCommas(nStr) {
	    nStr += '';
	    x = nStr.split('.');
	    x1 = x[0];
	    x2 = x.length > 1 ? '.' + x[1] : '';
	    var rgx = /(\d+)(\d{3})/;
	    while (rgx.test(x1)) {
	            x1 = x1.replace(rgx, '$1' + ',' + '$2');
	    }
	    return x1 + x2;
	}
});
