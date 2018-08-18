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
          'title'     => "Spritebox.IO - ".Config::get('app.title_base'),
          'baseurl'   => Config::get('base_url'),
          'canonical' => Config::get('base_url')."spritebox/",
          'app_name'  => Config::get('app.app_name'),
          'author'    => Config::get('app.author'),
          'generator' => "SSBS for FuelPHP",
          'desc'      => "Office ORAが運営するオンラインサービスSpritebox.IOの概要のご説明",
          'keywords'  => "Spritebox.IO, CSS, CSS Sprite, Image, Picture, 画像, Office ORA",
          'token_name'=> Config::get('security.csrf_token_key'),
          'ogp'       => array(
            'url' => Config::get('base_url')."spritebox/",
            'title' => "Spritebox.IO - ".Config::get('app.title_base'),
            'type' => 'website',
            'description' => "Office ORAが運営するオンラインサービスSpritebox.IOの概要のご説明",
            'image' => Config::get('base_url').'assets/img/spritebox/spritebox.png',
            'name' => "Spritebox.IO - ".Config::get('app.title_base'),
            'locale' => 'ja_JP',
            'twitter_card' => 'summary',
            'twitter_site' => '@officeora',
            'fb_appid' => "318069015433860",
          )
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
