<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{

	protected function initialize()
    {
        //Javascripts in the footer
        $this->assets
            ->collection('footerjs')
            ->addJs('js/jquery.min.js')
            ->addJs('js/bootstrap.min.js')
            ->addJs('js/main.js')
            ->addFilter(new Phalcon\Assets\Filters\Jsmin())
            ->join(true)
            ->setTargetPath('js/final.js')
            ->setTargetUri('js/final.js');

        //Css in the header
        $this->assets
            ->collection('headercss')
            ->addCss('css/bootstrap.min.css')
            ->addCss('css/style.css')
           // ->addCss('css/font-awesome.min.css')
            ->addFilter(new Phalcon\Assets\Filters\Cssmin())
            ->join(true)
            ->setTargetPath('css/final.css')
            ->setTargetUri('css/final.css');

         
        // bootstrap dashboard template css   
        $this->assets
             ->collection('mainpagecss')
             ->addCss('css/dashboard.css')
             ->setTargetPath('css/dashboard.css')
             ->setTargetUri('css/dashboard.css');
            
        // bootstrap dashboard template js 
        $this->assets
             ->collection('mainpagejs')
             ->addJs('js/jquery.js')
             ->setTargetPath('js/jquery.js')
             ->setTargetUri('js/jquery.js');

        //date picker bootstrap css
        $this->assets
             ->collection('datepickercss')
             ->addCss('css/datepicker.css')
             ->addCss('css/datepicker.less')
             ->setTargetPath('css/datepicker.css')
             ->setTargetUri('css/datepicker.css');

        //date picker bootstrap js
        $this->assets
             ->collection('datepickerjs')
             ->addJs('js/bootstrap-datepicker.js')
             ->setTargetPath('js/bootstrap-datepicker.js')
             ->setTargetUri('js/bootstrap-datepicker.js');

        //Clock picker bootstrap css
        $this->assets
             ->collection('clockpickercss')
             ->addCss('css/clockpicker.css')
             ->setTargetPath('css/clockpicker.css')
             ->setTargetUri('css/clockpicker.css');

        //Clock picker bootstrap js
        $this->assets
             ->collection('clockpickerjs')
             ->addJs('js/clockpicker.js')
             ->setTargetPath('js/clockpicker.js')
             ->setTargetUri('js/clockpicker.js');


        $this->assets
             ->collection('countupcss')             
             ->addCss('css/jquery.countup.css')
             ->setTargetPath('css/jquery.countup.css')
             ->setTargetUri('css/jquery.countup.css');


        $this->assets
             ->collection('countupjs')
             ->addJs('js/jquery.countup.js')
             ->setTargetPath('js/jquery.countup.js')
             ->setTargetUri('js/jquery.countup.js');

        $this->assets
             ->collection('validatejs')
             ->addJs('js/jquery.validate.min.js')
             ->setTargetPath('js/jquery.validate.min.js')
             ->setTargetUri('js/jquery.validate.min.js');

        $this->tag->prependTitle('eAttendance | ');
        $this->view->setTemplateAfter('main');
    }

}
