<?php
if(isset($user_email) && $user_name){
    $user_email     =  ($user_email != '' ? $user_email : '');
    $user_name      =  ($user_name != '' ? $user_name : '');
}
?><div class="join-now-step-one">
    <h4>Please Enter Your Full Name & Email Address</h4>
    <div class="join-now-step-cover">
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label class="input-field-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="fullname" name="fullname" aria-describedby="nameHelp" value="<?php echo $user_name; ?>" placeholder="Full Name">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="input-field-label">Email address <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" value="<?php echo $user_email; ?>" placeholder="Enter email">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
            </div>
            <div class="col-12">
                <p>Don’t worry we won’t share or sell your information to third parties. <a href="<?php echo base_url('karmora-privacy-policy');?>" target="_blank">Click Here</a> to view our Privacy Policy.</p>
            </div>
        </div>
    </div>
</div>