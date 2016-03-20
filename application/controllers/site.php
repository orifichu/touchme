<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends MY_Controller {

	public function __construct()
    {
        parent::__construct();

        //Definir el folder que contendrá los views a los que mayormente llamará esta clase
		$this->folder                     = "front";

		//Nombre del view correspondiente a Google Analytics
		$this->google_analytics_view_name = '';

		//Para cargar el código de Google Analytics por defecto en todas la vistas
		$this->with_google_analytics      = false;
    }

	public function index()
	{
		//cargar el view
		$this->load_view( __FUNCTION__ );
	}

	public function mail()
	{
		$this->load->library('smtp');
		$this->load->library('phpmailer');
		$this->phpmailer->smtp = $this->smtp;

		//form validation vars
		$formok = true;
		$errors = array();
		
		//sumbission data
		$ipaddress = $this->input->server('REMOTE_ADDR');
		$date      = date('d/m/Y');
		$time      = date('H:i:s');
		
		//form data
		$name    = $this->input->post('name');	
		$email   = $this->input->post('mail');
		$subject = $this->input->post('subject');
		$message = $this->input->post('message');


		$this->phpmailer->IsSMTP();                                 	// send via SMTP
		$this->phpmailer->Host     = ""; 			// SMTP server
		$this->phpmailer->SMTPAuth = true;    							// turn on SMTP authentication
		$this->phpmailer->Username = ""; 			     		// SMTP username
		$this->phpmailer->Password = "";						// SMTP password

		$this->phpmailer->From     = "";		// SMTP username
		$this->phpmailer->AddAddress("");		// Your Adress
		$this->phpmailer->Subject  =  "";
		$this->phpmailer->IsHTML(true);  
		$this->phpmailer->CharSet = 'UTF-8';
		$this->phpmailer->Body     =  "";

		if(!$this->phpmailer->Send())
		{
		   echo "Mail Not Sent <p>";
		   echo "Mailer Error: " . $this->phpmailer->ErrorInfo;
		   exit;
		}

		echo "Mail Sent";
	}
}

/* End of file site.php */
/* Location: ./application/controllers/site.php */