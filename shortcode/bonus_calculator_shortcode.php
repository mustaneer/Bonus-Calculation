<?php
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }
    $main_title						= (get_field('main_title','option') != "") ? get_field('main_title','option') : "Calculate my government bonus" ;
    $main_sub_title					= (get_field('main_sub_title','option') != "") ? get_field('main_sub_title','option') : "See how you can boost your first home savings with a Moneybox Lifetime ISA." ;
    $deposit_amount_string 			= (get_field('deposit_amount_string','option') != "") ? get_field('deposit_amount_string','option') : "How much you are aiming to save for a deposit." ;
    $deposit_years_string 			= (get_field('deposit_years_string','option') != "") ? get_field('deposit_years_string','option') : "When do you hope to have your deposit by?" ;
    $government_policy 				= (get_field('government_policy','option') != "") ? get_field('government_policy','option') : "Govt. withdrawal charge may apply. Remember, interest rates may change so projections are not a guarantee of future value." ;
    $let_make_string				= (get_field('let_make_string','option') != "") ? get_field('let_make_string','option') : "Let’s make this happen" ;
    $setup_string					= (get_field('setup_string','option') != "") ? get_field('setup_string','option') : "Set up a weekly deposit of" ;
    $moneybox_lifetime_string		= (get_field('moneybox_lifetime_string','option') != "") ? get_field('moneybox_lifetime_string','option') : "into a Moneybox Lifetime ISA Account" ;
    $total_govt_bonus				= (get_field('total_govt_bonus','option') != "") ? get_field('total_govt_bonus','option') : "Total government bonus you will receive" ;
    $additional_string		        = (get_field('additional_setup_string','option') != "") ? get_field('additional_setup_string','option') : "an additional weekly deposit of" ;
    $additional_sub_string		    = (get_field('additional_lifetime_string','option') != "") ? get_field('additional_lifetime_string','option') : "into another Moneybox account. Calculated at a x.x% interest rate" ;


?>
<section class="main-bonus-wrapper" >
		<div class="top_header">
			<h1 class="main_title" ><?php echo __($main_title,"calculate_bonus"); ?> </h1>
		    <p class="main_title_sub" ><?php echo __($main_sub_title,"calculate_bonus"); ?> </p>
		</div>
        <div class="grid gov-bonus-cal-wrapper" >
            <div class="col-md-6 col-sm-12 colum-left">
                <div class="calculator_wrapper">
                    <div class="input_warpper">
                        <div class="deposit_wrapper">
                            <p>
                                <label><?php echo __($deposit_amount_string,"calculate_bonus"); ?></label>
                                <span class="pseudo-element input-symbol-euro">
                                	<input type="text" name="deposit_amount" id="deposit_amount" value="£45,000"  />
                                	<span class="dep_errmsg"></span>
                                </span>
                            </p>

	                        <input type="range" min="5000" max="100000" step="5000" value="45000" class="deposit_range_slider"   />

                            <p>
                                <input type="button" value="Help me with this" name="deposit_help" id="deposit_help_popup" />
                            </p>
                        </div>
                        <hr />
                        <div class="year_wrapper">
                            <p>
                                <label><?php echo __($deposit_years_string,"calculate_bonus"); ?></label>
                                 <span class="pseudo-element input-years-text">
                                 	<input type="text" name="deposit_amount_years" id="deposit_amount_years" value="5 years"  /> 
                                 	<span class="year_errmsg"></span>
                                 </span>
                            </p>
                            <input type="range" min="1" max="20" step="1" value="5" class="deposit_year_slider" data-rangeslider />
                            <p>
                                <input type="button" value="Not sure" name="deposit_help" id="deposit_year_popup" />
                            </p>
                        </div>
                    </div>
                    <div class="govt_policy desktop_view">
                        <p> <?php echo __($government_policy,"calculate_bonus"); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 colum-right">
                <div class="calculator_wrapper">
                    <div class="result_wrapper">
                         <h2><?php echo __($let_make_string,"calculate_bonus"); ?></h2>
                    <div class="the_results">
                        <div class="result">
                         <p class="small_desc"> <?php echo __($setup_string,"calculate_bonus"); ?>  </p>
                        <h2 class="weekly_deposit">
	                        <span class="currency"><?php  echo __("£","calculate_bonus"); ?></span>
	                        <span class="amount"><?php echo __("--,--","calculate_bonus"); ?></span>
	                    </h2>
                        <p class="desc_result"> <?php echo __($moneybox_lifetime_string,"calculate_bonus"); ?></p>
                        </div>

