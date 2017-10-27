<div class="navbar-header">
    <nav id="topNav" class="navbar fixed-to navbar-expand-lg navbar-inverse bg-inverse">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target=".navbar-collapse">
            Menu
        </button>
        <a class="navbar-brand mx-auto" href="<?php echo base_url(); ?>">
            <img src="<?php echo $themeUrl ?>/frontend/images/karmora-logo.png" class="img-fluid" alt="...">
        </a>
        <div class="navbar-collapse collapse leftbar-content">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url(); ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About Karmora</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url().'karmora-kash'; ?>">Karmora Kash</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url().'click2win'; ?>">Click2Win</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto ">
                <li class="nav-item">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Exclusive Products
                    </a>
                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                        <li class="dropdown-submenu">
                            <a  class="dropdown-item" tabindex="-1" href="<?php echo base_url().'supplement-product'; ?>">Dietary Supplements</a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-item"><a tabindex="-1" href="<?php echo base_url().'supplement-product'; ?>">B3 Home</a></li>
                                <li class="dropdown-item"><a tabindex="-1" href="<?php echo base_url().'product-detail/55'; ?>"><img src="#"> B<sup>3</sup> Healthy</a></li>
                                <li class="dropdown-item"><a tabindex="-1" href="<?php echo base_url().'product-detail/56'; ?>"><img src="#"> B<sup>3</sup> Slim</a></li>
                                <li class="dropdown-item"><a tabindex="-1" href="<?php echo base_url().'product-detail/57'; ?>"><img src="#"> B<sup>3</sup> Beautiful</a></li>
                                <li class="dropdown-item"><a tabindex="-1" href="<?php echo base_url().'product-detail/58'; ?>"><img src="#"> B<sup>3</sup> Trim</a></li>
                                <li class="dropdown-item wlp-menu"><a tabindex="-1" href="#">Weight Loss Planner</a></li>
                                <li class="dropdown-item"><a tabindex="-1" href="#">Weight Loss Tips</a></li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                            <a  class="dropdown-item" tabindex="-1" href="<?php echo base_url().'flawless-product'; ?>">Flawless Skincare</a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-item"><a tabindex="-1" href="<?php echo base_url().'flawless-product'; ?>">Flawless Home</a></li>
                                <li class="dropdown-item"><a tabindex="-1" href="#"><img src="<?php echo base_url().'product-detail/4'; ?>"> Flawless Days</a></li>
                                <li class="dropdown-item"><a tabindex="-1" href="#"><img src="<?php echo base_url().'product-detail/6'; ?>"> Flawless Nights</a></li>
                                <li class="dropdown-item"><a tabindex="-1" href="#"><img src="<?php echo base_url().'product-detail/7'; ?>"> Simply Flawless</a></li>
                                <li class="dropdown-item"><a tabindex="-1" href="#"><img src="<?php echo base_url().'product-detail/8'; ?>"> Flawless Mist</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url().'share/'; ?>">Make Money</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url().'karmora-cash-back'; ?>">Cash Back Shopping</a>
                </li>
                <li class="nav-item">
                    <?php if ($this->session->userdata('front_data')) { ?>
                    <a class="nav-link" href="<?php echo base_url() . 'profile' ?>">My Account</a>
                    <?php }else{ ?>
                    <a class="nav-link" href="<?php echo base_url('join-today'); ?>">Join Today</a>
                    <?php } ?>
                </li>
            </ul>
        </div>
    </nav>
</div>
