<?php

declare(strict_types=1);

session_start();

class SessionUser
{
    /**
     * name of the session
     */
    const SESSION_NAME = 'user_info';
    
    /**
     * The id of the user
     */
    public int $id;

    /**
     * The username of the user
     */
    public string $username;

    /**
     * Set default values
     */
    function __construct()
    {
        $this->id = 0;
        $this->username = "";

        $serialData = $_SESSION[self::SESSION_NAME] ?? "";
        if ($serialData != "") {
            try {
                $userData = unserialize($serialData);

                $this->id = $userData[0];
                $this->username = $userData[1];
            } finally {
                //do nothing
            }
        } 
    }

    /**
     * @return boolean
     */
    public function isLogged() : bool 
    {
        // Returns true or false depending on if the id is greater than 0 or not
        return $this->id > 0;
    }

    /**
     * @return void
     */
    public function save() : void 
    {
        $userData = array($this->id, $this->username);
        $serialData = serialize($userData);
        $_SESSION[self::SESSION_NAME] = $serialData;
    }

    /**
     * @return void
     */
    public function clear() : void 
    {
        $_SESSION[self::SESSION_NAME] = null;

        $this->id = 0;
        $this->username = "";
    }
}