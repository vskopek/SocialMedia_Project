<?php

namespace app\Models;

class UserModel
{
    private static ?UserModel $userModel = null;

    private DatabaseModel $db;
    private SessionModel $session;

    public const SUPER_ADMIN = 255;
    public const ADMIN = 250;
    public const AUTHOR = 50;
    public const COMMENTER = 0;

    const STRING_ROLES = array(
        255=>"Super administrator",
        250=>"Administrator",
        50=>"Author",
        0=>"Commenter"
    );

    private function __construct()
    {
        $this->db = DatabaseModel::getDatabase();
        $this->session = new SessionModel();
    }

    public static function getUserModel(): UserModel
    {
        if(self::$userModel == null){
            self::$userModel = new UserModel();
        }

        return self::$userModel;
    }

    public function checkForRegister(array $data): bool|string|null
    {
        if(!empty($data["register"])) {
            if (isset($data["username"]) && isset($data["password"]) && isset($data["email"])
                && isset($data["firstname"]) && isset($data["lastname"])) {
                unset($data["register"]);
                return $this->registerUser($data);
            }
        }

        return false;
    }

    public function checkForLogin(array $data): bool|string|null
    {
        if (isset($data["username"]) && isset($data["password"]))
        {
            return $this->userLogin($data["username"], $data["password"]);
        }

        return false;
    }

    public function registerUser(array $userData): bool|string
    {
        $vanillaPassword = $userData["password"];
        $userData["password"] = password_hash($userData["password"], PASSWORD_BCRYPT);
        $statement = "INSERT INTO user (username, password, firstname, lastname, email)
                        VALUES (:username, :password, :firstname, :lastname, :email)";



        $this->db->prepareAndExecuteStatement($statement, $userData);

        $this->userLogin($userData["username"], $vanillaPassword);

        return $this->db->returnLastInsertID();
    }

    public function userLogin(string $username, string $password): bool
    {
        $statement = "SELECT * FROM user WHERE username=:username";

        $result = $this->db->prepareAndExecuteStatement($statement, array("username"=>$username));

        if(count($result) > 0){
            $userData = $result[0];

            if(password_verify($password, $userData["password"])){
                $this->session->setValue("current_user_id", $userData["id_user"]);
                return true;
            }
        }
        return false;
    }

    public function getCurrentUserData(){
        if($this->isUserLogged()) {
            $userId = $this->session->getValue("current_user_id");

            if($userId == null){
                $this->userLogout();
                return null;
            }

            $statement = "SELECT * FROM user WHERE id_user=:id_user";

            $result = $this->db->prepareAndExecuteStatement($statement, array("id_user" => $userId));

            if (count($result) > 0) {
                return $result[0];
            }else{
                $this->userLogout();
                return null;
            }
        }
        return null;
    }

    public function getUserData($userId){
        $statement = "SELECT * FROM user WHERE id_user=:id_user";

        $result = $this->db->prepareAndExecuteStatement($statement, array("id_user" => $userId));

        if (count($result) > 0) {
            return $result[0];
        }else{
            return null;
        }
    }

    public function userLogout(): void
    {
        $this->session->removeKey("current_user_id");
    }

    public function isUserLogged():bool{
        return $this->session->hasKey("current_user_id");
    }
}