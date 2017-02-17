<?php
	
class Mailer extends CI_Model {
	
	
	function Send($email, $subject, $template, $data){
		
		$this->load->library('email');
		
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = $this->system->config('mail_server');
		$config['smtp_port'] = $this->system->config('mail_port');
		$config['smtp_pass'] = $this->system->config('mail_password');
		$config['smtp_user'] = $this->system->config('mail_sender_email');
		$config['mailtype'] = 'html';
		
		$this->email->initialize($config);
		
		$this->email->set_newline("\r\n");

		$this->email->from($this->system->config('mail_sender_email'), $this->system->config('mail_sender_name'));
		$this->email->to($email);
		$this->email->bcc($this->system->config('mail_bcc'));
		
		if ($reply_to){
			$this->email->reply_to($reply_to);
		}
		
		$this->email->subject($subject);
		$this->email->message($this->load->view('email_templates/'.$template, $data, true));
		$this->email->send();
		
		$debug = true;
		
		if ($debug){
			$res = fopen('email_debug/'.$email.'-'.$subject.'-'.time().'.txt', 'w+');
			fwrite($res, $message);
			fclose($res);
			
			$res = fopen('email_debug/'.$email.'-'.$subject.'-'.time().'_debugger.txt', 'w+');
			fwrite($res, $this->email->print_debugger());
			fclose($res);

		}
	}
}