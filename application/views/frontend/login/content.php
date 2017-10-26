<section class="karmora-login-sec page-spacing">
    <div class="container">
        <div class="row">
            <div class="col-8 mx-auto">
                <div class="top-heading-cover">
                    <h1>SIGN IN TO YOUR ACCOUNT</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-8 mx-auto">
                <?php if(isset($message)){ ?>
                    <div class="alert alert-warning">
                        <?php echo $message; ?>
                    </div>
                <?php } ?> 
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="input-field-label">Email Address <span class="text-danger">*</span></label>
                        <input placeholder="Enter email" type="email" class="form-control" value="<?php echo set_value('user_email'); ?>" required="required" name="user_email" >
                        <span class="error_message_class"><?php echo form_error('user_email'); ?></span>
                    </div>
                    <div class="form-group">
                        <label  class="input-field-label">Password <span class="text-danger">*</span></label>
                        <input required="required" class="form-control" placeholder="Password" type="password" name="user_password" >
                        <span class="error_message_class"><?php echo form_error('user_password'); ?></span>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <a href="<?php echo base_url('forgot-password');?>" target="_blank" class="underlined-text">Forgot your password?</a>
                        </div>
                        <div class="col-6">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="loginbtn-cover">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                <input class="btn btn-joinnow left-right-hover" type="submit" name="signin" value="Sign In">
                                <input type="hidden" name="pervious_url" value="<?php  if(isset($_SERVER['HTTP_REFERER'])){ echo $_SERVER['HTTP_REFERER'];} ?>">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!--====  End of Karmora Login====-->