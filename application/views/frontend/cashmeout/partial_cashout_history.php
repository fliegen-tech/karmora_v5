<table class="table table-bordered">
    <thead>
    <tr>
        <th>Transaction Date</th>
        <th>Transaction ID</th>
        <th>Name</th>
        <th>Address</th>
        <th>Amount</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($CashMeMember as $mem) { ?>
        <tr>
            <td scope="row"><?php echo date('F d,Y', strtotime($mem['transaction_date'])); ?></td>
            <td ><?php echo str_pad((int) $mem['transaction_id'], 5, "0", STR_PAD_LEFT); ?></td>
            <td><?php echo $mem['FullName']; ?></td>
            <td ><?php echo $mem['FullAdrees']; ?></td>
            <td ><?php echo '$ ' . number_format($mem['amount'], 2); ?></td>
            <td ><?php echo $mem['status']; ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>


<?php if (!empty($myContribution)) { ?>
<div class="row">
    <div class="col-12">
        <div class="check-request">
            <h3>GIFTS</h3>
            <div class="karmora-table table-responsive" id="gift-table">
                <!-- My Cummunity Table -->
                <table id="example2" class="table table-striped accounting-table" >
                        <thead>
                            <tr>
                                <th>Transaction Date </th>
                                <th>Organization Name</th>
                                <th>My Contribution </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($myContribution as $tKey => $tValue) { ?>
                                <tr>
                                    <td scope="row" ><?php echo $tValue['contribution_date']; ?></td>
                                    <td ><?php echo $tValue['org_name']; ?></td>
                                    <td ><?php echo '$' . number_format($tValue['my_contirbution'], 2, ".", ","); ?></td>
                                </tr>
                                <?php }  ?>
                        </tbody>
                    </table>
            </div>
            <p><strong>Karmora Kash Gift Match -</strong> Karmora will match 5% of your gift amount and you will instantly receive $2 of Karmora Kash for every $1 that you contribute! Karmora Fundraising Organizations may, or may not, classify as charitable organizations under the IRS tax code. Please consult with your independent tax advisor about the deductibility of your generous gift to your chosen fundraising organization.</p>
            <p><strong>Minimum Check Amount -</strong> Karmora is pleased to pay our Shoppers! However, we can only process check requests for amounts equal or greater than $10. If your available balance is less than $10 you can either donate your funds to charity or comeback win your available balance is more than $10.</p>
            <p><strong>Change in Destination -</strong> We are happy to ship your check anywhere that you please, however you are not able to change the recipient name. If you would like to permanently change your address please click on the “My Profile�? tab above and submit a change of address.</p>
            <p><strong>Check Issuance -</strong> There is a nominal $2.00 processing fee for shipping and handling of your check. This fee is imposed by our third party check issuing company to ensure safe and efficient delivery of your check. Checks will normally arrive at their destination within 7 business days. If you do not receive your check within the normal timeframe please open a live chat with a Good Karmora Specialist to trace your check.</p>
            <ul class="list-inline list-contact-live">
                <li><a onclick="window.open('https://www.karmora.com/liveSupport/', 'sharer', 'toolbar=0,status=0,width=600,height=600');" target="_parent" href="javascript: void(0)">Have Questions? <img src="<?php echo $themeUrl ?>/frontend/images/question-compostation.png"></a></li>
                <li><a onclick="window.open('https://www.karmora.com/liveSupport/', 'sharer', 'toolbar=0,status=0,width=600,height=600');" target="_parent" href="javascript: void(0)">Chat with Us <img src="<?php echo $themeUrl ?>/frontend/images/chat.png"></a></li>
            </ul>
        </div>
    </div>
</div>
<?php } ?>
 
