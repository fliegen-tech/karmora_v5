<?php


/**
 * Description of Training
 *
 * @author Usman
 */
class Training extends karmora {

    public $data = array();
    public function __construct(){
        parent::__construct();
        $this->data['themeUrl'] = $this->themeUrl;
        $this->checklogin();
        $this->load->model(array('commonmodel','trainingmodel','usermodel'));
    }

    public function index($username = null) {
        $this->verifyUser($username);
        $this->data['mainsummery'] = $this->usermodel->getuser_main_summary($this->session->userdata('front_data')['id']);
        $this->data['active_page'] = 'training';
        $this->loadLayout($this->data,'frontend/training/content');
        
    }
    public function aboutkarmoratraining($username = null) {
        $this->verifyUser($username);
        $this->data['mainsummery'] = $this->usermodel->getuser_main_summary($this->session->userdata('front_data')['id']);
        $this->data['karmoraGeneralInformation'] = $this->trainingmodel->getkarmoraTraining(104);
        $this->data['karmoraCashBackShopping'] = $this->trainingmodel->getkarmoraTraining(105);
        $this->data['active_page'] = 'training';
        $this->loadLayout($this->data,'frontend/training/karmora_about_training');
        
    }
    public function karmoraproducttraining($username = null) {
        $this->verifyUser($username);
        $this->data['mainsummery'] = $this->usermodel->getuser_main_summary($this->session->userdata('front_data')['id']);
        $this->data['active_page'] = 'training';
        $this->data['productGeneralInformation'] = $this->trainingmodel->getkarmoraTraining(106);
        $this->data['productfalwesSkincare'] = $this->trainingmodel->getkarmoraTraining(107);
        $this->loadLayout($this->data,'frontend/training/karmora_product_training');
        
    }
    public function karmoramakingmoneytraining($username = null) {
        $this->verifyUser($username);
        $this->data['mainsummery'] = $this->usermodel->getuser_main_summary($this->session->userdata('front_data')['id']);
        $this->data['ProfitableShoppingCommunity'] = $this->trainingmodel->getkarmoraTraining(108);
        $this->data['MakingCompensationPlan'] = $this->trainingmodel->getkarmoraTraining(109);
        $this->data['MakingMoneyRetailSales'] = $this->trainingmodel->getkarmoraTraining(110);
        $this->data['active_page'] = 'training';
        $this->loadLayout($this->data,'frontend/training/karmoramakingmoneytraining');
        
    }
    public function downloadtraining($training_redirect,$file_path,$username = null) {
        $this->verifyUser($username);
        ignore_user_abort(true);
        set_time_limit(0); // disable the time limit for this script
        $fullPath = $this->data['themeUrl'].'public/upload/images/training/'.$file_path;
        //echo $fullPath; die;

        if ($fd = fopen ($fullPath, "r")) {
            $fsize = filesize($fullPath);
            $path_parts = pathinfo($fullPath);
            $ext = strtolower($path_parts["extension"]);
            switch ($ext) {
                case "pdf":
                header("Content-type: application/pdf");
                header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a file download
                break;
                // add more headers for other content types here
                default;
                header("Content-type: application/octet-stream");
                header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
                break;
            }
            header("Content-length: $fsize");
            header("Cache-control: private"); //use this to open files directly
            while(!feof($fd)) {
                $buffer = fread($fd, 2048);
                echo $buffer;
            }
        }
        fclose ($fd);
        redirect(base_url().$training_redirect);
    }
  

}
