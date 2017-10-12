<section class="flawles-hompage flawless-nologin page-spacing">
    <div class="container">
        <div class="row">
            <!-- Top Heading -->
            <div class="col-12">
                <div class="top-heading-cover">
                    <h1>Flawless Skincare</h1>
                </div>
            </div>
            <!-- End Top Heading -->
            <div class="col-12">
                <h1 class="top-heading">Because <span>"omg you look amazing!"</span> never gets old</h1>
            </div>
            <div class="flawles-cover">
                <div class="row">
                    <div class="col-5">
                        <div class="flawles-leftbar">
                            <img src="<?php echo $themeUrl ?>/frontend/images/flawless-homepage-img.jpg">
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="flex-cover">
                            <div class="flawles-rightbar">
                                <p>Everyday our Shoppers are discovering that it is possible to look and feel beautiful without the use of harmful chemicals and preservatives that are prevalent in many commercial skincare lines.</p>
                                <p>Karmora is one of a handful of distinguished companies that have taken steps to ensure the health and happiness of our Shoppers by certifying that each and every Flawless product is organic, natural and Certified ToxicFreeTM. Discover how Naturally Beautiful You can be with Flawless Skincare!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if(!empty($products)){ ?>
                <div class="col-12 flawless-product-cover before-animated">
                <div class="row">
                    <?php foreach ($products as $pro){ ?>
                    <div class="col-3">
                        <div class="produt-one-cover">
                            <div class="product-image">
                                <a href="<?php echo base_url().'product-detail/'.$pro['pk_product_id']; ?>">
                                    <img src="<?php echo $themeUrl ?>/upload/images/product/<?php echo $pro['product_image']; ?>">
                                </a>
                            </div>
                            <div class="product-desp">
                                <a href="<?php echo base_url().'product-detail/'.$pro['pk_product_id']; ?>"><h4><?php echo $pro['product_title']; ?></h4></a>
                                <a href="<?php echo base_url().'product-detail/'.$pro['pk_product_id']; ?>" class="btn btn-shopnow">Shop Now</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
            <div class="col-12">
                <div class="watch-me">
                    <h3>Watch Me</h3>
                    <div class="video-cover">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/Kam77vMhYOA?rel=0" frameborder="0" allowfullscreen=""></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
if (empty($this->session->userdata('front_data'))) {
    $this->load->view('frontend/product/notlogin_section');
}?>



<!--====  End of Flawless not login homepage  ====-->


<!--===================================
=            Inner Section           =
====================================-->
<section class="money-toxia-sec">
    <div class="container">
        <div class="row">
            <div class="col-6">
                <div class="leftbar-toxia">
                    <img src="<?php echo $themeUrl ?>/frontend/images/toxia-free.png">
                    <h4>Confidence Through Care and Quality</h4>
                    <p>All Flawless Skincare Products are Certified ToxicFreeTM. They are certified to be pure, safe, ecofriendly, and of the highest quality! Certified to be formulated with organic purity and without the use of harmful chemicals or toxins!</p>
                </div>
            </div>
            <div class="col-6">
                <div class="leftbar-toxia">
                    <img src="<?php echo $themeUrl ?>/frontend/images/money-back-gurantee.png">
                    <h4>Good Karmora 100% Money Back Guarantee</h4>
                    <p>All Karmora Exclusive Products are backed by our 30 Day - No Questions Asked - Money Back Guarantee. If you would like to return a product for any reason, simply open a <a href="">live chat</a> with a Good Karmora Specialist and they will guide you on how you can return the product for a full refund. <a href="">Click Here</a> to review our refund policy.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!--====  End of Inner Section ====-->


<!--====  End of Flawless login homepage ====-->

