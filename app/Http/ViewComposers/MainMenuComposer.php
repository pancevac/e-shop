<?php
/**
 * Created by PhpStorm.
 * User: sile
 * Date: 19.10.18.
 * Time: 03.12
 */

namespace App\Http\ViewComposers;


use App\Helpers\BasicHelper;
use App\MenuLink;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class MainMenuComposer
{
    /**
     * MainMenu cached collection.
     *
     * @var mixed
     */
    protected $mainMenu;

    /**
     * Create a new MainMenu composer.
     *
     * MainMenuComposer constructor.
     */
    public function __construct()
    {
        // Get cached mainMenu collection
        $this->mainMenu = Cache::remember('mainMenu', BasicHelper::getMinutesToTheNextHour(), function () {
            return MenuLink::getMenuLinkSort(1);
        });
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('mainMenu', $this->mainMenu);
    }
}