<div class="row">
    <div class="form-group col-md-6 col-sm-6 revamp-padding">
        <label for="name">Name <span class="important-input">*</span></label>
        <input type="text" class="form-control" required="required" value="<?php echo set_value('username'); ?>" name="username"
               id="name" placeholder="Full Name">
        <span class="error_message_class"><?php echo form_error('username'); ?></span>
    </div>
    <div class="form-group col-md-6 col-sm-6 revamp-padding">
        <label for="pwd">Email <span class="important-input">*</span></label>
        <input type="email" value="<?php echo set_value('email'); ?>" required="required"  class="form-control" name="email"
               id="pwd" placeholder="Email Address">
        <span class="error_message_class"><?php echo form_error('email'); ?></span>
    </div>
</div>
