<?php

class AccountConfigWriter 
{
    public static function getInstance() 
    {
        return new AccountConfigWriter();
    }
    
    public function writeDefaultConfig($config)
    {
        $account = new Account();
        $account->name = $config['name'];
        $account->workingdays = '31';
        $account->type = 'unlimited';
        $account->save();
        
        // add timeitem types
        $tit = new TimeItemType();
        $tit->account_id = $account->id;
        $tit->name = 'DEV';
        $tit->save();
        
        $tit = new TimeItemType();
        $tit->account_id = $account->id;
        $tit->name = 'ADMIN';
        $tit->default_item = true;
        $tit->save();
        
        $admin_settings = new Setting();
        $admin_settings->theme = 'green';
        
        $admin = new User();
        $admin->Account = $account;
        $admin->administrator = true;
        $admin->username = $config['username'];
        $admin->password = md5($config['password']);
        $admin->Setting = $admin_settings;
        $admin->save();
        
        return $account->id;
    }
}
