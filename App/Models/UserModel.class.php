<?php

namespace app\Models;

use http\Header;

/**
 * User model for handling all related info about users
 * Handles authentication system for client (registering, logging in, log out)
 * Handles giving data about users
 * Singleton class
 * @author Václav Škopek
 */
class UserModel
{
    /**
     * @var UserModel|null User model instance
     */
    private static ?UserModel $userModel = null;

    /**
     * @var DatabaseModel Database model instance
     */
    private DatabaseModel $db;
    /**
     * @var SessionModel Session model instance
     */
    private SessionModel $session;

    /**
     * Super administrator role range
     */
    public const SUPER_ADMIN = 255;
    /**
     * Admin role range
     */
    public const ADMIN = 250;
    /**
     * Author role range
     */
    public const AUTHOR = 50;
    /**
     * Commenter role range
     */
    public const COMMENTER = 0;

    /**
     * Info about role names bound to role range
     */
    const STRING_ROLES = array(
        255=>"Super administrator",
        250=>"Administrator",
        50=>"Author",
        0=>"Commenter"
    );

    /**
     * Initializes new session model and obtains database model instance
     */
    private function __construct()
    {
        $this->db = DatabaseModel::getDatabase();
        $this->session = new SessionModel();
    }

    /**
     * Returns role number bound to its name
     * @param string $role Role name
     * @return int|null role number | null if invalid name
     */
    public static function roleToNumber(string $role): int|null
    {
        foreach(self::STRING_ROLES as $n => $r){
            if(strcmp($role, $r) == 0)
                return $n;
        }
        return null;
    }

    /**
     * @return UserModel Singleton method to return user model instance
     */
    public static function getUserModel(): UserModel
    {
        if(self::$userModel == null){
            self::$userModel = new UserModel();
        }

        return self::$userModel;
    }

    /**
     * Checks if $data contains info about registering client
     * @param array $data Data from submitted form
     * @return bool|array false if no data | user data
     */
    public function checkForRegister(array $data): bool|array
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

    /**
     * Checks if $data contains info about logging the client
     * @param array $data Data from submitted form
     * @return bool|array false if no data | user data
     */
    public function checkForLogin(array $data): bool|array
    {
        if (isset($data["username"]) && isset($data["password"]))
        {
            return $this->userLogin($data["username"], $data["password"]);
        }

        return false;
    }

    /**
     * Creates data for user and saves it into database
     * logs the user afterward
     * @param array $userData User data from submitted form
     * @return bool|string false if no id | id
     */
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

    /**
     * Verifies passwords and saves the user id into session
     * @param string $username Username
     * @param string $password Password
     * @return bool
     */
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

    /**
     * Selects and returns data of currently logged user
     * @return array|null User data | null if not logged
     */
    public function getCurrentUserData(): array | null
    {
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

    /**
     * Selects and returns data bound to the $userId
     * @param string $userId UserId
     * @return array|null User data | null
     */
    public function getUserData(string $userId): array | null
    {
        $statement = "SELECT * FROM user WHERE id_user=:id_user";

        $result = $this->db->prepareAndExecuteStatement($statement, array("id_user" => $userId));

        if (count($result) > 0) {
            return $result[0];
        }else{
            return null;
        }
    }

    /**
     * Updates
     * @param string $userId
     * @param int $role
     * @return void
     */
    public function updateUserRole(string $userId, int $role): void
    {
        $statement = "UPDATE user SET role=:role WHERE id_user=:id_user";

        $this->db->prepareAndExecuteStatement($statement, array(
            "id_user" => $userId,
            "role" => $role
        ));
    }

    /**
     * Selects and returns all user rows from database
     * @return array Users from database
     */
    public function getAllUsers(): array {
        $statement = "SELECT * FROM user";

        return $this->db->prepareAndExecuteStatement($statement, array());
    }

    /**
     * Logs the client out by removing his user ID from session
     * @return void
     */
    public function userLogout(): void
    {
        $this->session->removeKey("current_user_id");
    }

    /**
     * Returns if a user is currently logged by checking
     * whether session has user id set
     * @return bool
     */
    public function isUserLogged():bool{
        return $this->session->hasKey("current_user_id");
    }

    /**
     * Returns user id of currently logged user
     * null if the user isn't logged
     * @return int|null
     */
    public function getUserId(): int|null{
        if($this->isUserLogged()) {
            return $this->session->getValue("current_user_id");
        }

        return null;
    }
}