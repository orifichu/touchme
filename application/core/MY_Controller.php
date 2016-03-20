<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    protected $data                       = array();
    protected $folder                     = "";
    protected $google_analytics_view_name = "";
    protected $with_google_analytics      = false;

    public function __construct()
    {
        parent::__construct();
    }

    protected function get_pathname( $view_name )
    {
        $folder = rtrim($this->folder, '/');
        if ( $folder != '' ) {
            $folder .= '/';
        }

        $pathname = $folder . $view_name;

        return $pathname;
    }

    protected function load_google_analytics_view( $view_name )
    {
        $this->data['google_analytics_view'] = $this->load->view(
            $this->get_pathname($view_name)
            , NULL
            , TRUE
        );
    }

    protected function load_language( $filename )
    {
        $language      = $this->config->item('language');
        $language_abbr = $this->config->item('language_abbr');

        //la variable "language_abbr" servirá para el lang del head del código html y para las rutas
        $this->data['language_abbr'] = $language_abbr;

        $this->lang->load( $this->get_pathname($filename), $language);

        $this->load->helper('language');
    }

    protected function load_view( $view_name )
    {
        //Cargar el archivo correspondiente al lenguaje del site. Las funciones relacionadas con el lenguaje serán obligatorias
        $this->load_language( $view_name );

        //Cargar la vista correspondiente a Google Analytics siempre y cuando se desee hacerlo y siempre y cuando dicha vista tenga nombre
        if ( $this->with_google_analytics && $this->google_analytics_view_name != '' ) {
            $this->load_google_analytics_view( $this->google_analytics_view_name );
        }

        //Cargar la vista 
        $this->load->view( $this->get_pathname($view_name), $this->data );
    }
}