<?php if (!empty($categories)) { ?>

      <div class="mobile-screen">
        <div class="category-header navbar-light">
          <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#sidebar">
              <span class="navbar-toggler-icon"></span>
          </button>
          <a href="#">Categories</a>
        </div>
        <div class="sidebar collapse" id="sidebar">
            <div class="list-group panel">
                <a href="<?php echo base_url('special-offer/cash_o_palooza') ?>"
                   class="list-group-item important-cashback collapsed" data-parent="#sidebar">Double Take</a>
                <a href="<?php echo base_url('special-offer/smokin_hot_deals') ?>"
                   class="list-group-item important-cashback collapsed" data-parent="#sidebar">Smokin Hot Deals</a>
                <a href="<?php echo base_url('store/all'); ?>" class="list-group-item important-cashback collapsed"
                   data-parent="#sidebar">View All Stores</a>
                <?php if (!$this->session->userdata('front_data')) { ?>
                    <a href="<?php echo base_url() . 'login'; ?>" class="list-group-item important-cashback collapsed">My
                        Favorites </a>
                <?php } else { ?>
                    <a href="<?php echo base_url('my-favorite'); ?>"
                       class="list-group-item important-cashback collapsed">My Favorites </a>
                <?php } ?>

                <?php foreach ($categories as $catS) { ?>
                    <a href="#<?php echo $catS['alias']; ?>" class="list-group-item collapsed"
                       data-toggle="collapse" data-parent="#sidebar"
                       aria-expanded="false"><?php echo $catS['title']; ?></a>
                    <?php if (!empty($top_stores)) {
                        foreach ($top_stores as $k => $v) {
                            if ($catS['alias'] === $k) { ?>
                            <div class="collapse" id="<?php echo $catS['alias']; ?>">
                                <?php
                                    foreach ($top_stores[$catS['alias']] as $store) { ?>
                                    <a href="<?php echo base_url('store-detail/' . $store['store_id']) ?>"
                                       class="list-group-item"
                                       data-parent="#<?php echo $catS['alias']; ?>"><?php echo $store['store_title']; ?></a>
                                    <?php } next($top_stores); ?>
                                <a href="<?php echo base_url('store/' . $catS['alias']); ?>" class="list-group-item">View All</a>
                            </div>
                    <?php
                                    }
                                }
                            }
                    }
                    ?>
            </div>
        </div>
      </div>
      <div class="desktop-screen">
        <div class="collapse in show sidebar" id="sidebar">
          <div class="list-group panel">
              <a href="<?php echo base_url('special-offer/cash_o_palooza') ?>"
                 class="list-group-item important-cashback collapsed" data-parent="#sidebar">Double Take</a>
              <a href="<?php echo base_url('special-offer/smokin_hot_deals') ?>"
                 class="list-group-item important-cashback collapsed" data-parent="#sidebar">Smokin Hot Deals</a>
              <a href="<?php echo base_url('store/all'); ?>" class="list-group-item important-cashback collapsed"
                 data-parent="#sidebar">View All Stores</a>
              <?php if (!$this->session->userdata('front_data')) { ?>
                  <a href="<?php echo base_url() . 'login'; ?>" class="list-group-item important-cashback collapsed">My
                      Favorites </a>
              <?php } else { ?>
                  <a href="<?php echo base_url('my-favorite'); ?>"
                     class="list-group-item important-cashback collapsed">My Favorites </a>
              <?php } ?>

              <?php foreach ($categories as $catS) { ?>
                  <a href="#<?php echo $catS['alias']; ?>" class="list-group-item collapsed"
                     data-toggle="collapse" data-parent="#sidebar"
                     aria-expanded="false"><?php echo $catS['title']; ?></a>
                  <?php if (!empty($top_stores)) {
                      foreach ($top_stores as $k => $v) {
                          if ($catS['alias'] === $k) { ?>
                          <div class="collapse" id="<?php echo $catS['alias']; ?>">
                              <?php
                                  foreach ($top_stores[$catS['alias']] as $store) { ?>
                                  <a href="<?php echo base_url('store-detail/' . $store['store_id']) ?>"
                                     class="list-group-item"
                                     data-parent="#<?php echo $catS['alias']; ?>"><?php echo $store['store_title']; ?></a>
                                  <?php } next($top_stores); ?>
                              <a href="<?php echo base_url('store/' . $catS['alias']); ?>" class="list-group-item">View All</a>
                          </div>
                  <?php
                                  }
                              }
                          }
                  }
                  ?>
          </div>
        </div>
      </div>
<?php } ?>

