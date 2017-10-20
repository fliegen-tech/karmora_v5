

    <section class="karmora-signup-section karmora-checkout-login">
       <div class="container">
          <div class="row">
            <div class="col-md-6 col-md-offset-3 col-sm-10 col-xs-12 col-sm-offset-1">
              <div class="sign-up-form karmora-signin-form">
                <form method="post" enctype="multipart/form-data" class="form-karmora">
                    <?php if(isset($message)){ ?>
                        <div class="alert alert-warning">
                          <?php echo $message; ?>
                        </div>
                      <?php } ?>
                  <h2>sign In to your account</h2>
                  <div class="col-md-12">
                    <div class="col-md-12">
                      <label>Email Address</label>
                    </div>
                    <div class="col-md-12">
                        <input type="email" value="<?php echo set_value('user_email'); ?>" required="required" name="user_email" >
                      <span class="error_message_class"><?php echo form_error('user_email'); ?></span>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="col-md-12">
                      <label>Password</label>
                    </div>
                    <div class="col-md-12">
                      <input required="required" type="password" name="user_password" >
                      <span class="error_message_class"><?php echo form_error('user_password'); ?></span>
                    </div>
                  </div>
                   <input type="hidden" name="pervious_url" value="<?php  if(isset($_SERVER['HTTP_REFERER'])){ echo $_SERVER['HTTP_REFERER'];} ?>">
                    
                  <div class="col-md-12 input-fileld-forget-rember">
                      <div class="col-xs-6">
                        <a href="<?php echo base_url('forgot-password');?>" class="forget-psrd-sign">Forgot your password?</a>
                      </div>

                  </div>
                  <div class="col-md-12 karmora-sign-in-full">
                    <div class="col-xs-6 col-md-offset-3 col-sm-offset-3 col-xs-offset-3 no-padding">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash();?>">
                        <input class="accoutn-signin" type="submit" name="signin" value="Sign In">
                    </div>
                  </div>

                </form>
                
               
              </div>

            </div>
          </div>
        </div>
    </section>



