<?php

class TokenTable extends Doctrine_Table
{

    public static function getInstance()
    {
        return Doctrine_Core::getTable('Token');
    }

    /**
     * @param integer $user_id
     */
    public function deleteAutologinTokens($user_id)
    {
        Doctrine_Query::create()->delete('Token t')
                ->where('t.user_id=? AND t.action=?',
                        array($user_id, Token::$ACTION_AUTOLOGIN))
                ->execute();
    }

    /**
     * @param integer $user_id
     * @return Token
     */
    public function createAutologinToken($user_id)
    {
        $token = new Token();
        $token->setUserId($user_id);
        $token->setAction(Token::$ACTION_AUTOLOGIN);

        return $token;
    }
}