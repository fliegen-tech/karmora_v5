<!--============================
    =            Footer            =
    =============================-->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-3">
                <div class="footer-link-box">
                    <h2>Company info</h2>
                    <ul class="list-unstyled services-footer">
                        <li><a href="<?php echo base_url() . 'about-us'; ?>">About Us</a></li>
                        <li><a href="<?php echo base_url() . 'karmora-cares'; ?>">Karmora Cares</a></li>
                        <li>
                            <a onclick="window.open('https://www.karmora.com/liveSupport/', 'sharer', 'toolbar=0,status=0,width=600,height=600');"
                               target="_parent" href="javascript: void(0)">Live Support</a></li>
                        <li><a href="<?php echo base_url() . 'contact-us'; ?>">Contact Us</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-3">
                <div class="footer-link-box">
                    <h2>Disclosures</h2>
                    <ul class="list-unstyled services-footer">
                        <li><a href="<?php echo base_url() . 'karmora-terms-conditions'; ?>">Terms of Use</a></li>
                        <li><a href="<?php echo base_url() . 'karmora-privacy-policy'; ?>">Privacy Policy</a></li>
                        <li><a href="<?php echo base_url() . 'karmora-return-policy'; ?>">Refund Policy</a></li>
                        <li><a href="<?php echo base_url() . 'income-disclosure-statement'; ?>">Income Disclosure
                                Statement</a></li>
                        <li><a href="<?php echo base_url() . 'cash-back-disclosure-statement'; ?>">Cash Back Disclosure
                                Statement</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-3">
                <div class="footer-link-box">
                    <h2>Premier Shopper Program</h2>
                    <ul class="list-unstyled services-footer">
                        <li><a href="<?php echo base_url() . 'compensation-plan'; ?>">It Pays to Share Good Karmora!</a>
                        </li><!-- 
                        <li><a href="<?php // echo base_url() . 'profit-sharing-program'; ?>">Profit Sharing Pool</a></li> -->
                        <li><a href="#" data-toggle="modal" data-target="#cash-back-gurantee">Best Cash Back
                                Guarantee</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-3">
                <div class="footer-link-box">
                    <h2>Connect</h2>
                    <div class="footer-social">
                        <ul class="connect-social list-unstyled">
                            <li><a target="_blank" href="https://www.facebook.com/karmora"><i
                                            class="fa fa-facebook"></i></a></li>
                            <li><a target="_blank" href="https://twitter.com/Shopkarmora"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a target="_blank" href="https://plus.google.com/u/0/+ShopKarmora/posts"><i
                                            class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                            <li><a target="_blank" href="https://www.pinterest.com/shopkarmora/"><i
                                            class="fa fa-pinterest"></i></a></li>
                            <li><a target="_blank" href="https://www.youtube.com/user/ShopKarmora"><i
                                            class="fa fa-youtube-play"></i></a></li>
                            <li><a href="<?php echo base_url( 'blog' ); ?>" target="_blank"><i class="fa fa-bold"
                                                                                               aria-hidden="true"></i></a>
                            </li>
                        </ul>
                        <div class="get-toolbar-footer">
                            <a href="<?php echo base_url() . 'kash-back-toolbar'; ?>" class="btn btn-toobar">Get the
                                Cash Back Toolbar</a>
                            <a href="<?php echo base_url() . 'how-cashback-works'; ?>" class="btn work-cash-back">How
                                Cash Back Shopping Works</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="row">
                <div class="col-12">
                    <div class="allrights">
                        <p class="para-footer">
                            Karmora is the next big thing in online shopping! &nbsp; Your Karmora Website contains over
                            2,000 name brand stores offering great cash back, rebates and coupons. &nbsp; Shop where you
                            want… when you want… and earn top Cash Back! But, your shopping journey doesn’t have to end
                            with earning cash back… with Karmora you earn Matching Karmora Kash on every purchase that
                            can be used to purchase our fantabulous Flawless Skincare and B<sup>3</sup> Supplements and
                            Exclusive Products! &nbsp; Those looking for extra income can build their own online
                            Shopping Community and earn generous recurring referral commissions on every purchase and
                            participate on the most exciting Bonus Program in online shopping history! &nbsp; Everything
                            needed to build a large and profitable shopping community is contained in your Karmora
                            website. &nbsp; Simply share our premade advertisements consistently on your favorite social
                            media channels and watch in amazement as your Shopping Community and income grows!</p>
                    </div>
                </div>
                <div class="col-12">
                    <div class="allrights-text">
                        <p>2017 © Karmora - All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!--====  End of Footer  ====-->
<!-- jQuery -->
<script src="<?php echo $themeUrl ?>/frontend/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.8.2/umd/popper.js"></script>
<!-- Bootstrap JS -->
<script src="<?php echo $themeUrl ?>/frontend/js/bootstrap.js"></script>
<!-- Custom Scripts -->
<script src="<?php echo $themeUrl ?>/frontend/js/okzoom.min.js"></script>
<script src="<?php echo $themeUrl ?>/frontend/js/slick.min.js"></script>
<script src="<?php echo $themeUrl ?>/frontend/js/jquery.validate.min.js"></script>
<script src="<?php echo $themeUrl ?>/frontend/js/custom-scripts.js"></script>
<!-- Parellex-window -->
<script src="<?php echo $themeUrl ?>/frontend/js/magiczoom.js"></script>
<script src="<?php echo $themeUrl ?>/frontend/js/cart.js"></script>
<!--DataTables Script-->
<script src="<?php echo $themeUrl ?>/frontend/js/jquery.dataTables.min.js"></script>
<?php
if ( isset( $modals ) && ! empty( $modals ) ) {
    foreach ( $modals as $key => $val ) {
        if ( $val == 'first_login' && $this->session->flashdata( 'first_login' ) ) {
            $this->load->view( "frontend/template/partials/popups/" . $val );
        } else {
            $this->load->view( "frontend/template/partials/popups/" . $val );
        }
    }
}
?>
</body>
</html>