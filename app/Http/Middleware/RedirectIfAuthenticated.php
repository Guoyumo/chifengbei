<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;
use \App\Http\Controllers\WechatService;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $url = $request->url();
        if(preg_match('/login/',  $url) || preg_match('/admin\//',  $url)){
            return $next($request);
        }
        $userInfo = $request->session()->get('userInfo');
        $wechat_config = \App::make('config')->get('services.wechat', []);
        extract($wechat_config);
        $wx = new WechatService();

        if(!empty($userInfo) && !empty($userInfo['openid'])){
            return $next($request);
        }
        $code = $request->input("code","");
        
       //first access
        if (empty($code)) {
            $redirectUrl = $this->getRedirectURL($request);
            header('location: https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$APPID.'&redirect_uri='.$redirectUrl.'&response_type=code&scope=snsapi_userinfo#wechat_redirect');
            exit;
        } else {
            $returned = $wx->getOAuthAccessToken($request);
            if (!isset($returned['access_token']) || !isset($returned['openid'])) {
            dd('what is going on?');
            }
            
            $user_info = $wx->getUserInfo($returned['openid']);

            if (!isset($user_info['openid'])) {
                dd($user_info);
            }
            $request->session()->put('userInfo', $user_info);
        }

        return $next($request);
    }

    private function getRedirectURL($request) {
       
            $redirect_uri = $request->url();
          
        
        return urlencode($redirect_uri);
    }

}
