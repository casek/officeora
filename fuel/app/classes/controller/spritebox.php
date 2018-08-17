<?php
/**
 * The controller for spritebox.io page
 *
 * @package     officeora
 * @version     1.0
 * @author      Keisuke Mutoh (Office ORA kmutoh@office-ora,com)
 * @license     MIT License
 * @copyright   2015 - Office ORA
 * @link        http://office-ora.com
 */

/**
 * The controller class for top page
 *
 * @package     officeora
 */
class Controller_Spritebox extends Controller_Base
{
  /**
   * the default html header
   *
   * @access  protected
   */
  protected function htmlheader() {
      $this->template->basicinfo = array(
          'lang'      => Config::get('language'),
          'title'     => Config::get('app.title_base'),
          'baseurl'   => Config::get('base_url'),
          'canonical' => Config::get('base_url'),
          'app_name'  => Config::get('app.app_name'),
          'author'    => Config::get('app.author'),
          'generator' => "SSBS for FuelPHP",
          'desc'      => Config::get('app.description'),
          'keywords'  => Config::get('app.keywords'),
          'token_name'=> Config::get('security.csrf_token_key'),
      );
      $this->template->assets = array(
          'js'        => array(
              'assets/plugins/jquery.min.js',
              'assets/plugins/bootstrap/js/bootstrap.min.js',
              'assets/js/webapp.js',
              'https://use.fontawesome.com/3804ecbfcb.js',
          ),
          'css'       => array(
              'https://fonts.googleapis.com/css?family=Lato:400,700',
              'https://fonts.googleapis.com/css?family=Raleway:400,700',
              'assets/plugins/bootstrap/css/bootstrap.min.css',
              'assets/plugins/icons-mind/style.css',
              'assets/css/berg.css',
              'assets/css/colors/green.css',
              'assets/css/webapp.css',
          ),
          'iecss'     => array(
          ),
      );
  }

    /**
     * the default header
     *
     * @access  protected
     * @return  string
     */
    protected function header() {
        return View::forge('parts/head_general');
    }

    /**
     * the default footer
     *
     * @access  protected
     * @return  string
     */
    protected function footer() {
        $data = array(
            'csrf_token' => Security::fetch_token(),
        );
        return View::forge('parts/foot',$data);
    }

    /**
     * the default menu01
     *
     * @access  protected
     * @return  string
     */
    protected function menu01() {
        return View::forge('parts/navigation');
    }

    /**
     * the top page contents
     *
     * @access  protected
     * @return  string
     */
    protected function contents() {
      $data = array();
      return View_Smarty::forge('pages/spritebox',$data,false);;
    }

}
