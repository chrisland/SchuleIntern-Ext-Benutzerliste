<?php
/**
 *
 */
class extUserlistModelList
{

    /**
     * @var data []
     */
    private $data = [];

    private $members = false;
    private $owners = false;

    private $members_stats = [
        'count' => 0,
        'isEltern' => 0,
        'isPupil' => 0,
        'isTeacher' => 0,
        'isNone' => 0
    ];


    /**
     * Constructor
     * @param $data
     */
    public function __construct($data = false)
    {
        if (!$data) {
            $data = $this->data;
        }
        $this->setData($data);
    }

    /**
     * @return data
     */
    public function setData($data = [])
    {
        $this->data = $data;
        return $this->getData();
    }

    /**
     * @return data
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @return
     */
    public function getStatsMember() {
        return $this->members_stats;
    }

    /**
     * Getter
     */
    public function getID() {
        return $this->data['id'];
    }
    public function getCreatedTime() {
        return $this->data['createdTime'];
    }
    public function getCreatedBy() {
        return $this->data['createdBy'];
    }
    public function getTitle() {
        return $this->data['title'];
    }

    public function getMembers() {
        if ( !$this->members ) {
            $this->loadMembers();
        }
        return $this->members;
    }

    public function loadMembers() {
        $this->members = [];
        $dataSQL = DB::getDB()->query("SELECT * FROM ext_userlist_list_members WHERE list_id = ".$this->getID() );
        while ($data = DB::getDB()->fetch_array($dataSQL, true)) {
            $user = user::getUserByID($data['user_id']);
            if (isset($this->members_stats[$user->getUserTyp(true)])) {
                $this->members_stats[$user->getUserTyp(true)]++;
            }
            $this->members[] = $user;
        }
    }

    public function getOwners() {
        if ( !$this->owners ) {
            $this->loadOwners();
        }
        return $this->owners;
    }

    public function loadOwners() {
        $this->owners = [];
        $dataSQL = DB::getDB()->query("SELECT * FROM ext_userlist_list_owner WHERE list_id = ".$this->getID() );
        while ($data = DB::getDB()->fetch_array($dataSQL, true)) {
            $this->owners[] = user::getUserByID($data['user_id']);
        }
    }

    public function getCollection() {

        $collection = [
            "id" => $this->getID(),
            "title" => $this->getTitle()
        ];

        return $collection;
    }



    /**
     * @return Array[]
     */
    public static function getAllByOwner($user_id) {

        if (!$user_id) {
            return false;
        }
        $ret =  [];
        $dataSQL = DB::getDB()->query("SELECT  b.*
            FROM ext_userlist_list_owner as a
            LEFT JOIN ext_userlist_list as b ON a.list_id = b.id
            WHERE a.user_id =  ".(int)$user_id);
        while ($data = DB::getDB()->fetch_array($dataSQL, true)) {
            $ret[] = new self($data);
        }
        return $ret;
    }



}