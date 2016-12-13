<?php

namespace App\Http\Middleware;

use Menu;
use Closure;
use Entrust;

class LaravelMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //左側
        Menu::make('left', function ($menu) {
            /* @var \Lavary\Menu\Builder $menu */
            //$menu->add('Home', ['route' => 'index']);
            //$menu->add('About', 'javascript:void(0)');
            //$menu->add('Contact', 'javascript:void(0)');
        });
        //右側
        Menu::make('right', function ($menu) {
            /* @var \Lavary\Menu\Builder $menu */
            //會員
            if (auth()->check()) {
                if (!auth()->user()->isConfirmed) {
                    $menu->add('尚未完成信箱驗證', ['route' => 'confirm-mail.resend'])
                        ->link->attr(['class' => 'text-danger']);
                }
                //管理員
                if (Entrust::can('menu.view') and auth()->user()->isConfirmed) {
                    /** @var \Lavary\Menu\Builder $isweekMenu */
                    $isweekMenu = $menu->add('資安週管理', 'javascript:void(0)');
                    if (Entrust::can('quotation.manage')) {
                        $isweekMenu->add('資安語錄', ['route' => 'quotation.index'])->active('quotation/*');
                    }
                    if (Entrust::can('question.manage')) {
                        $isweekMenu->add('題目管理', ['route' => 'question.index'])->active('question/*');
                    }
                    if (Entrust::can('player.manage')) {
                        $isweekMenu->add('玩家管理', ['route' => 'player.index'])->active('player/*');
                    }

                    if (Entrust::can('qualification.manage')) {
                        $isweekMenu->add('抽獎資格', ['route' => 'qualification.index'])->active('qualification/*');
                    }

                    /** @var \Lavary\Menu\Builder $adminMenu */
                    $adminMenu = $menu->add('管理選單', 'javascript:void(0)');

                    if (Entrust::can(['user.manage', 'user.view'])) {
                        $adminMenu->add('會員清單', ['route' => 'user.index'])->active('user/*');
                    }

                    if (Entrust::can('role.manage')) {
                        $adminMenu->add('角色管理', ['route' => 'role.index']);
                    }

                    if (Entrust::can('fb-bot.manage') && config('fb-messenger.debug')) {
                        $adminMenu->add(
                            'FBBot除錯面板 <i class="fa fa-external-link" aria-hidden="true"></i>',
                            ['route' => 'fb-bot.debug']
                        )->link->attr('target', '_blank');
                    }

                    if (Entrust::can('log-viewer.access')) {
                        $adminMenu->add(
                            '記錄檢視器 <i class="fa fa-external-link" aria-hidden="true"></i>',
                            ['route' => 'log-viewer::dashboard']
                        )->link->attr('target', '_blank');
                    }
                }
                /** @var \Lavary\Menu\Builder $userMenu */
                $userMenu = $menu->add(auth()->user()->name, 'javascript:void(0)');
                $userMenu->add('個人資料', ['route' => 'profile'])->active('profile/*');
                $userMenu->add('登出', ['route' => 'logout']);
            } else {
                //遊客
                $menu->add('登入', ['route' => 'login']);
            }
        });

        return $next($request);
    }
}
