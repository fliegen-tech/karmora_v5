    <div class="top-header">
        <div class="row">
            <div class="col-6">
                <div class="top-leftbar">
                    <ul class="list-inline social-list">
                        <li class="list-inline-item">
                            <a href="https://www.facebook.com/karmora"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://twitter.com/Shopkarmora"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://www.pinterest.com/shopkarmora/"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://www.youtube.com/user/ShopKarmora"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://plus.google.com/u/0/+ShopKarmora/posts"><i class="fa fa-bold" aria-hidden="true"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-6">
                <div class="top-rightbar">
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href="">
                                <div class="search-bar"><i class="fa fa-search" aria-hidden="true"></i>Search</div>
                            </a>
                        </li>
                        <?php if ($this->session->userdata('front_data')) { ?>
                            <li class="list-inline-item">
                                <a href="<?php echo base_url() . 'logout' ?>">Logout</a>
                            </li>
                        <?php } else { ?>
                            <li class="list-inline-item">
                                <a href="<?php echo base_url().'login'; ?>">Login</a>
                            </li>
                        <?php } ?>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
