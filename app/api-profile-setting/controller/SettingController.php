<?php
/**
 * SettingController
 * @package api-profile-setting
 * @version 0.0.1
 */

namespace ApiProfileSetting\Controller;

use Profile\Model\Profile;
use LibForm\Library\Form;

class SettingController extends \Api\Controller
{
    public function editAction(){
        if(!$this->profile->isLogin())
            return $this->resp(401);

        $types = [
            'account',
            'contact',
            'education',
            'general',
            'password',
            'profession',
            'social'
        ];
        $type = $this->req->param->type;
        if(!in_array($type, $types))
            return $this->show404();

        $form_name = 'api.profile.' . $type;
        $form = new Form($form_name);

        if(!($valid = $form->validate()))
            return $this->resp(422, $form->getErrors());

        $profile_set = (array)$valid;

        switch($type){
            case 'contact':
                foreach($profile_set as $key => $val){
                    if(false !== strstr($key, '-')){
                        $keys = explode('-', $key);
                        if(!isset($profile_set[$keys[0]]))
                            $profile_set[$keys[0]] = [];
                        $profile_set[$keys[0]][ $keys[1] ] = $val;
                        unset($profile_set[$key]);
                    }
                }
                break;
            case 'password':
                if(!password_verify($profile_set['old-password'], $this->profile->password)){
                    $form->addError('old-password', 0, 'The password is not correct');
                    return $this->resp(422, $form->getErrors());
                }

                if($profile_set['password'] != $profile_set['retype-password']){
                    $form->addError('retype-password', 0, 'Both password not match');
                    return $this->resp(422, $form->getErrors());
                }

                unset($profile_set['old-password']);
                unset($profile_set['retype-password']);

                $profile_set['password'] = password_hash($profile_set['password'], PASSWORD_DEFAULT);
                break;
        }

        // json encode
        $serialize_keys = [
            'contact',
            'educations',
            'profession',
            'socials'
        ];

        foreach($serialize_keys as $key){
            if(isset($profile_set[$key]))
                $profile_set[$key] = json_encode($profile_set[$key]);
        }

        // lowercase
        $lower_keys = ['email', 'name'];
        foreach($lower_keys as $key){
            if(isset($profile_set[$key]))
                $profile_set[$key] = strtolower($profile_set[$key]);
        }

        if($profile_set)
            Profile::set($profile_set, ['id'=>$this->profile->id]);
        
        $this->resp(0, 'success');
    }
}