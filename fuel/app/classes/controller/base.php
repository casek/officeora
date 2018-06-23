<?php
/**
 * base controller of the ssbs for fuelphp
 *
 * @package     officeora
 * @version     1.0
 * @author      Keisuke Mutoh (Office ORA kmutoh@office-ora,com)
 * @license     MIT License
 * @copyright   2015 - Office ORA
 * @link        http://office-ora.com
 */

/**
 * base controller class
 *
 * @package     officeora
 */
class Controller_Base extends Controller_Template
{
    /**
     * template file
     *
     * @access  public
     * @var     string
     */
    public $template = 'layout.smarty';

    /**
     * the before oparation for this class
     *
     * @access  public
     */
    public function before()
    {
        parent::before();

        // check csrf token when posted some data.
        if(Input::method() == 'POST') {
            if(is_null(Input::post(Config::get('security.csrf_token_key'))) ||
               !Security::check_token()) {
                if(Input::uri() == '') {
                    Response::redirect(Uri::base(false));
                    exit;
                }
                header("HTTP/1.0 403 Forbidden");
                exit;
            }
        }
    }

    /**
     * proivide default page on this web application
     *
     * @access  public
     */
	public function action_index()
	{
        // build html contents
        $this->htmlheader();
        $this->htmlfooter();
        $this->template->header = $this->header();
        $this->template->menu01 = $this->menu01();
        $this->template->contents = $this->contents();
        $this->template->footer = $this->footer();
        /*
        $this->template->menu02 = $this->menu02();
        $this->template->sidebar01 = $this->sidebar01();
        $this->template->sidebar02 = $this->sidebar02();
        */
    }

    /**
     * logoff
     *
     * @access  public
     */
    public function action_logoff()
    {
        $ret = Model_Logic_LoginLogic::logoff();
        return Request::forge('page')->execute();
    }

    /**
     * proivide 404 error page on this web application
     *
     * @access  public
     */
    public function action_404()
    {
        $this->action_index();
        $data = array();
        $this->template->contents = View_Smarty::forge('pages/404',$data,false);
    }

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
                'assets/plugins/jpreloader/js/jpreloader.min.js',
                'assets/plugins/detectmobilebrowser/detectmobilebrowser.js',
                'assets/plugins/debouncer/debouncer.js',
                'assets/plugins/easing/jquery.easing.min.js',
                'assets/plugins/sticky/jquery.sticky.js',
                'assets/plugins/inview/jquery.inview.min.js',
                'assets/plugins/matchHeight/jquery.matchHeight-min.js',
                'assets/plugins/magnificPopup/jquery.magnific-popup.min.js',
                'assets/plugins/flexSlider/jquery.flexslider-min.js',
                'assets/plugins/countTo/jquery.countTo.js',
                'assets/plugins/validation/jquery.validate.min.js',
                'assets/plugins/validation/localization/messages_ja.min.js',
                'assets/plugins/select2/js/select2.full.min.js',
                'assets/plugins/morphext/morphext.min.js',
                'assets/plugins/loadmask/jquery.loadmask.min.js',
                'assets/js/main.js',
                'assets/js/text-rotator.js',
                'assets/js/contact.js',
                'assets/js/animation.js',
                'assets/js/webapp.js',
                'https://use.fontawesome.com/3804ecbfcb.js',
            ),
            'css'       => array(
                'https://fonts.googleapis.com/css?family=Lato:400,700',
                'https://fonts.googleapis.com/css?family=Raleway:400,700',
                'assets/plugins/bootstrap/css/bootstrap.min.css',
                'assets/plugins/icons-mind/style.css',
                'assets/plugins/jpreloader/css/jpreloader.css',
                'assets/plugins/animate-css/animate.min.css',
                'assets/plugins/magnificPopup/magnific-popup.css',
                'assets/plugins/flexSlider/flexslider.css',
                'assets/plugins/morphext/morphext.css',
                'assets/plugins/select2/css/select2.css',
                'assets/plugins/loadmask/jquery.loadmask.css',
                'assets/css/berg.css',
                'assets/css/colors/green.css',
                'assets/css/webapp.css',
            ),
            'iecss'     => array(
            ),
        );
    }

    /**
     * the default html footer
     *
     * @access  protected
     */
    protected function htmlfooter() {
        // config
        $configinfo = Config::get('app');
        $configinfo['baseurl'] = Config::get('base_url');
        $configinfo['cpath'] = Config::get('cookie.path');
        $configinfo['cexpire'] = Config::get('cookie.expiration');
        $configinfo['tokenname'] = Config::get('security.csrf_token_key');
        $this->template->parser()->assign('configinfo',json_encode($configinfo));

        // notification
        $notification = array();
        $msg = Session::get_flash('msg');
        if(!is_null($msg)) {
            $msg = explode(":",$msg);
            $notification[] = array(
                'type' => $msg[0],
                'msg' => $msg[1],
            );
        }
        $this->template->parser()->assign('notification',json_encode($notification));

        // csrf token
        $this->template->parser()->assign('csrftoken',Security::js_fetch_token());

    }

    /**
     * the default hader
     *
     * @access  protected
     * @return  string
     */
    protected function header() {
        return '';
    }

    /**
     * the default footer
     *
     * @access  protected
     * @return  string
     */
    protected function footer() {
        return '';
    }

    /**
     * the default menu01
     *
     * @access  protected
     * @return  string
     */
    protected function menu01() {
        return '';
    }

    /**
     * the default menu02
     *
     * @access  protected
     * @return  string
     */
    protected function menu02() {
        return '';
    }

    /**
     * the default sidebar01
     *
     * @access  protected
     * @return  string
     */
    protected function sidebar01() {
        return '';
    }

    /**
     * the default sidebar02
     *
     * @access  protected
     * @return  string
     */
    protected function sidebar02() {
        return '';
    }

    /**
     * the default contents
     *
     * @access  protected
     * @return  string
     */
    protected function contents() {
        return 'Default Page';
    }
}
