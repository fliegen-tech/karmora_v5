<section class="casual-signup-sec page-spacing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Welcome to Karmora</h1>
            </div>
        </div>
        <div class="signup-cover">
            <div class="row">
                <div class="col-12">
                    <?php 
                    echo $this->session->flashdata($flashKey);
                    $this->session->keep_flashdata('first_login');
                    foreach($userDetail as $key => $value){
                        echo $key. ' : '. $value.'<br>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>