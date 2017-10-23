<!--=========================================
    =            Join Now           =
    ==========================================-->
<section class="casual-signup-sec page-spacing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Let’s Start Saving You Money!</h1>
            </div>
        </div>
        <div class="signup-cover">
            <div class="row">
                <div class="col-12">
                    <h2>Tell Us A Little Bit About You!</h2>
                </div>
            </div>
            <?php
            echo $this->session->flashdata($flashKey);
            echo form_open(base_url('join-casual'));

            $this->load->view($view. 'partials/signup_form');
            
            is_null($username) ? $this->load->view($view. 'partials/referrer_form') : '';
            ?>

            <div class="col-12 text-center">
                <div class="signup-btn">
                    <button class="btn btn-joinnow left-right-hover" type="submit" name="submit" value="submit">Sign Me up</button>
                </div>
            </div>
        </div>
    </div>
</section>
<!--====  End of Join Now ====-->