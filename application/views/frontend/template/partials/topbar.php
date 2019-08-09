    <div class="top-header">
        <div class="row">
            <div class="col-6">
                <div class="top-leftbar">
                    <ul class="list-inline social-list">
                        <li class="list-inline-item">
                            <a href="https://www.facebook.com/karmora" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://twitter.com/Shopkarmora" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://www.pinterest.com/shopkarmora/" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://www.youtube.com/user/ShopKarmora" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://plus.google.com/u/0/+ShopKarmora/posts" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="<?php echo base_url('blog'); ?>" target="_blank"><i class="fa fa-bold" aria-hidden="true"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-6">
                <div class="top-rightbar">
                    <ul class="list-inline">
                        <li class="list-inline-item">
                        	<a href="javascript:void(0);" class="search-cover-top">
		                    	<div class="search-bar"><i class="fa fa-search" aria-hidden="true"></i>Search</div>
		                	</a>
                            <div class="searchform">
                                <div class="searchbox-cover" id="search-box">
                                    <span class="cross-search" onclick="emptyvalue();" id="box-close"><i class="fa fa-times" aria-hidden="true"></i></span>
                                    <form action="#" autocomplete="off">
                                        <div class="form-group">
                                            <input class="form-control" id="" placeholder="Enter your keyword..." name="serach_store"  onKeyUp="store_search(this.value)"  type="text" >
                                            <ul id="search" class="top-search-box"></ul>
                                        </div>
                                    </form>
                                </div>
                                <div class="clearfix"></div>
                            </div>
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
                            <a href="<?php echo base_url().'cart'; ?>">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
