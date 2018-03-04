<?php

namespace App\Providers;

use App\Language;
use App\Menu;
use App\Theme;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiseProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
//        $this->composerMenuTop();
//        $this->composerMobileMenuTop();
//        $this->composerMenu();
//        $this->composerSecMenu();
//        $this->composerIndexPage();
//        $this->composerPrimaryLanguage();
        $this->composerEleganzaMenu();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

//    private function composerMenuTop(){
//        $theme = Theme::where('active', 1)->first();
//        $leftTopMenu = Menu::find(1)->menuLinks()->where('menu_links.publish', 1)->where('menu_links.parent', 0)->orderBy('menu_links.order', 'ASC')->get();
//        $rightTopMenu = Menu::find(2)->menuLinks()->where('menu_links.publish', 1)->where('menu_links.parent', 0)->orderBy('menu_links.order', 'ASC')->get();
//        view()->composer('themes.'.$theme->slug.'.partials.header', function($view) use ($leftTopMenu, $rightTopMenu){
//            $view->with('leftTopMenu', $leftTopMenu)->with('rightTopMenu', $rightTopMenu);
//        });
//    }
//
//    private function composerMobileMenuTop(){
//        $theme = Theme::where('active', 1)->first();
//        $topMenu = Menu::find(1)->menuLinks()->where('publish', 1)->where('parent', 0)->orderBy('order', 'ASC')->get();
//        view()->composer('themes.'.$theme->slug.'.partials.mobile-menu', function($view) use ($topMenu){
//            $view->with('topMenu', $topMenu);
//        });
//    }
//
//    private function composerMenu(){
//        $theme = Theme::where('active', 1)->first();
//        $topMenu = Menu::find(1)->menuLinks()->where('publish', 1)->where('parent', 0)->orderBy('order', 'ASC')->get();
//        view()->composer('themes.'.$theme->slug.'.partials.nav', function($view) use ($topMenu){
//            $view->with('topMenu', $topMenu);
//        });
//    }
//
//    private function composerSecMenu(){
//        $theme = Theme::where('active', 1)->first();
//        $info = Menu::find(2)->menuLinks()->where('publish', 1)->where('parent', 0)->orderBy('order', 'ASC')->get();
//        view()->composer('themes.'.$theme->slug.'.partials.footer-up', function($view) use ($info){
//            $view->with('info', $info);
//        });
//    }
//
//    private function composerIndexPage(){
//        $theme = Theme::where('active', 1)->first();
//        $topCat = Menu::find(1)->menuLinks()->where('publish', 1)->where('parent', 0)->orderBy('order', 'ASC')->get();
//        view()->composer('themes.'.$theme->slug.'.*', function($view) use ($topCat){
//            $view->with('topCat', $topCat);
//        });
//    }
//
//    private function composerPrimaryLanguage(){
//        $theme = Theme::where('active', 1)->first();
//        $primary = Language::getPrimary();
//        view()->composer('themes.'.$theme->slug.'.*', function($view) use ($primary){
//            $view->with('primary', $primary);
//        });
//    }

    private function composerEleganzaMenu(){
        $theme = Theme::where('active', 1)->first();
        $menus = Menu::find(3)->menuLinks()->where('publish', 1)->where('parent', 0)->orderBy('order', 'ASC')->get();
        view()->composer('themes.'.$theme->slug.'.partials.header', function($view) use ($menus){
            $view->with('menus', $menus);
        });
        view()->composer('themes.'.$theme->slug.'.partials.mobile-menu', function($view) use ($menus){
            $view->with('menus', $menus);
        });
    }
}
