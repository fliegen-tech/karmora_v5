<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<?php $shipping_cost = 0;$exclusiveProductTotal = 0; ?>
<?php echo form_open("", array( 'id' => 'form', 'class' => 'form-inline', 'name'=>"form" ));?>
    <section class="step-section checkout-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" name="thecallback" id="thecallback" value="">

                    <!-- Step No # -->
                    <?php if (isset($this->session->userdata['front_data'])){ $login = true; }else{ $login = FALSE;?>
                        <div class="revamp-steps"> 
                            <h1 class="step-vise-revamp"><span>Step  <?php if (isset($refreal_check) && $refreal_check == true) { echo 2;}else{echo 1;} ?></span> - Account Information</h1>
                            <div class="step-content">                
                                <div class="row">
                                    <div class="form-group col-md-6 col-sm-6 revamp-padding">
                                        <label for="name">Full Name <span class="important-input">*</span></label>
                                        <input type="text" onkeyup="getname(this.value)" class="form-control" required="required"  value="<?php if(isset ($_POST['username'])){ echo $_POST['username'];} elseif(!empty($userData) && isset($userData['user_first_name']) && isset($userData['user_last_name'])) { echo $userData['user_first_name'] . ' ' . $userData['user_last_name'];} ?>" name="username" id="name" placeholder="Full Name" autocomplete="off">
                                        <span class="error_message_class"><?php echo form_error('username'); ?></span>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 revamp-padding">
                                        <label for="pwd">Email <span class="important-input">*</span></label>
                                        <input type="email" value="<?php
                                        if(isset ($_POST['email'])){ echo $_POST['email'];} elseif (!empty($userData)) {
                                            echo isset($userData['user_email']); } ?>" required="required"  class="form-control" name="email"
                                           id="pwd" placeholder="Email Address">
                                        <span class="error_message_class"><?php echo form_error('email'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>


                    <!-- Step 2 -->
                    <div class="revamp-steps">
                        <div class="step-content">
                            <div class="row">

                                    <div class="form-group col-md-6 col-sm-6">
                                        <label for="name">Full Name <span class="important-input">*</span></label>
                                            <input type="text" id="shipping_detailname" class="form-control" value="<?php if (!empty($userData)) { echo isset($userData['user_first_name']) . ' ' . isset($userData['user_last_name']);}?> " name="shipping_detail[shipping_name]"  placeholder="Full Name">
                                    </div>

                                    <div class="form-group col-md-6 col-sm-6">
                                        <label for="address1">Address 1 <span class="important-input">*</span></label>
                                        <input  type="text"    name="shipping_detail[street_address]"  class="form-control" <?php if (empty($address['street_address'])) { ?> value="<?php echo set_value('shipping_detail[street_address]'); ?>"<?php } else { ?>value="<?php echo $address['street_address']; ?>" <?php } ?> id="shipping_detailaddress1" placeholder="Address1">
                                        <span class="error_message_class"><?php echo form_error('shipping_detail[street_address]'); ?></span>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6">
                                        <label for="address2">Address 2 </label>
                                        <input type="text" name="shipping_detail[street_address_2]" <?php if (empty($address['street_address_2'])) { ?> value="<?php echo set_value('shipping_detail[street_address_2]'); ?>"<?php } else { ?>value="<?php echo $address['street_address_2']; ?>" <?php } ?> class="form-control" id="shipping_detailaddress2" placeholder="Address2">
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6">
                                        <label for="city">City <span class="important-input">*</span></label>
                                        <input type="text"   name="shipping_detail[city]" <?php if (empty($address['city'])) { ?> value="<?php echo set_value('shipping_detail[city]'); ?>"<?php } else { ?>value="<?php echo $address['city']; ?>"<?php } ?> class="form-control" id="billing_city2" placeholder="City">
                                        <span class="error_message_class"><?php echo form_error('shipping_detail[city]'); ?></span>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6">
                                        <label for="state">State <span class="important-input">*</span></label>
                                        <select id="statesList_as_billing"    name="shipping_detail[state]"  class="form-control">
                                            <option selected="selected" disabled="disabled">--- Select State ---</option>
                                            <?php
                                                if ($statesList !== false) {
                                                $first = true;
                                                foreach ($statesList as $state) {
                                                    if ($first) {
                                                        reset($statesList);
                                                        $first = false;
                                                    }
                                                    ?>
                                                    <option value="<?php echo $state['optionVal'] ?>" <?php if(isset($_POST['shipping_detail']['state']) && ($_POST['shipping_detail']['state'] == $state['optionVal'])){ echo 'selected="selected"';} else if ($state['pk_user_address_state_id'] === $address['state_id']) { ?> selected="selected" <?php } ?> > <?php echo $state['user_address_state_code'] . ' - ' . $state['user_address_state_title']; ?> </option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <span class="error_message_class"><?php echo form_error('shipping_detail[state]'); ?></span>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6">
                                        <label for="zipcode">Zip Code <span class="important-input">*</span></label>
                                        <input type="text"   <?php if (empty($address['zipcode'])) { ?> value="<?php echo set_value('shipping_detail[zipcode]'); ?>"<?php } else { ?>value="<?php echo $address['zipcode']; ?>"<?php } ?>  name="shipping_detail[zipcode]"  class="form-control" id="zipcode_shiiping" placeholder="Zip Code">
                                        <span class="error_message_class"><?php echo form_error('shipping_detail[zipcode]'); ?></span>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6">
                                        <label for="country">Country <span class="important-input">*</span></label>
                                        <select id="countriesList_shiiping" name="shipping_detail[country]" class="form-control" > <!--onchange="getStatesofSelectedCountry(this.value)"-->
                                            <?php if ($countriesList !== false) {
                                                $first = true;
                                                foreach ($countriesList as $country) {
                                                    if ($first) {
                                                        reset($countriesList);
                                                        $first = false;
                                                    }
                                                    ?>
                                                    <option value="<?php echo $country['pk_user_address_country_id'] ?>" <?php if ($address !== false && $country['pk_user_address_country_id'] === $address['country_id']) { ?> selected="selected" <?php } ?> > <?php echo $country['user_address_country_code'] . ' - ' . $country['user_address_country_title'] ?> </option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <span class="error_message_class"><?php echo form_error('shipping_detail[country]'); ?></span>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6">
                                        <label for="phone">Phone <span class="important-input">*</span></label>
                                        <input   onclick="calucaltetax()" autocomplete="off" id="phoneList_shiiping" type="text"  name="shipping_detail[phone]" class="form-control"  value="<?php if ($this->session->userdata('front_data') && $userData['user_phone_no'] != '') { echo $userData['user_phone_no']; } ?>" placeholder="(111) 111-1111">
                                        <span class="error_message_class"><?php echo form_error('shipping_detail[phone]'); ?></span>
                                    </div>
                                </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <!-- Step 3 -->

                    <div class="revamp-steps">
                        <div class="step-content">
                            <div class="row">
                                <div id="error_message_tax"></div>
                                <div class="col-md-12">
                                    <div class="confirm-shipping-address">
                                   <input type="checkbox"    value="1" id="sameshipaddress" class="same-ship-add" name="sameshipaddress" />
                                        <label>Same As Shipping Address</label>
                                    </div>
                                </div>
                            <div id="sameshipaddresshide">
                                <div class="form-group col-md-6 col-sm-6">
                                    <label for="name">Name <span class="important-input">*</span></label>
                                    <input type="text" id="billing_address_name" class="form-control" value="<?php if (!empty($userData)  ) { echo isset($userData['user_first_name']) . ' ' . isset($userData['user_last_name']);}?> " name="biling_detail[billing_name]"  placeholder="Full Name">
                                </div>
                                <div class="form-group col-md-6 col-sm-6">
                                    <label for="address1">Address 1 <span class="important-input">*</span></label>
                                    <input type="text"    name="biling_detail[street_address]"   class="form-control" value="<?php echo set_value('biling_detail[street_address]'); ?>" id="address1" placeholder="Address1">
                                    <span class="error_message_class"><?php echo form_error('biling_detail[street_address]'); ?></span>
                                </div>
                                <div class="form-group col-md-6 col-sm-6">
                                    <label for="address2">Address 2 </label>
                                    <input type="text"   name="biling_detail[street_address_2]" class="form-control" value="<?php echo set_value('biling_detail[street_address_2]'); ?>" id="address2" placeholder="Address2">
                                </div>
                                <div class="form-group col-md-6 col-sm-6">
                                    <label for="city">City <span class="important-input">*</span></label>
                                    <input type="text"     name="biling_detail[city]"   class="form-control" value="<?php echo set_value('biling_detail[city]'); ?>" id="city" placeholder="City">
                                    <span class="error_message_class"><?php echo form_error('biling_detail[city]'); ?></span>
                                </div>
                                <div class="form-group col-md-6 col-sm-6">
                                    <label for="state">State <span class="important-input">*</span></label>
                                    <select id="statesList"     name="biling_detail[state]"   class="form-control">
                                        <option selected="selected" disabled="disabled">--- Select State ---</option><?php if ($statesList !== false) {
                                                $first = true;
                                                foreach ($statesList as $state) {
                                                    if ($first) {
                                                        reset($statesList);
                                                        $first = false;
                                                    }
                                                    ?>
                                                    <option value="<?php echo $state['optionVal'] ?>" <?php if(isset($_POST['biling_detail']['state']) && ($_POST['biling_detail']['state'] == $state['optionVal'])){ echo 'selected="selected"';} ?>> <?php echo $state['user_address_state_code'] . ' - ' . $state['user_address_state_title']; ?> </option>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                    <span class="error_message_class"><?php echo form_error('biling_detail[state]'); ?></span>
                                </div>
                                <div class="form-group col-md-6 col-sm-6">
                                    <label for="zipcode">Zip Code <span class="important-input">*</span></label>
                                    <input type="text"     name="biling_detail[zipcode]"   class="form-control" value="<?php echo set_value('biling_detail[zipcode]'); ?>" id="zipcode" placeholder="Zip Code">
                                    <span class="error_message_class"><?php echo form_error('biling_detail[zipcode]'); ?></span>
                                </div>
                                <div class="form-group col-md-6 col-sm-6">
                                    <label for="country">Country <span class="important-input">*</span></label>
                                    <select id="countriesList"   name="biling_detail[country]" class="form-control" > <!--onchange="getStatesofSelectedCountry(this.value)"-->
                                        <?php if ($countriesList !== false) {
                                            $first = true;
                                            foreach ($countriesList as $country) {
                                                if ($first) {
                                                    reset($countriesList);
                                                    $first = false;
                                                }
                                                ?>
                                                <option value="<?php echo $country['pk_user_address_country_id'] ?>" > <?php echo $country['user_address_country_code'] . ' - ' . $country['user_address_country_title'] ?> </option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <span class="error_message_class"><?php echo form_error('biling_detail[country]'); ?></span>
                                </div>
                                <div class="form-group col-md-6 col-sm-6">
                                    <label for="phone">Phone <span class="important-input">*</span></label>
                                    <input type="text" value=""  name="biling_detail[phone]" class="form-control"   onclick="calucaltetax()" id="phone_no_mark"  value="<?php if(isset($_POST['biling_detail']['phone'])){ echo $_POST['biling_detail']['phone'];} ?>" placeholder="(111) 111-1111">
                                    <span class="error_message_class"><?php echo form_error('biling_detail[phone]'); ?></span>
                                </div>
                            </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>


                      <!-- Step 3 -->
                    <?php if (isset($this->session->userdata['front_data'])) { ?>
                        <div class="revamp-steps">
                            <div class="step-content">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <?php if (isset($redum_value) && $redum_value != '' && $redum_value > 0) { ?>
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <h3 class="apply-newly-comision">Apply Available Karmora Kash</h3>
                                                        <p class="apply-comission-para">You have <span>$<?php echo number_format($available_karmora_cash, 2, '.', ','); ?></span> of Karmora Kash available. You can use up to <span>$<?php echo number_format($redum_value, 2, '.', ','); ?></span> towards this purchase. Would you like to apply Karmora Kash? </p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="checkboxes-cover pull-right">
                                                            <div class="switch">
                                                                <input type="checkbox" id="karmora_cash_check" name="karmora_cash_check" value="1" class="switch-input">
                                                                <label for="karmora_cash_check" class="switch-label">Switch</label>
                                                                <input type="hidden" name="karmora_cash" id="karmora_cash" value="<?php echo $redum_value; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                    <?php } ?>
                                                <div class="row">
                                                <div class="col-md-9">
                                                    <?php if (isset($commsion_value) ) { ?>
                                                    <br>
                                                    <h3 class="apply-newly-comision">Apply eWallet Funds</h3>
                                                    <?php /*
                                                    <p class="apply-comission-para">You have <span>$<?php echo number_format($available_commsion, 2, '.', ','); ?></span> of Commission available. Would you like to apply Commissions?</p>
                                                     */ ?>
                                                    <p>You have <span class="karmora-color-pink">$<?php echo number_format($available_commsion, 2, '.', ','); ?></span> of available funds that can be applied towards your purchase.  Would you like to use your available funds?</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <?php if (isset($commsion_value) && $commsion_value != '' && $commsion_value > 0) { ?>
                                                    <div class="checkboxes-cover pull-right">
                                                            <div class="switch">
                                                                <input type="checkbox"  id="karmora_commsion_check" name="karmora_commsion_check" value="1" class="switch-input">
                                                                <label for="karmora_commsion_check" class="switch-label">Switch</label>
                                                                <input type="hidden" name="karmora_commsion" id="karmora_commsion" value="<?php echo $commsion_value; ?>">
                                                            </div>
                                                    </div>
                                                    <?php } ?>
                                                    </div>
                                                </div>
                                        </div>
                                            <?php } ?>
                                        <div class="col-md-5">
                                             <!-- Table Content -->
                                            <div class="contoinue-checkout-rightbar product-checkout-desp" >
                                                <div class="no-padding">
                                                    <div class="totals-heading-backgrounds cart-items-bg">
                                                        <h2>Cart Items <a class="edit-btn" href="<?php echo base_url('cart/show_cart') ?>"> <span class="btn btn-default edit-button">Edit</span> </a></h2>

                                                    </div>
                                                </div>
                                            <div class="col-md-12 no-padding">
                                                <div class="col-xs-4 checkout-totals checkout-t-head">
                                                    <strong>Name</strong>
                                                </div>
                                                <div class="col-xs-3 checkout-totals checkout-t-head">
                                                    <strong>Price </strong>
                                                </div>
                                                <div class="col-xs-2 checkout-totals checkout-center checkout-t-head">
                                                    <strong> Qty. </strong>
                                                </div>
                                                <div class="col-xs-3 checkout-totals checkout-t-head">
                                                    <strong> Total </strong>
                                                </div>
                                            </div>
                                            <div class="col-md-12 no-padding">
                                                <?php
                                                $y = 0;
                                                foreach ($this->cart->contents() as $items) {
                                                ?>
                                                <div class="col-xs-4 checkout-totals checkout-t-col" data-toggle="tooltip" data-placement="top" title="<?php echo trim($items['name'], ' '); ?>"><?php echo substr(trim($items['name'], ' '), 0, 10); ?>...</div>

                                                <div class="col-xs-3 checkout-totals checkout-t-col">$<?php
                                                    if ($items['shopper_account_type_price'] != '' && isset($cate_array[$y]['pro_id']) == $items['id'] && isset($cate_array[$y]['cat_id']) !== 111) {
                                                        echo number_format($items['shopper_account_type_price'], 2, '.', ',');
                                                        $exclusiveProductTotal = $exclusiveProductTotal + ($items['qty'] * $items['shopper_account_type_price']);
                                                    } else {
                                                        echo $this->cart->format_number($items['price'], 2, '.', ',');
                                                        $exclusiveProductTotal = $exclusiveProductTotal + ($items['qty'] * $items['price']);
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-xs-2 checkout-totals checkout-center checkout-t-col"><?php echo $items['qty']; ?></div>
                                                <div class="col-xs-3 checkout-totals checkout-t-col">$<?php echo number_format($items['subtotal'], 2, '.', ','); ?></div>

                                                <?php
                                                    $y++;
                                                    }
                                                    ?>

                                            </div>
                                            <div class="clearfix"></div>
                                        </div>





                                    <div class="contoinue-checkout-rightbar  checkout-totals">
                                        <div class="no-padding">
                                            <div class="totals-heading-backgrounds cart-items-bg checkout-black">
                                                <h2>Order Totals</h2>
                                            </div>
                                        </div>
                                        <?php $actualCost_without_shipping_cost = number_format($this->cart->total()  , 2, '.', ',');?>
                                        <input type="hidden" id="actualCost_without_shipping_cost" value="<?php echo  $actualCost_without_shipping_cost; ?>" />
                                        <?php $actualCost = number_format($this->cart->total() + $shipping_cost , 2, '.', ',');?>
                                        <input type="hidden" id="actual_cost" value="<?php echo  $actualCost; ?>" />
                                        <input type="hidden" name="actual_cost_non_edit" id="actual_cost_non_edit" value="<?php echo  $actualCost; ?>" />
                                        <input type="hidden" name="order_shipping_cost" id="order_shipping_cost" value="<?php echo  $shipping_cost; ?>" />

                                        <div style="font-size: 12px; line-height: 8px;">

                                        <div class="tab-row clearfix">
                                            <div class="col-xs-6 checkout-totals checkout-tonew">
                                                Exclusive Products
                                            </div>
                                            <div class="col-xs-6 checkout-totals checkout-totals-1 checkout-tonew">
                                                $<?php echo number_format($exclusiveProductTotal, 2, '.', ','); ?>
                                            </div>
                                        </div>


                                         <div class="tab-row clearfix">
                                            <div id="karmora_cash_disply" style="display:none;" class="col-xs-6 checkout-totals checkout-tonew">
                                                Karmora Kash
                                            </div>
                                            <div id="karmora_cash_price" style="display:none; color: red;" class="col-xs-6 checkout-totals checkout-totals-1 checkout-tonew">
                                                $<?php  echo number_format(0, 2, '.', ','); ?>
                                            </div>
                                            <input type="hidden" id="karmora_kash_use" value="0" />
                                         </div>

                                         <div class="tab-row clearfix">
                                            <div class="col-xs-6 checkout-totals checkout-tonew">
                                                <strong>Subtotal</strong>
                                            </div>
                                             <div id="exclusiveproductTotal_karmora_cash" class="col-xs-6 checkout-totals checkout-totals-1 checkout-tonew">
                                                <strong>$<?php echo number_format($exclusiveProductTotal, 2, '.', ','); ?></strong>
                                            </div>
                                        </div>

                                         <div class="tab-row clearfix">
                                            <div class="col-xs-6 checkout-totals checkout-tonew">
                                                Shipping &amp; Handling
                                            </div>
                                             <div  id="shipping_html" class="col-xs-6 checkout-totals checkout-totals-1 checkout-tonew">
                                                $<?php echo number_format($shipping_cost, 2, '.', ','); ?>
                                            </div>
                                        </div>


                                          <div class="tab-row clearfix">
                                            <div id="karmora_tax_disply" class="col-xs-6 checkout-totals checkout-tonew">
                                                Tax
                                            </div>
                                            <div id="karmora_tax_price" class="col-xs-6 checkout-totals checkout-totals-1 checkout-tonew">
                                                $<?php echo number_format(0, 2, '.', ','); ?>
                                            </div>
                                            <input type="hidden" name="tax_price_hidden" id="tax_price_hidden" value="0" />
                                         </div>

                                          <div class="tab-row clearfix">
                                          <div class="col-xs-6 checkout-totals checkout-tonew">
                                                <strong>Order Total:</strong>
                                            </div>
                                            <div id="ordertotal-display" class="col-xs-6 checkout-totals checkout-totals-1 checkout-tonew">
                                                <strong > $<?php echo $actualCost; ?> </strong>
                                            </div>
                                            <input type="hidden" id="ordertotal" value="<?php echo $actualCost ?>" />
                                            <input type="hidden" id="tax" value="0" />
                                         </div>

                                         <div class="tab-row clearfix">
                                             <div id="karmora_commsion_disply" style="display:none;" class="col-xs-6 checkout-totals checkout-tonew">
                                                eWallet Funds Applied
                                            </div>
                                            <div id="karmora_commsion_price" style="display:none; color: red" class="col-xs-6 checkout-totals checkout-totals-1 checkout-tonew">
                                                $ <?php echo number_format(0, 2, '.', ','); ?>
                                            </div>
                                            <input type="hidden" id="karmora_commission_use" value="0" />

                                         </div>

                                        <div class="tab-row clearfix">
                                            <div class="col-xs-6 checkout-totals checkout-tonew checkout-bottom">
                                                <strong>Charge Amount:</strong>
                                            </div>
                                            <div id="total_charged" class="col-xs-6 checkout-totals checkout-totals-1 checkout-bottom checkout-tonew">
                                                <strong id="total_amount_all_pay"> $<?php echo $actualCost; ?> </strong>
                                            </div>
                                            <input type="hidden" name="total_payed" value="<?php echo $actualCost; ?>" id="total_payed_value">
                                            <input type="hidden" name="total_payed_calculate" value="<?php echo $actualCost; ?>" id="total_payed_calculate">
                                            <input type="hidden" name="region" value="" id="region_hidden">
                                        </div>

                                        </div>
                                        <div class="clearfix"></div>

                                </div>
                            </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            </div>
                                            </div>
                    <?php } ?>

                        </div>


                <div class="clearfix"></div>


                    <!-- Step 3 -->
                    <div class="revamp-steps" id="eleminte">
                        <h1 class="step-vise-revamp"><span>Step <?php if (isset($refreal_check) && $refreal_check == true) { echo 5;}elseif($login == true){echo 4;}else{ echo 4;} ?></span> - Checkout</h1>

                        <div class="step-content">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-fields-cover text-center form-field-last-cover">
                                        <div class="payment-icons">
                                            <img src="<?php echo $themeUrl; ?>/images/payment-icons.png" alt="">
                                            <!-- <p>Safe and Secure 256 Bit Encrypted Processing</p> -->
                                        </div>
                                        <!-- Single Field Cover -->
                                        <div class="single-field-cover text-left">
                                            <div class="col-md-3 col-sm-3 col-xs-3  field-labels">
                                                <label for="input-id">Card Number <span class="danger">*</span></label>
                                            </div>
                                            <div class="col-md-9 col-sm-9 col-xs-9  field-input">
                                                <input type="text" name="card_number" required="required" id="card_number" class="form-control" value=""  placeholder="" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <!-- Single Field Cover -->
                                        <div class="single-field-cover text-left">
                                            <div class="col-md-3  col-sm-3 col-xs-3 field-labels">
                                                <label for="input-id">Expiration Date <span class="danger">*</span></label>
                                            </div>
                                            <div class="col-xs-4 field-input">
                                                <div class="form-group">
                                                    <input type="text" name="month" required="required" id="month" class="form-control" value=""  placeholder="MM" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-5 col-sm-5 col-xs-5 field-input">
                                                <div class="form-group">
                                                    <input type="text" name="year" required="required" id="year" class="form-control" value=""  placeholder="YYYY" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <!-- Single Field Cover -->
                                        <div class="single-field-cover text-left">
                                            <div class="col-md-3 col-sm-3 col-xs-3  field-labels">
                                                <label for="input-id"><span data-toggle="tooltip" title="There is some description...">CVV</span> <span class="danger">*</span></label>
                                            </div>
                                            <div class="col-md-9 col-sm-9 col-xs-9 field-input">
                                                <input type="text" name="card_code" required="required" id="card_code" class="form-control" value=""  placeholder="" autocomplete="off">
                                            </div>
                                        </div>

                                        <!-- order summery -->
                                        <span class="line-spc"></span>
                                        <div class="clearfix"></div>

                                    </div>
                                </div>
                                <?php if (!isset($this->session->userdata['front_data']) || $this->session->userdata['front_data'] == '') { ?>
                                    <!-- SECOND CART START -->
                                    <div class="col-md-6">

                                    <div class="contoinue-checkout-rightbar product-checkout-desp" >
                                        <div class="no-padding">
                                            <div class="totals-heading-backgrounds cart-items-bg">
                                                <h2>Cart Items <a class="edit-btn" href="<?php echo base_url('cart/show_cart') ?>"> <span class="btn btn-default edit-button">Edit</span> </a></h2>

                                            </div>
                                        </div>
                                        <div class="col-md-12 no-padding">
                                            <div class="col-xs-4 checkout-totals checkout-t-head">
                                                <strong>Name</strong>
                                            </div>
                                            <div class="col-xs-3 checkout-totals checkout-t-head">
                                                <strong>Price </strong>
                                            </div>
                                            <div class="col-xs-2 checkout-totals checkout-center checkout-t-head">
                                                <strong> Qty. </strong>
                                            </div>
                                            <div class="col-xs-3 checkout-totals checkout-t-head">
                                                <strong> Total </strong>
                                            </div>
                                        </div>
                                        <div class="col-md-12 no-padding">


                                        </div>

                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="contoinue-checkout-rightbar checkout-totals">
                                        <div class="no-padding">
                                            <div class="totals-heading-backgrounds cart-items-bg checkout-black">
                                                <h2>Order Totals</h2>
                                            </div>
                                        </div>
                                        <?php $actualCost_without_shipping_cost = number_format($this->cart->total()  , 2, '.', ',');?>
                                        <input type="hidden" id="actualCost_without_shipping_cost" value="<?php echo  $actualCost_without_shipping_cost; ?>" />

                                        <?php $actualCost = number_format($this->cart->total() + $shipping_cost , 2, '.', ',');?>
                                        <input type="hidden" id="actual_cost" value="<?php echo  $actualCost; ?>" />
                                        <input type="hidden" name="actual_cost_non_edit" id="actual_cost_non_edit" value="<?php echo  $actualCost; ?>" />

                                        <div style="font-size: 12px; line-height: 8px;">

                                        <div class="tab-row clearfix">
                                            <div class="col-xs-6 checkout-totals checkout-tonew">
                                                Cart Products
                                            </div>
                                            <div class="col-xs-6 checkout-totals checkout-totals-1 checkout-tonew">
                                                $<?php echo number_format($exclusiveProductTotal, 2, '.', ','); ?>
                                            </div>
                                        </div>

                                         <div class="tab-row clearfix">
                                            <div class="col-xs-6 checkout-totals checkout-tonew">
                                                Shipping &amp; Charges
                                            </div>
                                            <div class="col-xs-6 checkout-totals checkout-totals-1 checkout-tonew">
                                                $<?php echo number_format($shipping_cost, 2, '.', ','); ?>
                                            </div>
                                        </div>
                                         <div class="tab-row clearfix">
                                            <div id="karmora_cash_disply" style="display:none;" class="col-xs-6 checkout-totals checkout-tonew">
                                                Karmora Cash
                                            </div>
                                            <div id="karmora_cash_price" style="display:none; color: red;" class="col-xs-6 checkout-totals checkout-totals-1 checkout-tonew">
                                                $<?php  echo number_format(0, 2, '.', ','); ?>
                                            </div>
                                            <input type="hidden" id="karmora_kash_use" value="0" />
                                         </div>

                                          <div class="tab-row clearfix">
                                            <div id="karmora_tax_disply" class="col-xs-6 checkout-totals checkout-tonew">
                                                Tax
                                            </div>
                                            <div id="karmora_tax_price" class="col-xs-6 checkout-totals checkout-totals-1 checkout-tonew">
                                                $<?php echo number_format(0, 2, '.', ','); ?>
                                            </div>
                                            <input type="hidden" name="tax_price_hidden" id="tax_price_hidden" value="0" />
                                         </div>

                                          <div class="tab-row clearfix">
                                          <div class="col-xs-6 checkout-totals checkout-tonew">
                                                <strong>Order Total:</strong>
                                            </div>
                                            <div id="ordertotal-display" class="col-xs-6 checkout-totals checkout-totals-1 checkout-tonew">
                                                <strong > $<?php echo $actualCost; ?> </strong>
                                            </div>
                                            <input type="hidden" id="ordertotal" value="<?php echo $actualCost ?>" />
                                            <input type="hidden" id="tax" value="0" />
                                         </div>

                                         <div class="tab-row clearfix">
                                             <div id="karmora_commsion_disply" style="display:none;" class="col-xs-6 checkout-totals checkout-tonew">
                                                Available Funds
                                            </div>
                                            <div id="karmora_commsion_price" style="display:none; color: red" class="col-xs-6 checkout-totals checkout-totals-1 checkout-tonew">
                                                $ <?php echo number_format(0, 2, '.', ','); ?>
                                            </div>
                                            <input type="hidden" id="karmora_commission_use" value="0" />

                                         </div>

                                        <div class="tab-row clearfix">
                                            <div class="col-xs-6 checkout-totals checkout-tonew checkout-bottom">
                                                <strong>Charge Amount:</strong>
                                            </div>
                                            <div id="total_charged" class="col-xs-6 checkout-totals checkout-totals-1 checkout-bottom checkout-tonew">
                                                <strong id="total_amount_all_pay"> $<?php echo $actualCost; ?> </strong>
                                            </div>
                                            <input type="hidden" name="total_payed" value="<?php echo $actualCost; ?>" id="total_payed_value">
                                            <input type="hidden" name="total_payed_calculate" value="<?php echo $actualCost; ?>" id="total_payed_calculate">
                                            <input type="hidden" name="region" value="" id="region_hidden">
                                        </div>
                                    </div>

                                </div>
                                <!-- SECOND CART ENd -->



                            </div>
                                <?php } ?>


                        </div>
                    </div>

                    <div class="clearfix"></div>
            <input type="hidden" name="karmora_commsion_used_final" value="" id="karmora_commsion_used_final">

            

            <div class="clearfix"></div>
            <span class="line-spc"></span>
            
            </div>
                    <div class="single-field-cover text-center col-md-12">
                <span class="line-spc"></span>
                <div id="loading" style="display:none;"></div>               
                <div style="margin-top:-15px;" class="checkout-btns-karmora" id="submit_button">
                    <input type="submit" name="submit" id="submit_me" style="display:none;" class="checkout-btn-new" hidden="hidden">
                    <input type="button"  id="PayNow" onclick="paynow();" class="checkout-btn-new"  value="Pay Now">
                    <a href="#" data-toggle="modal" data-target="#karmora_monay_back"><img src="<?php echo $themeUrl; ?>/images/money-back-100.png"></a>
                </div>
                
                    
            </div>
            </div>

    </div>
</section>
<?php echo form_close();?>
<?php //$this->load->view('frontend/layout/popup'); ?>

<div class="modal fade" id="declined" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content model-save-money">
      <div class="modal-header">
        <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
        <div class="model-tit-declined">
         <span class="text-float1"><i class="fa fa-frown-o " aria-hidden="true"></i></span> Ooops! <span class="text-float2"><i class="fa fa-frown-o " aria-hidden="true"></i></span>
        </div>
      </div>
      <div class="modal-body">
        <h5 class="kamora-declined">Your Credit Card Has Been Declined...</h5>
        <p class="karmora-declined-er">Please correct the credit card information you provided.</p>
      </div>
      
    </div>
  </div>
</div> 
<script>
function calucaltetax(){
    if($('#sameshipaddress').is(":checked")){
        var result = $("[name='shipping_detail[street_address]']");
        var Line1  = result.val();
        var result = $("[name='shipping_detail[city]']");
        var City   = result.val();
        var result = $("[name='shipping_detail[zipcode]']");
        var PostalCode = result.val();
        var RegionStr   = $("#statesList_as_billing").find("option:selected").text();
        var RegionArray = RegionStr.split("-");
        var region = RegionArray[0].replace(/\s/g, '');
        var result = $("[name='shipping_detail[phone]']");
        var PhoneNo = result.val();
        
    }else{
       var result = $("[name='biling_detail[street_address]']");
        var Line1  = result.val();
        var result = $("[name='biling_detail[city]']");
        var City   = result.val();
        var result = $("[name='biling_detail[zipcode]']");
        var PostalCode = result.val();
        var RegionStr   = $("#statesList").find("option:selected").text();
        var RegionArray = RegionStr.split("-");
        var region = RegionArray[0].replace(/\s/g, '');
        var result = $("[name='biling_detail[phone]']");
        var PhoneNo = result.val(); 
        
    }
        if(PhoneNo.length < 7){
           PhoneNo = '';
        }
        if(PostalCode.length < 5){
           PostalCode = '';
        }
        if(Line1.length < 2){
           Line1 = '';
        }
        if(City.length < 2){
           City = '';
        }
        jQuery('#region_hidden').val(region);
        if(Line1!='' && City!='' && PostalCode!='' & region!='' & PhoneNo!=''){
            var form = jQuery("#form");
            var data = form.serialize();
                jQuery.ajax({
                 type: 'POST', 
                 url: baseurl+'calculateTax/'+region+'/ajax',
                 data:data,
                 form: form,
                 context: document.body,
                 error: function(data, transport) { },
                 success: function(data){
                     console.info(data);
                     if(data == 'erroronaddress'){
                            jQuery('#tax_price_hidden').val(0);
                            $("#submit_button").hide();
                            getproductfinal();
                            $("#sameshipaddresshide").show();
                            $('#error_message_tax').focus();
                            $('#sameshipaddress').attr('checked',false);
                            $("#error_message_tax").html('<div class="alert alert-danger">The Provided Address Is incorrect </div>');
                    }else{
                            var tax_price = parseFloat(data).toFixed(2);
                            jQuery('#karmora_tax_price').html('$'+tax_price);
                            jQuery('#tax_price_hidden').val(data);
                            $("#submit_button").show();
                            $("#error_message_tax").html('');
                            getproductfinal();
                            
                }       }
              });
        }else{
            //$("#error_message_tax").html('<div class="alert alert-danger">Please insert complete address. </div>');
            jQuery('#tax_price_hidden').val(0);
            getproductfinal();                        
        }    
}
</script>
<?php //$this->load->view('frontend/cart/checkout_js'); ?>


<!-- End karmora-refund-policy -->


<script>
function getname(name_value){
    if (name_value !== '') {
            $("#billing_address_name").val(name_value);
    }else{
          $("#billing_address_name").val();  
    }
}
</script>


<script>
    function paynow(){
        if ($("#form").valid()) { //alert('aaasdd');
                $("#loading").show();
                var form = jQuery("#form");
                var data = form.serialize();
                jQuery.ajax({
                        type: 'POST',
                        data:data,
                        form: form,
                        url: baseurl + 'authrioze/',
                        context: document.body,
                        error: function (data, transport) {
                            alert("Sorry, the operation is failed.");
                        },
                        success: function (data) {
                                if(data == 'error'){
                                $("#loading").hide();
                                $('#declined').modal('show');
                                $("#card_number").val('');
                                $("#month").val('');
                                $("#year").val('');
                                $("#card_code").val('');
                            }else{
                                $("#loading").hide();
                                $('#thecallback').val(data);
                                $('input[type=submit]').trigger('click');
                                
                            }

                        }
                    }); 
                    }else{
                        $(this).find(":input.error:first").focus();
                    }
        return false;
    };        
    
</script>