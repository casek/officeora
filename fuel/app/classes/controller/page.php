<?php
/**
 * The controller for top page
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
class Controller_Page extends Controller_Base
{
    /** 
     * the default header 
     *
     * @access  protected
     * @return  string
     */
    protected function header() {
        return View::forge('parts/head');
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
        return View::forge('pages/toppage');
    }

}
