<?php $this->load->view('frontend/layout/partials/reporting_nav_bar'); ?>


            <section class="cashmeout-page">
              <div class="container cashme-new">
              	<div class="clearfix"></div>
                <span class="line-spc"></span>
                <span class="line-spc"></span>
                <div class="row">
                	<div class="col-md-12">
                		<div class="step-cover karmora-video-form">
			              <h4 class="col-centered numbering">
			              	CONFIRM PAYMENT DESTINATION
			              	<span class="pull-right" style="padding-right: 20px;">Total Available: $7.00</span>
			              </h4>
			              <div class="h-numbering video-numberning">
			                <span class="step-text">Step</span><span class="step-number">1</span>
			              </div>
			            </div>
                	</div>
                </div>
                <div class="clearfix"></div>
                <span class="line-spc"></span>
                <span class="line-spc"></span>
                <div class="row">

                  <div class="col-md-12 payemnt-form">
                    <div class="step-content">
                      <!-- field cover -->
                      <div class="col-md-6 col-sm-6 form-field-row">
                          <label for="name">Name <span class="important-input">*</span></label>
                          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash();?>">
                          <input type="text" readonly="readonly" name="member_name" required="" class="form-control" placeholder="Full Name" value="Johnny  Depp"> 
                      </div> <!-- Field cover end -->
                     <!-- field cover -->
                      
                      <div class="col-md-6 col-sm-6 form-field-row">
                        <label for="name">State <span class="important-input">*</span></label>
                            <select name="state" required="" class="form-control">
                                <option value="1">Alabama</option>
                                <option value="2">Alaska</option>
                                <option value="3">Arizona</option>
                                <option value="4">Arkansas</option>
                                <option value="5">California</option>
                                <option value="6">Colorado</option>
                                <option value="7">Connecticut</option>
                                <option value="8">Delaware</option>
                                <option value="9">Florida</option>
                                <option value="10">Georgia</option>
                                <option value="11">Hawaii</option>
                                <option value="12">Idaho</option>
                                <option value="13">Illinois</option>
                                <option value="14">Indiana</option>
                                <option value="15">Iowa</option>
                                <option value="16">Kansas</option>
                                <option value="17">Kentucky</option>
                                <option value="18">Louisiana</option>
                                <option value="19">Maine</option>
                                <option value="20">Maryland</option>
                                <option value="21">Massachusetts</option>
                                <option value="22">Michigan</option>
                                <option value="23">Minnesota</option>
                                <option value="24">Mississippi</option>
                                <option value="25">Missouri</option>
                                <option value="26">Montana</option>
                                <option value="27">Nebraska</option>
                                <option value="28">Nevada</option>
                                <option value="29">New Hampshire</option>
                                <option value="30">New Jersey</option>
                                <option value="31">New Mexico</option>
                                <option value="32">New York</option>
                                <option value="33">North Carolina</option>
                                <option value="34">North Dakota</option>
                                <option value="35">Ohio</option>
                                <option value="36">Oklahoma</option>
                                <option value="37">Oregon</option>
                                <option value="38">Pennsylvania</option>
                                <option value="39">Rhode Island</option>
                                <option value="40">South Carolina</option>
                                <option value="41">South Dakota</option>
                                <option value="42">Tennessee</option>
                                <option value="43">Texas</option>
                                <option value="44">Utah</option>
                                <option value="45">Vermont</option>
                                <option value="46" selected="">Virginia</option>
                                <option value="47">Washington</option>
                                <option value="48">West Virginia</option>
                                <option value="49">Wisconsin</option>
                                <option value="50">Wyoming</option>
                                <option value="51">District of Columbia</option>
                            </select>
                      </div> <!-- Field cover end -->

                      <!-- field cover -->
                      <div class="col-md-6 col-sm-6 form-field-row">
                        <label for="name">Address <span class="important-input">*</span></label>
                        <input name="street_address" class="form-control" type="text" required="" placeholder="Address" value="524 Cabell Avenue">
                      </div> <!-- Field cover end -->

                      <!-- field cover -->
                      <div class="col-md-6 col-sm-6 form-field-row">
                          <label for="name">Zip Code <span class="important-input">*</span></label>
                          <input name="zipcode" type="text" class="form-control" placeholder="Zip Code" required="" value="22205">
                      </div> <!-- Field cover end -->

                      <!-- field cover -->
                      <div class="col-md-6 col-sm-6 form-field-row">
                          <label for="name">City <span class="important-input">*</span></label>
                          <input name="city" type="text" class="form-control" placeholder="City" required="" value="Arlington">
                      </div> <!-- Field cover end -->

                      <!-- field cover -->
                      <div class="col-md-6 col-sm-6 form-field-row">
                          <label for="name">Phone <span class="important-input">*</span></label>
                          <input type="text" name="phone_no" class="form-control" required="" placeholder="Phone Number" value="">
                      </div> <!-- Field cover end -->
                    </div>
                  </div>  <!-- Step-content -->
                </div>                    
              </div>
            </section>

            <span class="line-spc"></span>
            <section class="cashmeout-page">
              <div class="container cashme-new">
                <div class="clearfix"></div>
                <span class="line-spc"></span>
                <span class="line-spc"></span>
                <div class="row">
                	<div class="col-md-12">
                		<div class="step-cover karmora-video-form">
			              <h4 class="col-centered numbering">
			              	MAKE A CHARITABLE GIFT?
			              </h4>
			              <div class="h-numbering video-numberning">
			                <span class="step-text">Step</span><span class="step-number">2</span>
			              </div>
			            </div>
                	</div>
                </div>
                <div class="clearfix"></div>
                <span class="line-spc"></span>
                <span class="line-spc"></span>
                <div class="col-md-12 no-padding">
                  <p class="cashme-new-desp">You are under no obligation to do so, but before you Cash Out would you consider making a contribution to one of our Good Karmora Fundraising Organizations? &nbsp; <span>Karmora will match 5% of every contribution in cash and you will receive $2 Karmora Kash for every dollar that you gift!</span></p>
                </div>
                <div class="clearfix"></div>
                <span class="line-spc"></span><span class="line-spc"></span>
                <div class="col-md-12 no-padding">
                  <div class="charitable-gft">
                    <div class="form-group">
                      <div class="col-md-2" style="padding-left: 0px;">
                        <label for="sel1">Recipient: </label>
                      </div>
                      <div class="col-md-8">
                        <select class="form-control" id="sel1">
                          <option>Select Organization</option>
                          <option>2</option>
                          <option>3</option>
                          <option>4</option>
                        </select> 
                        <p>Don’t see a charity you support? &nbsp; <a href="">Click Here</a> to nominate a cause or charity that is close to your heart! </p>
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <span class="line-spc"></span>
                  <div class="charitable-gft">
                    <div class="form-group">
                      <div class="col-md-2" style="padding-left: 0px;">
                        <label for="sel1">Gift Amount:</label>
                      </div>
                      <div class="col-md-8">
                        <select class="form-control" id="sel1">
                          <option>$50.00 </option>
                          <option>$510.00 </option>
                          <option>$150.00 </option>
                          <option>$50.00 </option>
                        </select> 
                        <p>The gift amount entered will automatically reduce the check amount in the Cash Out section below. </p>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </section>

            <span class="line-spc"></span>
            <section class="cashmeout-page gft-cash-field">
              <div class="container cashme-new">

                <div class="clearfix"></div>
                <span class="line-spc"></span>
                <span class="line-spc"></span>
                <div class="row">
                	<div class="col-md-12">
                		<div class="step-cover karmora-video-form">
			              <h4 class="col-centered numbering">
			              	CASH ME OUT!
			              </h4>
			              <div class="h-numbering video-numberning">
			                <span class="step-text">Step</span><span class="step-number">3</span>
			              </div>
			            </div>
                	</div>
                </div>
                <div class="clearfix"></div>
                <span class="line-spc"></span>
                <span class="line-spc"></span>
                <p>Now it’s time to Cash Out! &nbsp; Please review your check request and click Cash Me Out!</p>
                <span class="line-spc"></span>
                <div class="clearfix"></div>
                <span class="line-spc"></span><span class="line-spc"></span>
                <div class="col-md-12 no-padding">
                  <div class="charitable-gft gft-cash-out">
                    <div class="form-group">
                      <div class="col-md-2" style="padding-left: 0px;">
                        <label for="sel1">Available Balance</label>
                      </div>
                      <div class="col-md-4">
                        <input type="text"  class="form-control" placeholder="">
                        <span class="dollar-sign-new"></span>
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <span class="line-spc"></span>
                  <div class="charitable-gft gft-cash-out">
                    <div class="form-group">
                      <div class="col-md-2" style="padding-left: 0px;">
                        <label for="sel1">Gift Amount:</label>
                      </div>
                      <div class="col-md-4">
                        <input type="text"  class="form-control" placeholder="">
                        <span class="dollar-sign-new"></span>
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <span class="line-spc"></span>
                  <div class="charitable-gft gft-cash-out">
                    <div class="form-group">
                      <div class="col-md-2" style="padding-left: 0px;">
                        <label for="sel1">Check Amount:</label>
                      </div>
                      <div class="col-md-4">
                        <input type="text"  class="form-control" placeholder=" ">
                        <span class="dollar-sign-new"></span>
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <span class="line-spc"></span>
                  <div class="charitable-gft gft-cash-out">
                    <div class="form-group">
                      <div class="col-md-2" style="padding-left: 0px;">
                      </div>
                      <div class="col-md-4" >
                        <div class="cash-me-out-new-btn" style="text-align: left;">
                          <a href="#" class="unregister-join btn-br">Cash Me Out!</a>
                          <a href="#" class="unregister-join btn-br">Clear</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </section>

            <span class="line-spc"></span><span class="line-spc"></span>
            <section class="table-karmora-accounting table-karmora-cash-out">
              <div class="container">
                  <div class="row">
                    <div class="col-md-12">
                      <h2 class="payment-new-cash">Payment Allocation</h2>
                    </div>
                    <div class="col-md-12 table-responsive">
                      <table class="table table-striped accounting-table">
                        <thead>
                            <tr>
                              <th>Transcation Date</th>
                              <th>Transaction ID</th>
                              <th>Name</th>
                              <th>Address</th>
                              <th>Amount </th>
                              <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                              <td>August 26,2016</td>
                              <td>00006</td>
                              <td>Johnny  Depp</td>
                              <td>524 Cabell Avenue, Arlington 22205 Virginia</td>
                              <td>$606.30</td>
                              <td>Requested</td>
                            </tr>
                            <tr>
                              <td>August 05,2016</td>
                              <td>00003</td>
                              <td>Johnny  Depp</td>
                              <td>101 suit, Main building, carson 12345 Alabama</td>
                              <td>$300.00</td>
                              <td>Requested</td>
                            </tr>
                            
                            <tr>
                                <td>August 05,2016</td>
                                <td>00002</td>
                                <td>Johnny  Depp</td>
                                <td>101 suit, Main building, carson 12345 Alabama</td>
                                <td>$100.00</td>
                                <td>Requested</td>
                            </tr>
                            
                            <tr>
                                <td>August 05,2016</td>
                                <td>00001</td>
                                <td>Johnny  Depp</td>
                                <td>assa, ssddasssa 22323 Alaska</td>
                                <td>$457.00</td>
                                <td>Requested</td>
                            </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
              </div>
            </section>

            <span class="line-spc"></span><span class="line-spc"></span>
            <section class="minmium-cash-out-deatail">
              <div class="container">
                  <div class="row">
                    <div class="col-md-12">
                      <p><strong>Karmora Kash Gift Match</strong>-  Karmora will match 5% of your gift amount and you will instantly receive $2 of Karmora Kash for every $1 that you contribute!  Karmora Fundraising Organizations may, or may not, classify as charitable organizations under the IRS tax code.  Please consult with your independent tax advisor about the deductibility of your generous gift to your chosen fundraising organization.</p>
                      <span class="line-spc"></span><span class="line-spc"></span> 
                      <p><strong>Minimum Check Amount </strong>– Karmora is pleased to pay our Shoppers!  However, we can only process check requests for amounts equal or greater than $10.  If your available balance is less than $10 you can either donate your funds to charity or comeback win your available balance is more than $10.</p>
                      <span class="line-spc"></span><span class="line-spc"></span> 
                      <p><strong>Change in Destination</strong>– We are happy to ship your check anywhere that you please, however you are not able to change the recipient name.  If you would like to permanently change your address please click on the “My Profile” tab above and submit a change of address.</p>
                      <span class="line-spc"></span><span class="line-spc"></span> 
                      <p><strong>Check Issuance </strong>– There is a nominal $2.00 processing fee for shipping and handling of your check.  This fee is imposed by our third party check issuing company to ensure safe and efficient delivery of your check.  Checks will normally arrive at their destination within 7 business days.  If you do not receive your check within the normal timeframe please open a live chat with a Good Karmora Specialist to trace your check.</p>
                      <div class="have-question" style="margin-top: 9px;">
                        <ul class="list-inline">
                          <li><a onclick="window.open('https://www.karmora.com/liveSupport/', 'sharer', 'toolbar=0,status=0,width=600,height=600');" target="_parent" href="javascript: void(0)" class="pop-up-on-page"><img src="http://staging3.karmora.com/public/images/question-compostation.png" style="margin-left: 0px;">Have Questions?</a></li>
                          <li><a onclick="window.open('https://www.karmora.com/liveSupport/', 'sharer', 'toolbar=0,status=0,width=600,height=600');" target="_parent" href="javascript: void(0)"><span id="support-form"> Chat with Us<img src="http://staging3.karmora.com/public/images/chat.png"></span></a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
              </div>
            </section>