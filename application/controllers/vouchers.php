<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vouchers extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    /*
     * call me request POST
     */
    public function enter($voucher_name)
    {
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

//        $email_to = 'kerryparker@sbcommercials.co.uk; KPatten@sbcommercials.co.uk';
        $email_to = 'tomhughes@sbcommercials.co.uk';

        switch($voucher_name)
        {
        case 'tyres':
            $go = TRUE;
            $redirect = 'parts/offers/tyres';
            $email_title = 'Tyre voucher printed';
            break;
        }

        if($go != TRUE)
        {
            show_404();
        }

		if ($this->form_validation->run() == FALSE)
		{
            if(validation_errors())
            {
                $this->session->set_flashdata('alert', array(
                    'type' => 'error',
                    'message' => validation_errors()
                    )
                );
            }
		}
		else
		{
            $this->load->model('contact_model'); // needed?
            $this->contact_model->emailnote($email_to, $email_title, print_r($_POST, TRUE));

            $this->session->set_flashdata('alert', array(
                'voucher' => 'success',
                'message' => ''
                )
            );
        }
        redirect($redirect);
    }

    if($offer == "tyres" && $_POST)
    {
        $stmt = $DB->prepare("INSERT INTO `parts_offers`
            (name, address, postcode, phone_number, email, find_out, booking_date)
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute(array(
            $_POST['name'],
            $_POST['address'],
            $_POST['postcode'],
            $_POST['phone_number'],
            $_POST['email'],
            $_POST['find_out'],
            $_POST['booking_date']
        ));
        $voucher_code = date("md") . $DB->lastInsertId();

        $update = $DB->exec("UPDATE `parts_offers`
            SET `voucher_code` = '" . $voucher_code . "' WHERE `id` = " . $DB->lastInsertId());
        
        require_once(ROOTDIR . 'pdfgen/fpdf/fpdf.php'); 
        require_once(ROOTDIR . 'pdfgen/fpdi/fpdi.php'); 
        $pdf = new FPDI();

        $pdf->AddPage(); 

        $pdf->setSourceFile(ROOTDIR . 'inc/pdf/tyre-coupon.pdf'); 
        // import page 1 
        $tplIdx = $pdf->importPage(1);
        //use the imported page and place it at point 0,0; calculate width and height
        //automaticallay and ajust the page size to the size of the imported page 
        $pdf->useTemplate($tplIdx, 0, 0, 210, 297, FALSE); 

        $pdf->addPage(); 

        $tplIdx = $pdf->importPage(2);
        $pdf->useTemplate($tplIdx, 0, 0, 210, 297, true); 

        // now write some text above the imported page 
        $pdf->SetFont('Arial', '', '12'); 
        $pdf->SetTextColor(0,0,0);
        //set position in pdf document
        $pdf->SetXY(75, 28);
        //first parameter defines the line height
        $pdf->Write(0, $voucher_code);
        
        //force the browser to download the output
        $pdf->Output('gift_coupon_generated.pdf', 'I');

        mail('joinemail@sbcommercials.co.uk', 'Tyre Tread Depth & Pressure Check', print_r($_POST, true), 'From: onlineparts@sbcommercials.co.uk' . "\r\n" . 'Reply-To: onlineparts@sbcommercials.co.uk' . "\r\n" . 'X-Mailer: PHP/' . phpversion());
    }
    if($offer == "rearviewmirrors" && $_POST)
    {
        $stmt = $DB->prepare("INSERT INTO `parts_offers_rv`
            (name, address, postcode, phone_number, email, find_out, booking_date, branch)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute(array(
            $_POST['name'],
            $_POST['address'],
            $_POST['postcode'],
            $_POST['phone_number'],
            $_POST['email'],
            $_POST['find_out'],
            $_POST['booking_date'],
            $_POST['branch']
        ));
        $voucher_code = "CM" . date("md") . $DB->lastInsertId();

        $update = $DB->exec("UPDATE `parts_offers_rv`
            SET `voucher_code` = '" . $voucher_code . "' WHERE `id` = " . $DB->lastInsertId());
        
        require_once(ROOTDIR . 'pdfgen/fpdf/fpdf.php'); 
        require_once(ROOTDIR . 'pdfgen/fpdi/fpdi.php'); 
        $pdf = new FPDI();

        $pdf->AddPage(); 

        $pdf->setSourceFile(ROOTDIR . 'inc/pdf/mirror.pdf'); 
        // import page 1 
        $tplIdx = $pdf->importPage(1);
        //use the imported page and place it at point 0,0; calculate width and height
        //automaticallay and ajust the page size to the size of the imported page 
        $pdf->useTemplate($tplIdx, 0, 0, 210, 149, FALSE); 

        // now write some text above the imported page 
        $pdf->SetFont('Arial', '', '15'); 
        $pdf->SetTextColor(0,0,0);
        //set position in pdf document
        $pdf->SetXY(90, 26);
        //first parameter defines the line height
        $pdf->Write(0, $voucher_code);
        
        //force the browser to download the output
        $pdf->Output('gift_coupon_generated.pdf', 'I');

        mail('joinemail@sbcommercials.co.uk', 'Van Cracked Mirror Campaign', print_r($_POST, true), 'From: onlineparts@sbcommercials.co.uk' . "\r\n" . 'Reply-To: onlineparts@sbcommercials.co.uk' . "\r\n" . 'X-Mailer: PHP/' . phpversion());
    }

}
//EOF
