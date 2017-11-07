<div class="payment-icons text-center">
    <img src="<?php echo $themeUrl; ?>/frontend/images/payment-icons.png" alt="">
</div> 
<div class="form-group">
    <div class="row">
        <label class="col-sm-4 col-form-label">Card Number <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" name="payment_detail[number]" class="form-control card-fileds" id="card-number" aria-describedby="addresHelp" placeholder="">
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <label class="col-sm-4 col-form-label">Expiration Date <span class="text-danger">*</span></label>
        <div class="col-sm-4">
            <input type="text" name="payment_detail[month]" onfocusout="calucaltetax()" class="form-control card-fileds" id="card-number" aria-describedby="addresHelp" placeholder="MM">
        </div>
        <div class="col-sm-4 p-l-0">
            <input type="text" name="payment_detail[year]" class="form-control card-fileds" id="card-number" aria-describedby="addresHelp" placeholder="YYYY">
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <label class="col-sm-4 col-form-label">CVV <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" name="payment_detail[cvv]" onblur="calucaltetax()" class="form-control card-fileds" id="card-number" aria-describedby="addresHelp" placeholder="">
        </div>
    </div>
</div>