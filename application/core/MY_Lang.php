<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Language Identifier
* 
* Adds a language identifier prefix to all site_url links
* 
* @copyright     Copyright (c) 2011 Wiredesignz
* @version         0.29
* 
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
* 
* The above copyright notice and this permission notice shall be included in
* all copies or substantial portions of the Software.
* 
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
* THE SOFTWARE.
*/
class MY_Lang extends CI_Lang
{
    function __construct() {

        global $URI, $CFG, $IN;

        $config =& $CFG->config;

        $index_page    = $config['index_page'];
        $lang_ignore   = $config['lang_ignore'];
        //$default_abbr  = $config['language_abbr'];
        $lang_uri_abbr = $config['lang_uri_abbr'];

        /* definir la variable $default_abbr si existe una cookie */
        if ( $IN->cookie($config['cookie_prefix'].'user_lang') ) {
            $default_abbr  = $IN->cookie($config['cookie_prefix'].'user_lang');
        } else {
            //array de idiomas original
            $langs = array(
                    'en-US',// El predeterminado
                    'fr',
                    'fr-FR',
                    'de',
                    'de-DE',
                    'de-AT',
                    'de-CH',
                    'es-ES',
                    'es',
            );

            //array de idiomas simplificado
            $langs = array(
                    'en-US',// El predeterminado
                    'es-ES',
                    'es',
            );

            $default_abbr = $this->prefered_language($langs);
            $default_abbr = strtolower( $default_abbr );

            //por si acaso se escoge un string de más de 2 letras
            if ( $default_abbr == 'en-us' ) $default_abbr = 'en';
            if ( $default_abbr == 'es-es' ) $default_abbr = 'es';
        }

        /* get the language abbreviation from uri */
        $uri_abbr = $URI->segment(1);

        /* adjust the uri string leading slash */
        $URI->uri_string = preg_replace("|^\/?|", '/', $URI->uri_string);

        if ($lang_ignore) {

            if (isset($lang_uri_abbr[$uri_abbr])) {

                /* set the language_abbreviation cookie */
                $IN->set_cookie('user_lang', $uri_abbr, $config['sess_expiration']);

            } else {

                /* get the language_abbreviation from cookie */
                $lang_abbr = $IN->cookie($config['cookie_prefix'].'user_lang');

            }

            if (strlen($uri_abbr) == 2) {

                /* reset the uri identifier */
                $index_page .= empty($index_page) ? '' : '/';

                /* remove the invalid abbreviation */
                $URI->uri_string = preg_replace("|^\/?$uri_abbr\/?|", '', $URI->uri_string);

                /* redirect */
                header('Location: '.$config['base_url'].$index_page.$URI->uri_string);
                exit;
            }

        } else {

            /* set the language abbreviation */
            $lang_abbr = $uri_abbr;
        }

        /* check validity against config array */
        if (isset($lang_uri_abbr[$lang_abbr])) {

           /* reset uri segments and uri string */
           $URI->_reindex_segments(array_shift($URI->segments));
           $URI->uri_string = preg_replace("|^\/?$lang_abbr|", '', $URI->uri_string);

           /* set config language values to match the user language */
           $config['language'] = $lang_uri_abbr[$lang_abbr];
           $config['language_abbr'] = $lang_abbr;

           /* if abbreviation is not ignored */
           if ( ! $lang_ignore) {

                   /* check and set the uri identifier */
                   $index_page .= empty($index_page) ? $lang_abbr : "/$lang_abbr";

                /* reset the index_page value */
                $config['index_page'] = $index_page;
           }

           /* set the language_abbreviation cookie */               
           $IN->set_cookie('user_lang', $lang_abbr, $config['sess_expiration']);

        } else {

            /* if abbreviation is not ignored */   
            if ( ! $lang_ignore) {                   

                   /* check and set the uri identifier to the default value */    
                $index_page .= empty($index_page) ? $default_abbr : "/$default_abbr";

                if (strlen($lang_abbr) == 2) {

                    /* remove invalid abbreviation */
                    $URI->uri_string = preg_replace("|^\/?$lang_abbr|", '', $URI->uri_string);
                }

                /* redirect */
                header('Location: '.$config['base_url'].$index_page.$URI->uri_string);
                exit;
            }

            /* set the language_abbreviation cookie */                
            $IN->set_cookie('user_lang', $default_abbr, $config['sess_expiration']);
        }

        log_message('debug', "Language_Identifier Class Initialized");
    }

    //Extraer el lenguaje que ha sido configurado como preferido en el navegador del usuario
    function prefered_language($available_languages,$http_accept_language="auto") { 
        // if $http_accept_language was left out, read it from the HTTP-Header 
        if ($http_accept_language == "auto") $http_accept_language = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : ''; 

        // standard  for HTTP_ACCEPT_LANGUAGE is defined under 
        // http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.4 
        // pattern to find is therefore something like this: 
        //    1#( language-range [ ";" "q" "=" qvalue ] ) 
        // where: 
        //    language-range  = ( ( 1*8ALPHA *( "-" 1*8ALPHA ) ) | "*" ) 
        //    qvalue         = ( "0" [ "." 0*3DIGIT ] ) 
        //            | ( "1" [ "." 0*3("0") ] ) 
        preg_match_all("/([[:alpha:]]{1,8})(-([[:alpha:]|-]{1,8}))?" . 
                       "(\s*;\s*q\s*=\s*(1\.0{0,3}|0\.\d{0,3}))?\s*(,|$)/i", 
                       $http_accept_language, $hits, PREG_SET_ORDER); 

        // default language (in case of no hits) is the first in the array 
        $bestlang = $available_languages[0]; 
        $bestqval = 0; 

        foreach ($hits as $arr) { 
            // read data from the array of this hit 
            $langprefix = strtolower ($arr[1]); 
            if (!empty($arr[3])) { 
                $langrange = strtolower ($arr[3]); 
                $language = $langprefix . "-" . $langrange; 
            } 
            else $language = $langprefix; 
            $qvalue = 1.0; 
            if (!empty($arr[5])) $qvalue = floatval($arr[5]); 
          
            // find q-maximal language  
            if (in_array($language,$available_languages) && ($qvalue > $bestqval)) { 
                $bestlang = $language; 
                $bestqval = $qvalue; 
            } 
            // if no direct hit, try the prefix only but decrease q-value by 10% (as http_negotiate_language does) 
            else if (in_array($langprefix,$available_languages) && (($qvalue*0.9) > $bestqval)) { 
                $bestlang = $langprefix; 
                $bestqval = $qvalue*0.9; 
            } 
        } 
        return $bestlang; 
    }
}