<div class="col-12">
    <div class="user-dashboard-menu">
        <ul class="list-inline">
            <li class="list-inline <?php if(isset($active_page) && $active_page == 'profile'){ echo 'active'; } ?>"><a href="<?php echo base_url().'profile'; ?>">My Profile</a></li>
            <li class="list-inline <?php if(isset($active_page) && $active_page == 'community'){ echo 'active'; } ?>"><a href="<?php echo base_url().'my-community'; ?>">My Community</a></li>
            <li class="list-inline <?php if(isset($active_page) && $active_page == ''){ echo 'active'; } ?>"><a href="">My eWallet</a></li>
            <li class="list-inline <?php if(isset($active_page) && $active_page == 'karmora_kash'){ echo 'active'; } ?>"><a href="<?php echo base_url().'my-karmora-kash'; ?>">My Karmora Kash</a></li>
            <li class="list-inline <?php if(isset($active_page) && $active_page == 'order'){ echo 'active'; } ?>"><a href="<?php echo base_url().'my-orders'; ?>">My Orders</a></li>
            <li class="list-inline <?php if(isset($active_page) && $active_page == 'charities'){ echo 'active'; } ?>"><a href="<?php echo base_url().'karmora-my-charities'; ?>">My Charities</a></li>
            <li class="list-inline <?php if(isset($active_page) && $active_page == 'profit_sharing'){ echo 'active'; } ?>"><a href="<?php echo base_url().'profitsharing'; ?>">Bonus Pool</a></li>
            <li class="list-inline <?php if(isset($active_page) && $active_page == 'ad_tracker'){ echo 'active'; } ?>"><a href="<?php echo base_url().'adtracker'; ?>">Ad Tracker</a></li>
            <li class="list-inline <?php if(isset($active_page) && $active_page == 'Cashmeout'){ echo 'active'; } ?>"><a href="<?php echo base_url().'cashmeout'; ?>">Cash Me Out</a></li>
            <li class="list-inline <?php if(isset($active_page) && $active_page == 'training'){ echo 'active'; } ?>"><a href="<?php echo base_url().'karmora-training'; ?>">Training</a></li>
        </ul>
    </div>
</div>