<div class="divider"></div>

<div class="additional_result">
<p class="small_desc"><?php echo __($additional_string,"calculate_bonus"); ?></p>

<h2 class="additional_weekly_deposit">
<span class="currency"><?php  echo __("£","calculate_bonus"); ?></span>
<span class="amount"><?php echo __("--,--","calculate_bonus"); ?></span> <span id="additional_popup" class="tooltip">i</span></h2>
<p class="desc_result"> <?php echo __($additional_sub_string,"calculate_bonus"); ?></p>
</div>
</div>
                    </div>

                    <div class="total_you_get">
	                    <div class="text-wrapper">
	                        <p class="gov_desc"> <?php echo __($total_govt_bonus,"calculate_bonus"); ?></p>
	                        <h2 class="total_bonus" >
		                        <span class="currency"><?php  echo __("£","calculate_bonus"); ?></span>
		                        <span class="amount"><?php echo __("--,--","calculate_bonus"); ?></span>
		                    </h2>
	                        <p class="break_btn"><input type="button" value="View Breakdown" name="view_breakdown" id="view_breakdown" /> </p>
	                    </div>
                        <div class="breakdown_popup_content">
	                        <div class="your_setting">
		                        <h4><?php echo __("Your Settings","calculate_bonus"); ?></h4>
		                        <p>
			                    	<?php
				                    	echo __("This table shows the accumulated value of your contributions in <strong><span class='d_year' >5</span> years</strong>, this assumes you continue with these settings and rates don’t change.","calculate_bonus");
				                    ?>
		                        </p>
	                        </div>
	                        <hr>
	                        <div class="popup_weekly_deposit">
		                        <h4 class="left"><?php echo __("Weekly deposit of","calculate_bonus"); ?></h4>
		                        <p class="right"><span class="currecny">£</span><span class="w_deposit"> </span> </p>
	                        </div>
	                        <div class="popup_govt_bonus">
		                        <div class="left">
			                        <p><strong><?php echo __("Government bonus","calculate_bonus"); ?></strong></p>
									<p class="gov-bonus-subtitle"></p>
								</div>
		                        <div class="right"> <span class="currecny">£</span><span class="g_y_bonus"></span> </div>
	                        </div>
	                        <div class="popup_interest">
		                        <div class="left">
			                        <h4><?php echo __("Interest on your LISA","calculate_bonus"); ?> </h4>
									<p class="interest_subtitle"> </p>
								</div>
		                        <div class="right interest_amount">  </div>
	                        </div>
	                        <hr>
	                        <div class="popup_interest other_popup_interest">
		                        <div class="left">
			                        <h4><?php echo __("Other savings account","calculate_bonus"); ?> </h4>
									<p class="other_interest_subtitle"></p>
								</div>
		                        <div class="right"> <span class="currecny">£</span><span class="g_y_bonus"></span> </div>
	                        </div>
	                        <hr class="bold">
	                        <div class="popup_interest total_bonus_amount">
		                        <div class="left">
			                        <h4><?php echo __("Balance in","calculate_bonus"); ?>  <span class="total_years" >--</span> <?php echo __("years","calculate_bonus"); ?></h4>
								</div>
		                        <div class="right"> <span class="currecny">£</span><span class="total_amount"></span></div>
	                        </div>
                        </div>
                        <div class="text-prompt promptWrapper top-drop-form">
                            <div class="linkTextingWidgetWrapper form-inputbox">
                                <div class="linkTextingWidget">
                                    <div class="promptContent"></div>
                                    <div class="linkTextingInner">
                                        <input class="linkID" type="hidden" value="b3b0c412-b1d5-4705-8c9d-accb9ac3003f" />
                                        <div class="linkTextingInputWrapper form-input">
                                            <input id="numberToText_linkTexting" class="linkTextingInput linkTextingInputFlagAdjust" type="tel" />
                                        </div>
                                        <button id="sendButton_linkTexting" onClick="ga('send', 'event', 'Button', 'Click', 'SMS Get Started Get App Banner'); fbq('trackCustom', 'VisitAppStore')" class="linkTextingButton" style="background-color: #3cbfbd; color: #ffffff;" type="button"><?php echo __("Get started","calculate_bonus"); ?></button><div id="linkTextingError" class="linkTextingError" style="display: none;">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="govt_policy mobile_view">
                        <p> <?php echo __($government_policy,"calculate_bonus"); ?></p>
                    </div>
                </div>
            </div>
        </div>
</section>
