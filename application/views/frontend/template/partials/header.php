<header>
<?php
    $this->load->view('frontend/template/partials/topbar');
    $this->load->view('frontend/template/partials/nav');
?>
</header>
<script> var baseurl = '<?php echo base_url(); ?>'; </script>
<script> var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>'; </script>