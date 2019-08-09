<div class="dashboard-bottombar">
    <div class="container">
        <div class="row">
            <div class="col-4">
                <div class="cover-dashbord">
                    <span><strong><?php if(!empty($mainsummery)){ echo substr($mainsummery->name,0, 15).':';} ?> </strong><?php if(!empty($mainsummery)){ echo $mainsummery->account_type;} ?></span>
                </div>
            </div>
            <div class="col-4">
                <div class="cover-dashbord text-center">
                    <span><strong>Available Karmora Kash:</strong>$<?php if(!empty($mainsummery)){ echo number_format($mainsummery->available_karmora_kash,2,'.',',');} ?></span>
                </div>
            </div>
            <div class="col-4">
                <div class="cover-dashbord text-right">
                    <span><strong>Available Cash:</strong>$<?php if(!empty($mainsummery)){ echo number_format($mainsummery->available_cash,2,'.',',');} ?></span>
                </div>
            </div>
        </div>
    </div>
</div>