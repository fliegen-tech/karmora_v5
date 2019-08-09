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
